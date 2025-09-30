<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkOrder;
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
        $totalWorkOrders = WorkOrder::count();

        // Data untuk card Work Package Selesai (TIDAK DIPAKAI)
        // $workPackageCompletionData = $this->getWorkPackageCompletionData();

        // Data untuk card Work Package yang sudah dipanggil WO
        $workPackageWOAssignmentData = $this->getWorkPackageWOAssignment();

        // Data untuk pie chart WO
        // $pieChartDataWo = $this->countWPAsociatedWithWO();

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
            'data' => $userWorkPackageData->pluck('work_package_count')->toArray(),
            'details' => $userWorkPackageData->toArray(),
            'total_users' => $userWorkPackageData->count()
        ];

        // Data untuk tabel Project Berjalan (TIDAK DIPAKAI)
        $projectBerjalanData = $this->getProjectBerjalanData();

         // Get execution years for the period diagram filter
        $executionYear = WorkPackageVolume::whereNotNull('execution_year')
            ->distinct()
            ->orderBy('execution_year', 'asc')
            ->pluck('execution_year');
            
        // Fetch the WPV period data for initial view
        $wpvWithPeriod = WorkPackageVolume::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('execution_year', $selectedYear)
            ->with('workPackage')
            ->get();

        return view('dashboard', compact(
            'totalWorkOrders',
            'workPackageWOAssignmentData',
            'pieChartDataWo',
            'availableYears',
            'selectedYear',
            'wpProgressBarChartData',
            'barChartWpSDMData',
            'projectBerjalanData',
            'executionYear',
            'wpvWithPeriod',
        ));
    }

    /**
     * Get total Work Package WO assignment
     */
    private function getWorkPackageWOAssignment()
    {
        try {
            // Hitun total Work Package yang ada
            $totalWorkPackages = WorkPackage::count();

            // Hitung Work Package yang sudah memiliki Work Order
            $wpWithWorkOrder = WorkPackage::whereHas('workPackageVolumes', function($query) {
                $query->whereNotNull('wo_id');
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
                    'wp_id' => $wp->wp_id,
                    'wp_number' => $wp->wp_number,
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
     * Get WP Completion data from Work Packages that assigned to Work Orders
     */
    private function getWPCompletionFromAssignedWP()
    {
        try {
            // Ambil semua Work Package yang sudah dipanggil oleh Work Order
            $workPackagesWithWO = WorkPackage::with([
                'workPackageVolumes' => function($query) {
                    $query->whereNotNull('wo_id');
                },
                'workPackageVolumes.task.subTask'
            ])
            ->whereHas('workPackageVolumes', function($query) {
                $query->whereNotNull('wo_id');
            })
            ->get();

            $completedWorkPackages = 0;
            $totalAssignedWorkPackages = $workPackagesWithWO->count();
            $wpCompletionDetails = [];

            foreach ($workPackagesWithWO as $wp) {
                // Hanya ambil volume yang memiliki Work Order untuk evaluasi completion
                $volumesWithWO = $wp->workPackageVolumes->whereNotNull('wo_id');

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
                    'wp_id' => $wp->wp_id,
                    'wp_number' => $wp->wp_number,
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
                'labels' => ['WP Selesai', 'WP Belum Selesai'],
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
            $query->whereNotNull('wo_id');
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
            ->whereNotNull('work_package_volume.wo_id')
            ->whereHas('workPackage')
            ->whereHas('workOrder')
            ->where('execution_year', $year)
            ->orderByRaw('
                CAST(wo_number_from_wo.wo_number AS INTEGER) ASC,
                CAST(SPLIT_PART(wp_number_from_wp.wp_number, \'.\', 1) AS INTEGER) ASC,
                CAST(SPLIT_PART(wp_number_from_wp.wp_number, \'.\', 2) AS INTEGER) ASC,
                work_package_volume.volume_number ASC
            ')
            ->join('work_order as wo_number_from_wo', 'work_package_volume.wo_id', '=', 'wo_number_from_wo.wo_id')
            ->join('work_package as wp_number_from_wp', 'work_package_volume.wp_id', '=', 'wp_number_from_wp.wp_id')
            ->select('work_package_volume.*')
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
                return $volume->workOrder->wo_number . '_' . $volume->workPackage->wp_number;
            });

            foreach ($groupedVolumes as $groupKey => $volumeGroup) {
                $firstVolume = $volumeGroup->first();
                $woNumber = $firstVolume->workOrder->wo_number;
                $wpNumber = $firstVolume->workPackage->wp_number;
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
                // $wpInMultipleWO = $volumes->where('workPackage.wp_number', $wpNumber)
                //     ->groupBy('wo_id')->count() > 1;
                
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
                    'wo_number' => $woNumber,
                    'wp_number' => $wpNumber,
                    'wp_name' => $wpName,
                    'volume_count' => $volumeCount,
                    'completion' => $avgCompletion,
                    'volume_ids' => $volumeGroup->pluck('volume_id')->toArray(),
                    'volume_numbers' => $volumeGroup->pluck('volume_number')->sort()->values()->toArray(),
                    'execution_year' => $firstVolume->execution_year,
                    'start_date' => $firstVolume->start_date,
                    'end_date' => $firstVolume->end_date
                ];
            }

            Log::info('WP Progress By WO Chart Data Generated', [
                'total_combinations' => count($labels),
                'unique_wo_count' => $volumes->pluck('wo_id')->unique()->count(),
                'unique_wp_count' => $volumes->pluck('wp_id')->unique()->count()
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
            $years = WorkPackageVolume::whereNotNull('execution_year')
                ->whereNotNull('wo_id')
                ->whereHas('workPackage')
                ->whereHas('workOrder')
                ->select('execution_year')
                ->distinct()
                ->orderBy('execution_year', 'asc')
                ->pluck('execution_year')
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
                        ->pluck('volume.workPackage.wp_id')
                        ->filter() // Remove null values
                        ->unique()
                        ->count();
                    
                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'work_package_count' => $workPackageIds,
                        'work_assignments_count' => $user->work->count()
                    ];
                })
                ->filter(function($user) {
                    return $user['work_package_count'] > 0;
                })
                ->sortByDesc('work_package_count')
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
            ->whereNotNull('wo_id')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->orderBy('wo_id')
            ->orderBy('wp_id')
            ->orderBy('volume_number')
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
                    'wo_number' => $volume->workOrder->wo_number ?? '-',
                    'wp_number' => $volume->workPackage->wp_number ?? '-',
                    'wp_name' => $volume->workPackage->name ?? '-',
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'volume_qty' => 1,
                    'completion' => $completion,
                    'execution_year' => $volume->execution_year,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date
                ]);
            }

            // Grup berdasarkan WO dan WP menggabungkan volume yang sama
            $groupedData = $projectData->groupBy(function($item) {
                return $item['wo_number'] . '_' . $item['wp_number'];
            })->map(function($group) {
                $first = $group->first();
                $totalVolumes = $group->count();
                $avgCompletion = round($group->avg('completion'), 1);

                return [
                    'wo_number' => $first['wo_number'],
                    'wp_number' => $first['wp_number'],
                    'wp_name' => $first['wp_name'],
                    'volume_qty' => $totalVolumes,
                    'completion' => $avgCompletion,
                    'execution_year' => $first['execution_year'],
                    'volume_ids' => $group->pluck('volume_id')->toArray()
                ];
            })
            ->sortBy(['wo_number', 'wp_number'])
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
        $wpvWithPeriod = WorkPackageVolume::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('execution_year', $year)
            ->with('workPackage')
            ->get();
        
        // Render hanya partial view diagram
        $html = view('partials.diagram_wpv', [
            'wpvWithPeriod' => $wpvWithPeriod,
            'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            'lebarBulan' => 160,
            'tinggiDiagram' => 340,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'year' => $year
        ]);
    }
}
