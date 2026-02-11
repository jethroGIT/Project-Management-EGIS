<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkOrder;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Hitung total Work Order yang tersedia
        $totalWorkOrders = WorkOrder::with(['workPackageVolumes' => function($query) {
            $query->with('workPackage')
                ->whereNotNull('startDate')
                ->whereNotNull('endDate')
                ->whereNotNull('executionYear');
        }])
        ->whereHas('workPackageVolumes', function($query) {
            $query->whereNotNull('startDate')
                ->whereNotNull('endDate')
                ->whereNotNull('executionYear');
        })
        ->count();

        // Data untuk card Work Package yang sudah dipanggil WO
        $workPackageWOAssignmentData = $this->getWorkPackageWOAssignment();

        // Perbandingan nilai uang
        // Data untuk progress bar WO keluar dengan total keseluruhan
        $projectFinanceComparisonData = $this->getProjectFinanceComparison();
        // Data untuk progress bar WO selesai dengan WO yang baru keluar berdasarkan nilai keuangan
        $woCompletionFinanceData = $this->getWOCompletionFinance();

        // Data untuk pie chart WP Completion dari WP yang sudah dipanggil WO
        $pieChartDataWo = $this->getWPCompletionFromAssignedWP();

        // Data untuk dropdown tahun
        $availableYears = $this->getAvailableYears();
        // Dapatkan selected year (default current year)
        $selectedYear = $request->get('year', Carbon::now()->year);
        // Data untuk WP Progress Bar Chart berdasarkan kombinasi WO dan WP
        $wpProgressBarChartData = $this->getWPProgressByWOChartData($selectedYear);

        // Data Bar chart total work package dari SDM (User)
        $userWorkPackageData = $this->getUserWithWorkPackage();

        $barChartWpSDMData = [
            'labels' => $userWorkPackageData->pluck('name')->toArray(),
            'data' => $userWorkPackageData->pluck('trs_workPackage_count')->toArray(),
            'details' => $userWorkPackageData->toArray(),
            'total_users' => $userWorkPackageData->count()
        ];

        // Get execution years for the period diagram filter
        $executionYear = WorkPackageVolume::whereNotNull(['endDate', 'workOrder_id'])
            ->distinct()
            ->orderBy('executionYear', 'asc')
            ->pluck('executionYear');
            
        $wpvWithPeriod = WorkPackageVolume::whereNotNull('trs_workPackVolume.endDate')
            ->whereNotNull('trs_workPackVolume.workOrder_id')
            ->where('trs_workPackVolume.executionYear', $selectedYear)
            ->with(['workPackage', 'workOrder', 'task.subTask'])
            ->join('mst_workOrder as wo_sort', 'trs_workPackVolume.workOrder_id', '=', 'wo_sort.workOrder_id')
            ->orderByRaw('CAST(wo_sort.workNumber_id AS SIGNED) ASC')
            ->select('trs_workPackVolume.*')
            ->get();
        
        $groupedByWo = $wpvWithPeriod->groupBy('workOrder_id');
        $woGroups = collect();

        foreach ($groupedByWo as $woId => $volumes) {
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0.0;

            $startDates = [];
            $endDates = [];
            $wpNumbers = [];

            foreach ($volumes as $volume) {
                // collect period bounds
                if ($volume->startDate) $startDates[] = $volume->startDate;
                if ($volume->endDate) $endDates[] = $volume->endDate;

                // collect WP numbers
                $wpNum = optional($volume->workPackage)->workPack_number;
                if ($wpNum) $wpNumbers[$wpNum] = true;

                // get tasks (use eager loaded relationship if present)
                $tasks = $volume->task ?? collect();
                // if relation not loaded, fallback to query
                if ($tasks instanceof \Illuminate\Database\Eloquent\Collection === false) {
                    $tasks = Task::where('volume_id', $volume->volume_id)->with('subTask')->get();
                }

                foreach ($tasks as $task) {
                    $taskCompleteness = null;
                    if ($task->completeness !== null) {
                        $taskCompleteness = floatval($task->completeness);
                    } else {
                        // compute from sub tasks
                        $subTasks = $task->subTask ?? collect();
                        if ($subTasks->count() > 0) {
                            $subsAvg = $subTasks->avg(function($st) {
                                return $st->completeness !== null ? floatval($st->completeness) : 0;
                            });
                            $taskCompleteness = floatval($subsAvg);
                        }
                    }

                    if ($taskCompleteness !== null) {
                        $totalTasksCompleteness += $taskCompleteness;
                        $totalTasksCount++;
                    }
                }
            }

            $groupPerformance = $totalTasksCount > 0
                ? round($totalTasksCompleteness / $totalTasksCount, 2)
                : 0.0;

            // determine group period (earliest start, latest end)
            $groupStart = count($startDates) ? collect($startDates)->min() : null;
            $groupEnd = count($endDates) ? collect($endDates)->max() : null;

            $woNumber = optional($volumes->first()->workOrder)->workNumber_id ?? $woId;

            $woGroups->push((object)[
                'workOrder_id' => $woId,
                'workNumber_id' => $woNumber,
                'startDate' => $groupStart,
                'endDate' => $groupEnd,
                'performance' => $groupPerformance,
                'workPack_numbers' => array_values(array_keys($wpNumbers)),
                'volumes' => $volumes, // include volumes if view needs details
            ]);
        }

        return view('dashboard', compact(
            'totalWorkOrders',
            'workPackageWOAssignmentData',
            'projectFinanceComparisonData',
            'woCompletionFinanceData',
            'pieChartDataWo',
            'availableYears',
            'selectedYear',
            'wpProgressBarChartData',
            'barChartWpSDMData',
            'executionYear',
            'woGroups',
        ));
    }

    /**
     * Get total Work Package WO assignment
     */
    private function getWorkPackageWOAssignment()
    {
        try {
            // Hitung total Work Package yang ada
            $totalWorkPackages = WorkPackage::count();

            // Hitung Work Package yang sudah memiliki Work Order
            $wpWithWorkOrder = WorkPackage::whereHas('workPackageVolumes', function($query) {
                $query->whereNotNull('workOrder_id');
            })->count();

            // Hitung Work Package yang belum memiliki Work Order
            $wpWithoutWorkOrder = $totalWorkPackages - $wpWithWorkOrder;

            return [
                'assigned' => $wpWithWorkOrder,
                'total' => $totalWorkPackages,
                'unassigned' => $wpWithoutWorkOrder
            ];

        } catch (Exception $e) {
            Log::error('Error in getWorkPackageWOAssignmentData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'assigned' => 0,
                'total' => 0,
                'unassigned' => 0
            ];
        }
    }

    // CATATAN : TIDAK DIPAKAI
    /**
     * Get Work Package completion data
     */
    private function getWorkPackageCompletionData()
    {
        try {
            // Ambil semua Work Package yang memiliki volume
            $workPackagesWithVolumes = WorkPackage::with([
                'workPackageVolumes.task.subTask'
            ])
            ->whereHas('workPackageVolumes')
            ->get();

            $completedWorkPackages = 0;
            $totalWorkPackages = $workPackagesWithVolumes->count();
            $wpCompletionDetails = [];

            foreach ($workPackagesWithVolumes as $wp) {
                $volumeCompletions = [];
                $totalVolumeCompletion = 0;
                $volumeCount = $wp->workPackageVolumes->count();

                // Hitung completion untuk setiap volume dalam WP ini
                foreach ($wp->workPackageVolumes as $volume) {
                    $volumeCompletion = $this->calculateVolumeCompletion($volume->volume_id);
                    $volumeCompletions[] = $volumeCompletion;
                    $totalVolumeCompletion += $volumeCompletion;
                }

                // Rata - rata completion untuk WP ini
                $avgWpCompletion = $volumeCount > 0 ? round($totalVolumeCompletion / $volumeCount, 2) : 0;

                // WP dianggap selesai jika semua volume memiliki completion 100%
                $isCompleted = count($volumeCompletions) > 0 && min($volumeCompletions) >= 100;

                if ($isCompleted) {
                    $completedWorkPackages++;
                }

                $wpCompletionDetails[] = [
                    'workPackage_id' => $wp->workPackage_id,
                    'workPack_number' => $wp->workPack_number,
                    'wp_name' => $wp->name,
                    'volume_count' => $volumeCount,
                    'volume_completions' => $volumeCompletions,
                    'avg_completions' => $avgWpCompletion,
                    'is_completed' => $isCompleted,
                    'min_volume_completion' => count($volumeCompletions) > 0 ? min($volumeCompletions) : 0
                ];
            }

            // Hitung persentase completion
            $completionPercentage = $totalWorkPackages > 0 ? round(($completedWorkPackages / $totalWorkPackages) * 100, 1) : 0;

            return [
                'completed' => $completedWorkPackages,
                'total' => $totalWorkPackages,
                'remaining' => $totalWorkPackages - $completedWorkPackages,
                'completion_percentage' => $completionPercentage,
                'details' => $wpCompletionDetails
            ];

        } catch (Exception $e) {
            Log::error('Error in getWorkPackageCompletionData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'completed' => 0,
                'total' => 0,
                'remaining' => 0,
                'completion_percentage' => 0,
                'details' => []
            ];
        }
    }

    /**
     * Get project finance comparison data
     */
    private function getProjectFinanceComparison()
    {
        try {
            // Ambil data project
            $getProjectBudget = Project::getBudgetByName('Project EGIS');
            
            // Total anggaran proyek
            $totalProjectBudget = $getProjectBudget ?? 12704350000;

            // Ambil total nilai WO yang sudah keluar dari method yang sudah ada
            $woCompletionData = $this->getWOCompletionFinance();
            $totalWOValue = $woCompletionData['total_wo_value'];

            // Hitung persentase WO keluar terhadap total anggaran
            $woProjectPercentage = $totalProjectBudget > 0 ?
                round(($totalWOValue / $totalProjectBudget) * 100, 1) : 0;
            
            // Hitung sisa anggaran
            $remainingBudget = $totalProjectBudget - $totalWOValue;

            return [
                'project_name' => 'Project EGIS',
                'total_project_budget' => $totalProjectBudget,
                'total_wo_value' => $totalWOValue,
                'remaining_budget' => $remainingBudget,
                'wo_project_percentage' => $woProjectPercentage,
                'completed_wo_value' => $woCompletionData['completed_wo_value'],
                'completion_percentage' => $woCompletionData['completion_percentage'],
                'formatted' => [
                    'total_project_budget' => number_format($totalProjectBudget, 0, ',', '.'),
                    'total_wo_value' => number_format($totalWOValue, 0, ',', '.'),
                    'remaining_budget' => number_format($remainingBudget, 0, ',', '.'),
                    'completed_wo_value' => number_format($woCompletionData['completed_wo_value'], 0, ',', '.')
                ]
            ];

        } catch (Exception $e) {
            Log::error('Error in getProjectFinanceComparison', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Default value is case of error
            $defaultBudget = 12704350000;
            return [
                'project_name' => 'Project EGIS',
                'total_project_budget' => $defaultBudget,
                'total_wo_value' => 0,
                'remaining_budget' => $defaultBudget,
                'wo_project_percentage' => 0,
                'completed_wo_value' => 0,
                'completion_percentage' => 0,
                'formatted' => [
                    'total_project_budget' => number_format($defaultBudget, 0, ',', '.'),
                    'total_wo_value' => '0',
                    'remaining_budget' => number_format($defaultBudget, 0, ',', '.'),
                    'completed_wo_value' => '0'
                ]
            ];
        }
    }

    /**
     * Get Work Order completion data from Work Order that have been called based on financial value
     */
    private function getWOCompletionFinance()
    {
        try {
            // Ambil semua Work Order yang memiliki Work Package
            $workOrders = WorkOrder::with([
                'workPackageVolumes' => function($query) {
                    $query->with([
                        'workPackage.humanResources.role',
                        'task.subTask'
                    ])
                    ->whereNotNull('startDate')
                    ->whereNotNull('endDate')
                    ->whereNotNull('executionYear');
                }
            ])
            ->whereHas('workPackageVolumes', function($query) {
                $query->whereNotNull('startDate')
                    ->whereNotNull('endDate')
                    ->whereNotNull('executionYear');
            })
            ->get();

            $completedWOValue = 0;
            $totalWOValue = 0;
            $woDetails = [];

            foreach ($workOrders as $wo) {
                $woTotalValue = 0;
                $woIsCompleted = true;
                $woCompletionStatus = [];

                // Group volume berdasarkan Work Package
                $volumesByWP = $wo->workPackageVolumes->groupBy('workPackage_id');

                foreach ($volumesByWP as $wpId => $volumes) {
                    $firstVolume = $volumes->first();
                    $workPackage = $firstVolume->workPackage;

                    // Hitung WP Value untuk Work Package ini
                    $wpValue = $this->calculateWPValue($workPackage);
                    $woTotalValue += $wpValue;

                    // Cek apakah semua completion volume dari WP ini sudah 100 %
                    $allVolumesComplete = true;
                    $volumeCompletions = [];

                    foreach ($volumes as $volume) {
                        $volumeCompletion = $this->calculateVolumeCompletion($volume->volume_id);
                        $volumeCompletions[] = $volumeCompletion;

                        if ($volumeCompletion < 100) {
                            $allVolumesComplete = false;
                        }
                    }

                    $avgVolumeCompletion = count($volumeCompletions) > 0 ?
                        round(array_sum($volumeCompletions) / count($volumeCompletions), 2) : 0;

                    // WP dianggap selesai jika semua volume sudah 100%
                    if (!$allVolumesComplete) {
                        $woIsCompleted = false;
                    }

                    $wpCompletionStatus[] = [
                        'workPackage_id' => $wpId,
                        'workPack_number' => $workPackage->workPack_number,
                        'wp_name' => $workPackage->name,
                        'wp_value' => $wpValue,
                        'volume_count' => $volumes->count(),
                        'avg_completion' => $avgVolumeCompletion,
                        'is_completed' => $allVolumesComplete,
                        'volume_completions' => $volumeCompletions
                    ];
                }

                // Tambahkan ke total WO value
                $totalWOValue += $woTotalValue;

                // Jika WO selesai, tambahkan value ke completed
                if ($woIsCompleted && $woTotalValue > 0) {
                    $completedWOValue += $woTotalValue;
                }

                $woDetails[] = [
                    'workOrder_id' => $wo->workOrder_id,
                    'workNumber_id' => $wo->workNumber_id,
                    'total_value' => $woTotalValue,
                    'is_completed' => $woIsCompleted,
                    'wp_count' => $volumesByWP->count(),
                    'volume_count' => $wo->workPackageVolumes->count(),
                    'wp_details' => $wpCompletionStatus
                ];
            }

            // Hitung persentase completion berdasarkan nilai keuangan
            $completionPercentage = $totalWOValue > 0 ?
                round(($completedWOValue / $totalWOValue) * 100, 1) : 0;

            $ongoingWOValue = $totalWOValue - $completedWOValue;

            return [
                'total_wo_value' => $totalWOValue,
                'completed_wo_value' => $completedWOValue,
                'ongoing_wo_value' => $ongoingWOValue,
                'completion_percentage' => $completionPercentage,
                'total_wo_count' => $workOrders->count(),
                'completed_wo_count' => collect($woDetails)->where('is_completed', true)->count(),
                'details' => $woDetails
            ];

        } catch (Exception $e) {
            Log::error('Error in getWOCompletionFinanceData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'total_wo_value' => 0,
                'completed_wo_value' => 0,
                'ongoing_wo_value' => 0,
                'completion_percentage' => 0,
                'total_wo_count' => 0,
                'completed_wo_count' => 0,
                'details' => []
            ];
        }
    }

    /**
     * Calculate WP Value for a Work Package
     */
    private function calculateWPValue($workPackage)
    {
        try {
            // Ambil human resources untuk Work Package ini
            $humanResources = $workPackage->humanResources()
                ->with('role')
                ->get();
            
            $totalByYoy = 0;

            foreach ($humanResources as $hResource) {
                $resourceCost = optional($hResource->role)->resourceCost ?? 0;
                $jhk = $hResource->jhk ?? 0;
                $jtk = $hResource->jtk ?? 0;

                // Hitung biaya by YoY
                $byYoyCost = $jhk * $jtk * $resourceCost;
                $totalByYoy += $byYoyCost;
            }

            return $totalByYoy;

        } catch (Exception $e) {
            Log::error('Error calculating WP Value', [
                'workPackage_id' => $workPackage->workPackage_id,
                'error' => $e->getMessage()
            ]);

            return 0;
        }
    }

    /**
     * Get WP Completion data from Work Packages that assigned to Work Orders
     */
    private function getWPCompletionFromAssignedWP()
    {
        try {
            // Ambil semua Work Package yang sudah dipanggil oleh Work Order
            $workPackagesWithWO = WorkPackage::with([
                'workPackageVolumes' => function($query) {
                    $query->whereNotNull('workOrder_id');
                },
                'workPackageVolumes.task.subTask'
            ])
            ->whereHas('workPackageVolumes', function($query) {
                $query->whereNotNull('workOrder_id');
            })
            ->get();

            $completedWorkPackages = 0;
            $totalAssignedWorkPackages = $workPackagesWithWO->count();
            $wpCompletionDetails = [];

            foreach ($workPackagesWithWO as $wp) {
                // Hanya ambil volume yang memiliki Work Order untuk evaluasi completion
                $volumesWithWO = $wp->workPackageVolumes->whereNotNull('workOrder_id');

                $volumeCompletions = [];
                $totalVolumeCompletion = 0;
                $volumeCount = $volumesWithWO->count();

                // Hitung completion untuk setiap volume yang memiliki WO
                foreach ($volumesWithWO as $volume) {
                    $volumeCompletion = $this->calculateVolumeCompletion($volume->volume_id);
                    $volumeCompletions[] = $volumeCompletion;
                    $totalVolumeCompletion += $volumeCompletion;
                }

                // Rata - rata completion untuk WP ini
                $avgWpCompletion = $volumeCount > 0 ? round($totalVolumeCompletion / $volumeCount, 2) : 0;

                // WP dianggap selesai jika semua volume dengan WO memiliki completion 100%
                $isCompleted = count($volumeCompletions) > 0 && min($volumeCompletions) >= 100;

                if ($isCompleted) {
                    $completedWorkPackages++;
                }

                $wpCompletionDetails[] = [
                    'workPackage_id' => $wp->workPackage_id,
                    'workPack_number' => $wp->workPack_number,
                    'wp_name' => $wp->name,
                    'total_volumes' => $wp->workPackageVolumes->count(),
                    'volume_with_wo' => $volumeCount,
                    'volume_completions' => $volumeCompletions,
                    'avg_completions' => $avgWpCompletion,
                    'is_completed' => $isCompleted,
                    'min_volume_completion' => count($volumeCompletions) > 0 ? min($volumeCompletions) : 0,
                    'max_volume_completion' => count($volumeCompletions) > 0 ? max($volumeCompletions) : 0
                ];
            }

            // Hitung persentase completion
            $completionPercentage = $totalAssignedWorkPackages > 0 ?
                round(($completedWorkPackages / $totalAssignedWorkPackages) * 100, 1) : 0;

            // Data work packages yang belum selesai
            $ongoingWorkPackages = $totalAssignedWorkPackages - $completedWorkPackages;

            return [
                'labels' => ['WP Selesai', 'WP Berjalan'],
                'data' => [$completedWorkPackages, $ongoingWorkPackages],
                'total' => $totalAssignedWorkPackages,
                'completed' => $completedWorkPackages,
                'ongoing' => $ongoingWorkPackages,
                'completion_percentage' => $completionPercentage,
                'details' => $wpCompletionDetails
            ];

        } catch (Exception $e) {
            Log::error('Error in getWPCompletionFromAssignedWP', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'labels' => ['No Data'],
                'data' => [1],
                'total' => 0,
                'completed' => 0,
                'ongoing' => 0,
                'completion_percentage' => 0,
                'details' => [],
            ];
        }     
    }

    // CATATAN : TIDAK DIPAKAI
    /**
     * Count WP which have been called by WO
     */
    private function countWPAsociatedWithWO() {
        $totalWorkPackages = WorkPackage::count();

        // Hitung WP yang sudah memiliki WO
        $wpWithWorkOrder = WorkPackage::whereHas('workPackageVolumes', function($query) {
            $query->whereNotNull('workOrder_id');
        })->count();

        // Hitung WP yang belum memiliki WO
        $wpWithoutWorkOrder = $totalWorkPackages - $wpWithWorkOrder;

        return [
            'labels' => ['Sudah dipanggil WO', 'Belum'],
            'data' => [$wpWithWorkOrder, $wpWithoutWorkOrder],
            'total' => $totalWorkPackages
        ];
    }

    /**
     * Get WP Progress data based on WO and WP combination
     */
    private function getWPProgressByWOChartData($year = null)
    {
        try {
            // Default ke tahun saat ini jika tidak ada parameter
            if (!$year) {
                $year = Carbon::now()->year;
            }

            // Ambil semua volume yang memiliki WO dan WP
            $volumes = WorkPackageVolume::with([
                'workPackage',
                'workOrder',
                'task.subTask',
            ])
            ->whereNotNull('trs_workPackVolume.workOrder_id')
            ->whereNotNull('trs_workPackVolume.startDate')
            ->whereNotNull('trs_workPackVolume.endDate')
            ->whereHas('workPackage')
            ->whereHas('workOrder')
            ->where('executionYear', $year)
            ->orderByRaw("
                CAST(workNumber_id_from_wo.workNumber_id AS SIGNED) ASC,
                CAST(SUBSTRING_INDEX(workPack_number_from_wp.workPack_number, '.', 1) AS SIGNED) ASC,
                CAST(SUBSTRING_INDEX(workPack_number_from_wp.workPack_number, '.', -1) AS SIGNED) ASC,
                trs_workPackVolume.volumeNumber ASC
            ")
            ->join('mst_workOrder as workNumber_id_from_wo', 'trs_workPackVolume.workOrder_id', '=', 'workNumber_id_from_wo.workOrder_id')
            ->join('trs_workPackage as workPack_number_from_wp', 'trs_workPackVolume.workPackage_id', '=', 'workPack_number_from_wp.workPackage_id')
            ->select('trs_workPackVolume.*')
            ->get();

            if ($volumes->isEmpty()) {
                return [
                    'labels' => ['No Data'],
                    'data' => [0],
                    'chart_details' => [],
                    'total_combinations' => 0
                ];
            }

            $chartData =[];
            $labels =[];
            $data =[];

            // Group volumes berdasarkan kombinasi WO dan WP
            $groupedVolumes = $volumes->groupBy(function($volume) {
                return $volume->workOrder->workNumber_id . '_' . $volume->workPackage->workPack_number;
            });

            foreach ($groupedVolumes as $groupKey => $volumeGroup) {
                $firstVolume = $volumeGroup->first();
                $woNumber = $firstVolume->workOrder->workNumber_id;
                $wpNumber = $firstVolume->workPackage->workPack_number;
                $wpName = $firstVolume->workPackage->name;

                // Hitung rata-rata completion dari semua volume dalam grup ini
                $completions = [];
                foreach ($volumeGroup as $volume) {
                    $completion = $this->calculateVolumeCompletion($volume->volume_id);
                    $completions[] = $completion;
                }
                $avgCompletion = round(array_sum($completions) / count($completions), 1);

                // Buat label yang unik
                $volumeCount = $volumeGroup->count();
                $label = "WP {$wpNumber} (WO {$woNumber})";

                // Jika WP ini ada di multiple WO, tambahkan info WO
                // $wpInMultipleWO = $volumes->where('workPackage.workPack_number', $wpNumber)
                //     ->groupBy('workOrder_id')->count() > 1;
                
                // if ($wpInMultipleWO) {
                //     $label .= " (WO {$woNumber})";
                // }

                // Tambahkan info volume jika lebih dari 1
                // if ($volumeCount > 1) {
                //     $label .= " - {$volumeCount} vol";
                // }

                $labels[] = $label;
                $data[] = $avgCompletion;

                // Simpan detail
                $chartData[$label] = [
                    'workNumber_id' => $woNumber,
                    'workPack_number' => $wpNumber,
                    'wp_name' => $wpName,
                    'volume_count' => $volumeCount,
                    'completion' => $avgCompletion,
                    'volume_ids' => $volumeGroup->pluck('volume_id')->toArray(),
                    'volumeNumbers' => $volumeGroup->pluck('volumeNumber')->sort()->values()->toArray(),
                    'executionYear' => $firstVolume->executionYear,
                    'startDate' => $firstVolume->startDate,
                    'endDate' => $firstVolume->endDate
                ];
            }

            Log::info('WP Progress By WO Chart Data Generated', [
                'total_combinations' => count($labels),
                'unique_wo_count' => $volumes->pluck('workOrder_id')->unique()->count(),
                'unique_wp_count' => $volumes->pluck('workPackage_id')->unique()->count()
            ]);

            return [
                'labels' => $labels,
                'data' => $data,
                'chart_details' => $chartData,
                'total_combinations' => count($labels),
                'selected_year' => $year
            ];

        } catch (Exception $e) {
            Log::error('Error in getWPProgressByWOChartData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'labels' => ['No Data'],
                'data' => [0],
                'chart_details' => [],
                'total_combinations' => 0,
                'selected_year' => $year ?? Carbon::now()->year
            ];
        }
    }

    /**
     * Get available years from volume execution
     */
    private function getAvailableYears()
    {
        try {
            $years = WorkPackageVolume::whereNotNull('executionYear')
                ->whereNotNull('workOrder_id')
                ->whereNotNull('startDate')
                ->whereNotNull('endDate')
                ->whereHas('workPackage')
                ->whereHas('workOrder')
                ->select('executionYear')
                ->distinct()
                ->orderBy('executionYear', 'asc')
                ->pluck('executionYear')
                ->toArray();

            // Jika tidak ada data, return current year
            if (empty($years)) {
                return [Carbon::now()->year];
            }

            return $years;

        } catch (Exception $e) {
            Log::error('Error in getAvailableYears', [
                'error' => $e->getMessage(),
            ]);

            // Fallback ke current year
            return [Carbon::now()->year];
        }
    }

    /**
     * Method for filter year
     */
    public function getWPProgressDataByYear(Request $request)
    {
        try{
            $year = $request->get('year', Carbon::now()->year);
            
            // Validate year
            if (!is_numeric($year) || $year < 2020 || $year > 2030) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid year parameter'
                ], 400);
            }

            // Get chart data for the selected year
            $wpProgressBarChartData = $this->getWPProgressByWOChartData($year);

            return response()->json([
                'success' => true,
                'data' => $wpProgressBarChartData,
                'year' => $year
            ]);

        } catch (Exception $e) {
            Log::error('Error in getWPProgressDataByYear', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data'
            ], 500);
        }
    }

    /**
     * Get User with total work package assigned
     */
    private function getUserWithWorkPackage()
    {
        try {
            $userWorkPackageData = User::with(['work.volume.workPackage', 'roles'])
                ->whereDoesntHave('roles', function($query) {
                    $query->where('name', 'admin');
                })
                ->whereHas('work')
                ->get()
                ->map(function($user) {
                    // Hitung jumlah unique work package yang dikerjakan user ini
                    $workPackageIds = $user->work
                        ->pluck('volume.workPackage.workPackage_id')
                        ->filter() // Remove null values
                        ->unique()
                        ->count();
                    
                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'trs_workPackage_count' => $workPackageIds,
                        'work_assignments_count' => $user->work->count()
                    ];
                })
                ->filter(function($user) {
                    return $user['trs_workPackage_count'] > 0;
                })
                ->sortByDesc('trs_workPackage_count')
                ->values();
    
            return $userWorkPackageData;

        } catch (Exception $e) {
            Log::error('Error in getUserWithWorkPackage', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return collect();
        }
    }

    // CATATAN : TIDAK DIPAKAI
    /**
     * Get data for ongoing project table
     */
    private function getProjectBerjalanData() 
    {
        try {
            // Ambil semua Work Package Volume yang memiliki Work Order
            $volumes = WorkPackageVolume::with([
                'workPackage',
                'workOrder'
            ])
            ->whereNotNull('workOrder_id')
            ->whereNotNull('startDate')
            ->whereNotNull('endDate')
            ->orderBy('workOrder_id')
            ->orderBy('workPackage_id')
            ->orderBy('volumeNumber')
            ->get();

            $projectData = collect();

            foreach ($volumes as $volume) {
                // Hitung completion untuk volume ini
                $completion = $this->calculateVolumeCompletion($volume->volume_id);

                // Skip jika completion 100% (sudah selesai)
                if ($completion >= 100) {
                    continue;
                }

                $projectData->push([
                    'workNumber_id' => $volume->workOrder->workNumber_id ?? '-',
                    'workPack_number' => $volume->workPackage->workPack_number ?? '-',
                    'wp_name' => $volume->workPackage->name ?? '-',
                    'volume_id' => $volume->volume_id,
                    'volumeNumber' => $volume->volumeNumber,
                    'volumeQTY' => 1,
                    'completion' => $completion,
                    'executionYear' => $volume->executionYear,
                    'startDate' => $volume->startDate,
                    'endDate' => $volume->endDate
                ]);
            }

            // Grup berdasarkan WO dan WP menggabungkan volume yang sama
            $groupedData = $projectData->groupBy(function($item) {
                return $item['workNumber_id'] . '_' . $item['workPack_number'];
            })->map(function($group) {
                $first = $group->first();
                $totalVolumes = $group->count();
                $avgCompletion = round($group->avg('completion'), 1);

                return [
                    'workNumber_id' => $first['workNumber_id'],
                    'workPack_number' => $first['workPack_number'],
                    'wp_name' => $first['wp_name'],
                    'volumeQTY' => $totalVolumes,
                    'completion' => $avgCompletion,
                    'executionYear' => $first['executionYear'],
                    'volume_ids' => $group->pluck('volume_id')->toArray()
                ];
            })
            ->sortBy(['workNumber_id', 'workPack_number'])
            ->values();

            return $groupedData;

        } catch (Exception $e) {
            Log::error('Error in getProjectBerjalanData', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return collect();
        }
    }

    /**
     * Calculate completion for specific volume
     */
    private function calculateVolumeCompletion($volumeId)
    {
        $volumeTasks = Task::where('volume_id', $volumeId)
            ->with('subTask')
            ->get();

        if ($volumeTasks->count() === 0) {
            return 0;
        }

        $tasksWithUtilization = $volumeTasks->map(function ($task) {
            // Jika task memiliki completeness langsung
            if ($task->completeness !== null) {
                return round($task->completeness, 2);
            } 

            // Jika tidak, hitung dari sub tasks
            $subTasks = $task->subTask;
            if ($subTasks->count() > 0) {
                $avgCompleteness = $subTasks->avg('completeness');
                return round($avgCompleteness, 2);
            }
            return 0;
        });

        return round($tasksWithUtilization->avg(), 2);
    }

    public function getPeriodAllWPByYear(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        // Ambil semua WorkPackageVolume yang memiliki periode untuk tahun yang dipilih
        $wpvWithPeriod = WorkPackageVolume::whereNotNull('trs_workPackVolume.endDate')
            ->whereNotNull('trs_workPackVolume.workOrder_id')
            ->where('trs_workPackVolume.executionYear', $year)
            ->with(['workPackage', 'workOrder', 'task.subTask'])
            ->join('mst_workOrder as wo_sort', 'trs_workPackVolume.workOrder_id', '=', 'wo_sort.workOrder_id')
            ->orderByRaw('CAST(wo_sort.workNumber_id AS SIGNED) ASC')
            ->select('trs_workPackVolume.*')
            ->get();
        
        $groupedByWo = $wpvWithPeriod->groupBy('workOrder_id');
        $woGroups = collect();

        foreach ($groupedByWo as $woId => $volumes) {
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0.0;

            $startDates = [];
            $endDates = [];
            $wpNumbers = [];

            foreach ($volumes as $volume) {
                // collect period bounds
                if ($volume->startDate) $startDates[] = $volume->startDate;
                if ($volume->endDate) $endDates[] = $volume->endDate;

                // collect WP numbers
                $wpNum = optional($volume->workPackage)->workPack_number;
                if ($wpNum) $wpNumbers[$wpNum] = true;

                // get tasks (use eager loaded relationship if present)
                $tasks = $volume->task ?? collect();
                // if relation not loaded, fallback to query
                if ($tasks instanceof \Illuminate\Database\Eloquent\Collection === false) {
                    $tasks = Task::where('volume_id', $volume->volume_id)->with('subTask')->get();
                }

                foreach ($tasks as $task) {
                    $taskCompleteness = null;
                    if ($task->completeness !== null) {
                        $taskCompleteness = floatval($task->completeness);
                    } else {
                        // compute from sub tasks
                        $subTasks = $task->subTask ?? collect();
                        if ($subTasks->count() > 0) {
                            $subsAvg = $subTasks->avg(function($st) {
                                return $st->completeness !== null ? floatval($st->completeness) : 0;
                            });
                            $taskCompleteness = floatval($subsAvg);
                        }
                    }

                    if ($taskCompleteness !== null) {
                        $totalTasksCompleteness += $taskCompleteness;
                        $totalTasksCount++;
                    }
                }
            }

            $groupPerformance = $totalTasksCount > 0
                ? round($totalTasksCompleteness / $totalTasksCount, 2)
                : 0.0;

            // determine group period (earliest start, latest end)
            $groupStart = count($startDates) ? collect($startDates)->min() : null;
            $groupEnd = count($endDates) ? collect($endDates)->max() : null;

            $woNumber = optional($volumes->first()->workOrder)->workNumber_id ?? $woId;

            $woGroups->push((object)[
                'workOrder_id' => $woId,
                'workNumber_id' => $woNumber,
                'startDate' => $groupStart,
                'endDate' => $groupEnd,
                'performance' => $groupPerformance,
                'workPack_numbers' => array_values(array_keys($wpNumbers)),
                'volumes' => $volumes, // include volumes if view needs details
            ]);
        }
        
        // Render hanya partial view diagram
        $html = view('partials.diagram_timeline', [
            'woGroups' => $woGroups,
            'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            'lebarBulan' => 110,
            'tinggiDiagram' => 340,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'year' => $year
        ]);
    }

    public function getUserWorkPackageDetails(Request $request)
    {
        $username = $request->get('username');
        
        if (!$username) {
            return response()->json([
                'success' => false,
                'message' => 'Username tidak valid'
            ]);
        }
        
        // Get user ID from username
        $user = User::where('name', $username)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
        
        // 1. Ambil volume_id yang dikerjakan oleh user
        $volumeIds = Work::where('user_id', $user->user_id)->pluck('volume_id')->toArray();
        
        // 2. Ambil workPackage_id dari volume tersebut
        $wpIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->pluck('workPackage_id')
            ->unique()
            ->toArray();
        
        // 3. Load work packages dengan eager loading
        $workPackages = WorkPackage::with([
            'wpCategory', 
            'workPackageVolumes',
            'humanResources',
            'workPackageVolumes.task.subTask'
        ])
        ->whereIn('workPackage_id', $wpIds)
        ->orderByRaw("CAST(SUBSTRING_INDEX(workPack_number, '.', 1) AS SIGNED) ASC, CAST(SUBSTRING_INDEX(workPack_number, '.', -1) AS SIGNED) ASC")
        ->get();
        
        $wpDetails = collect();
        $today = now();
        
        // 4. Proses setiap WP dan kelompokkan berdasarkan workOrder_id
        foreach ($workPackages as $wp) {
            $volumesByWo = $wp->workPackageVolumes->whereIn('volume_id', $volumeIds)->groupBy('workOrder_id');

            foreach ($volumesByWo as $woId => $volumes) {
                if (!$woId) continue; // Abaikan volume tanpa WO

                $wpClone = clone $wp; // Clone WP untuk menghindari konflik data
                $wpClone->volumes_count = $volumes->count();

                // Ambil executionYear dari volume
                $executionYears = $volumes->pluck('executionYear')->unique()->filter();
                $wpClone->executionYear = $executionYears->count() === 1
                    ? $executionYears->first()
                    : $executionYears->implode(', ');

                // Hitung performance & cek tanggal
                $allDatesExpired = true;
                $performance = $this->calculateWpPerformance($volumes, $today, $allDatesExpired);
                $wpClone->performance = $performance;
                $wpClone->allDatesExpired = $allDatesExpired;

                // Tentukan status WP
                if ($allDatesExpired && $performance >= 100) {
                    $wpClone->status = 'Selesai';
                } else {
                    $wpClone->status = 'Berjalan';
                }

                // Tambahkan workNumber_id
                $wpClone->workNumber_id = optional($volumes->first()->workOrder)->workNumber_id ?? $woId;

                // Tambahan: Hitung mandays rencana (JHK) dari humanResources
                $userWork = Work::where('user_id', $user->user_id)
                    ->whereIn('volume_id', $volumes->pluck('volume_id'))
                    ->first();

                $role_id = $userWork ? $userWork->role_id : null;

                $humanResource = $wp->humanResources
                    ->where('role_id', $role_id)
                    ->first();

                $planned_mandays = $humanResource ? $humanResource->jhk : 0;
                $wpClone->planned_mandays = $planned_mandays;

                // Tambahan: Hitung mandays realisasi dari timesheet
                $volumeIdsInWp = $volumes->pluck('volume_id')->toArray();

                // Ambil semua aktivitas timesheet untuk volume terkait
                $timesheets = Timesheet::where('user_id', $user->user_id)
                    ->whereIn('volume_id', $volumeIdsInWp)
                    ->get();

                // Kelompokkan aktivitas berdasarkan tanggal
                $timesheetsGroupedByDate = $timesheets->groupBy('execution_date');

                // Hitung rata-rata durasi per hari
                $averageDurations = $timesheetsGroupedByDate->map(function ($activities) {
                    return $activities->avg('duration'); // Rata-rata durasi per hari
                });

                // Hitung rata-rata keseluruhan
                $actual_mandays = $averageDurations->sum(); // Rata-rata dari rata-rata harian

                $wpClone->actual_mandays = round($actual_mandays, 2);

                // Hitung persentase mandays terhadap rencana
                $wpClone->mandays_percentage = $planned_mandays > 0
                    ? round(($actual_mandays / $planned_mandays) * 100, 2)
                    : 0;

                $wpDetails->push($wpClone);
            }
        }
        
        $html = view('partials.user_wp_details', [
            'workPackages' => $wpDetails,
            'username' => $user->name,
            'totalWp' => $wpDetails->count(),
            'selesai' => $wpDetails->where('status', 'Selesai')->count(),
            'berjalan' => $wpDetails->where('status', 'Berjalan')->count(),
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    private function calculateWpPerformance($volumes, $today, &$allDatesExpired)
    {
        $totalTasksCount = 0;
        $totalTasksCompleteness = 0;
        
        foreach ($volumes as $volume) {
            // Cek apakah volume masih dalam periode
            if (!$volume->endDate || $volume->endDate > $today) {
                $allDatesExpired = false;
            }
            
            // Ambil semua task untuk volume ini
            $tasks = Task::where('volume_id', $volume->volume_id)->get();
            
            foreach ($tasks as $task) {
                $taskCompleteness = 0;
                $subTasks = SubTask::where('task_id', $task->task_id)->get();
                
                if ($subTasks->count() > 0) {
                    // Jika ada subtask, hitung rata-rata completeness subtask
                    $subTasksSum = $subTasks->sum('completeness');
                    $taskCompleteness = $subTasks->count() > 0 ? 
                        $subTasksSum / $subTasks->count() : 0;
                } else {
                    // Jika tidak ada subtask, gunakan completeness task langsung
                    $taskCompleteness = $task->completeness ?? 0;
                }
                
                $totalTasksCompleteness += $taskCompleteness;
                $totalTasksCount++;
            }
        }
        
        return $totalTasksCount > 0 ? 
            round($totalTasksCompleteness / $totalTasksCount, 2) : 0;
    }
}
