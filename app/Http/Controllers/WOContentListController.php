<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\WorkPackageVolume;
use App\Models\Task;
use Carbon\Carbon;
use Exception;

class WOContentListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($wo_id)
    {
        try {
            // Ambil work order dengan relasi volumes
            $workOrder = WorkOrder::with([
                'workPackageVolumes' => function($query) {
                    $query->with([
                            'workPackage.wpCategory', 
                            'work.user', 
                            'work.role', 
                        ])
                        ->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->whereNotNull('execution_year')
                        ->orderBy('wp_id')
                        ->orderBy('volume_number');
                }
            ])->findOrFail($wo_id);

            $volumesData = $workOrder->workPackageVolumes->map(function($volume) {
                // Format periode
                $periodFormatted = 'Belum tersedia';
                if ($volume->start_date && $volume->end_date) {
                    $periodFormatted = Carbon::parse($volume->start_date)->format('d M Y') . 
                                     ' - ' . 
                                     Carbon::parse($volume->end_date)->format('d M Y');
                }

                // Ambil resource info
                $resources = $volume->work->map(function($work) {
                    if ($work->user && $work->role) {
                        return [
                            'user_name' => $work->user->name,
                            'role_name' => $work->role->name
                        ];
                    }
                    return null;
                })->filter()->unique()->values();

                // Task completion untuk volume ini
                $volumeCompletion = $this->calculateVolumeCompletion($volume->volume_id);

                return [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'wp_number' => $volume->workPackage->wp_number ?? '-',
                    'wp_name' => $volume->workPackage->name ?? '-',
                    'wp_category' => $volume->workPackage->wpCategory->name ?? '-',
                    'period_formatted' => $periodFormatted,
                    'duration' => $volume->workPackage->duration,
                    'execution_year' => $volume->execution_year,
                    'resources' => $resources,
                    'resource_count' => $resources->count(),
                    'completion' => $volumeCompletion
                ];
            });

            // Group by work package untuk statistik
            $wpStats = $volumesData->groupBy('wp_number')->map(function($group) {
                return [
                    'volume_count' => $group->count(),
                    'wp_name' => $group->first()['wp_name'],
                    'wp_category' => $group->first()['wp_category']
                ];
            });

            return view('wo_content_list', compact(
                'workOrder', 
                'volumesData', 
                'wpStats'
            ));

        } catch (Exception $e) {
            abort(404, 'Work Order tidak ditemukan');
        }
    }

    /**
     * Calculate completion percentage for a specific volume
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
