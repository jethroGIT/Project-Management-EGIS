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
use DB;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hitung total Work Order yang tersedia
        $totalWorkOrders = WorkOrder::count();

        // Data untuk pie chart WO
        $pieChartDataWo = $this->countWPAsociatedWithWO();

        // Data Bar chart total work package dari SDM (User)
        $userWorkPackageData = $this->getUserWithWorkPackage();

        $barChartWpSDMData = [
            'labels' => $userWorkPackageData->pluck('name')->toArray(),
            'data' => $userWorkPackageData->pluck('work_package_count')->toArray(),
            'details' => $userWorkPackageData->toArray(),
            'total_users' => $userWorkPackageData->count()
        ];

        // Data untuk tabel Project Berjalan
        $projectBerjalanData = $this->getProjectBerjalanData();

        return view('dashboard', compact(
            'totalWorkOrders',
            'pieChartDataWo',
            'barChartWpSDMData',
            'projectBerjalanData'
        ));
    }

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
