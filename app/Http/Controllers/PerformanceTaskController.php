<?php

namespace App\Http\Controllers;

use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

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
     * Store a newly created sub task.
     */
    public function storeSubTask(Request $request) 
    {
        $request->validate([
            'task_id' => 'required|exists:task,task_id',
            'sub_task_name' => 'required|string|max:500'
        ], [
            'task_id.required' => 'Task ID harus diisi',
            'task_id.exists' => 'Task tidak ditemukan',
            'sub_task_name.required' => 'Nama sub task harus diisi',
            'sub_task_name.max' => 'Nama sub task maksimal 500 karakter'
        ]);

        try {
            DB::beginTransaction();

            // Pastikan task ada dan ambil data task
            $task = Task::findOrFail($request->task_id);

            // Membuat sub task baru
            $subTask = SubTask::create([
                'task_id' => $request->task_id,
                'name' => trim($request->sub_task_name),
                'completeness' => 0.00 // Default completeness
            ]);

            DB::commit();

            // Log success
            Log::info('Sub task created successfully', [
                'sub_task_id' => $subTask->sub_task_id,
                'task_id' => $subTask->task_id,
                'name' => $subTask->name,
                'completeness' => $subTask->completeness
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub task berhasil ditambahkan',
                'sub_task' => [
                    'sub_task_id' => $subTask->sub_task_id,
                    'task_id' => $subTask->task_id,
                    'name' => $subTask->name,
                    'completeness' => $subTask->completeness
                ],
                'task_name' => $task->name
            ]);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error creating sub task', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan sub task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get task data for sub task modal
     */
    public function getTaskForSubTask($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            return response()->json([
                'success' => true,
                'task' => [
                    'task_id' => $task->task_id,
                    'name' => $task->name,
                    'status' => $task->status
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }
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
