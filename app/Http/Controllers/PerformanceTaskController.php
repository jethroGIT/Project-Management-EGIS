<?php

namespace App\Http\Controllers;

use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use Illuminate\Http\Request;

class PerformanceTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil volume_id dari request
        $volume_id = $request->get('volume_id');

        if (!$volume_id) {
            $firstVolume = WorkPackageVolume::first();
            if ($firstVolume) {
                $volume_id = $firstVolume->volume_id;
            }
        }

        if ($volume_id) {
            return $this->detail($volume_id);
        }

        return view('performance_task');
    }

    /**
     * Resource detail.
     */
    public function detail($volume_id)
    {
        // Ambil volume dengan relasi work package dan task serta subtask
        $volume = workPackageVolume::with([
            'workPackage',
            'task.subtask' 
        ])->findOrFail($volume_id);
        
        $workPackage = $volume->workPackage;

        // Ambil semua tasks dengan sub tasks untuk volume ini
        $tasks = Task::where('volume_id', $volume_id)
            ->with('subTask')
            ->get();
        
        // Hitung utilisasi untuk setiap task dan total completion
        $tasksWithUtilization = $tasks->map(function ($task) {
            $subTasks = $task->subTask;

            if ($subTasks->count() > 0) {
                // Hitung rata-rata completion dari semua sub tasks
                $avgCompleteness = $subTasks->avg('completeness');
                $task->utilization = round($avgCompleteness, 2);
            } else {
                $task->utilization = 0;
            }

            return $task;
        });

        // Hitung total % complete dari rata-rata semua tasks
        $totalCompletion = $tasksWithUtilization->avg('utilization');
        $totalCompletion = round($totalCompletion, 2);

        return view('performance_task', compact(
            'workPackage',
            'volume',
            'tasks',
            'tasksWithUtilization',
            'totalCompletion',
            'volume_id'
        ));
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
