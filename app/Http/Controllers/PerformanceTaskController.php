<?php

namespace App\Http\Controllers;

use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
            ->with(['subTask' => function($query) {
                $query->orderBy('created_at', 'asc')
                    ->orderBy('sub_task_id', 'asc');
            }])
            ->orderBy('created_at', 'asc')
            ->orderBy('task_id', 'asc')
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

            // Cek status semua subtask pada task ini
            $allSubTasks = SubTask::where('task_id', $task->task_id)->get();
            $allComplete = $allSubTasks->count() > 0 && $allSubTasks->every(function($st) {
                return $st->completeness >= 100;
            });

            // Update status task
            $task->status = $allComplete ? 'closed' : 'open';
            $task->save();

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
     * Get sub task data for edit form
     */
    public function editSubTask($subTaskId)
    {
        try {
            $subTask = SubTask::with('task')->findOrFail($subTaskId);

            return response()->json([
                'success' => true,
                'sub_task' => [
                    'sub_task_id' => $subTask->sub_task_id,
                    'task_id' => $subTask->task_id,
                    'name' => $subTask->name,
                    'completeness' => $subTask->completeness,
                    'task_name' => $subTask->task->name ?? 'Unknown Task',
                    'created_at' => $subTask->created_at->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sub task tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error getting sub task for edit', [
                'sub_task_id' => $subTaskId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sub task tidak ditemukan: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update existing sub task
     */
    public function updateSubTask(Request $request, $subTaskId)
    {
        $request->validate([
            'sub_task_name' => 'required|string|max:255'
        ], [
            'sub_task_name.required' => 'Nama sub task harus diisi',
            'sub_task_name.max' => 'Nama sub task maksimal 255 karakter'
        ]);

        try {
            DB::beginTransaction();

            $subTask = SubTask::with('task')->findOrFail($subTaskId);

            // Deteksi perubahan data
            $originalName = $subTask->name;
            $newName = trim($request->sub_task_name);

            // Pengecekan perubahan
            $nameChanged = $originalName !== $newName;

            if (!$nameChanged) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data yang terdeteksi.',
                    'current_data' => [
                        'name' => $originalName,
                        'completeness' => $subTask->completeness
                    ]
                ], 200);
            }

            // Update sub task
            $subTask->name = $newName;
            $subTask->save();

            DB::commit();

            Log::info('Sub task updated successfully', [
                'sub_task_id' => $subTask->sub_task_id,
                'task_id' => $subTask->task_id,
                'old_data' => [
                    'name' => $originalName,
                    'completeness' => $subTask->completeness,
                    'created_at' => $subTask->created_at->format('Y-m-d H:i:s')
                ],
                'new_data' => [
                    'name' => $subTask->name,
                    'completeness' => $subTask->completeness,
                    'created_at' => $subTask->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $subTask->updated_at->format('Y-m-d H:i:s')
                ],
                'updated_by' => auth()->id() ?? 'system'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub task berhasil diperbarui',
                'sub_task' => [
                    'sub_task_id' => $subTask->sub_task_id,
                    'task_id' => $subTask->task_id,
                    'name' => $subTask->name,
                    'completeness' => $subTask->completeness,
                    'task_name' => $subTask->task->name ?? 'Unknown Task',
                    'created_at' => $subTask->created_at->format('Y-m-d H:i:s'),
                    'last_updated' => $subTask->updated_at ? $subTask->updated_at->format('d M Y H:i') : 'Tidak diketahui'
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Sub task tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error updating sub task', [
                'sub_task_id' => $subTaskId,
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token', '_method']),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui sub task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified sub task from storage.
     */
    public function destroySubTask(string $id)
    {
        try {
            DB::beginTransaction();

            $subTask = SubTask::with('task')->findOrFail($id);

            // Store data untuk logging sebelum dihapus
            $deletedData = [
                'sub_task_id' => $subTask->sub_task_id,
                'task_id' => $subTask->task_id,
                'name' => $subTask->name,
                'completeness' => $subTask->completeness,
                'task_name' => $subTask->task->name ?? 'Unknown Task',
                'created_at' => $subTask->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $subTask->updated_at ? $subTask->updated_at->format('Y-m-d H:i:s') : null
            ];

            $task = $subTask->task;

            // Delete sub task
            $subTask->delete();

            // Cek status semua subtask pada task ini
            $allSubTasks = SubTask::where('task_id', $task->task_id)->get();
            $allComplete = $allSubTasks->count() > 0 && $allSubTasks->every(function($st) {
                return $st->completeness >= 100;
            });

            // Update status task
            $task->status = $allComplete ? 'closed' : 'open';
            $task->save();

            DB::commit();

            Log::info('Sub task deleted successfully', [
                'deleted_sub_task' => $deletedData,
                'deleted_by' => auth()->id() ?? 'system',
                'deleted_at' => now()->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub task berhasil dihapus',
                'deleted_sub_task' => $deletedData
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            Log::warning('Sub task not found for deletion', [
                'sub_task_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sub task tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error deleting sub task', [
                'sub_task_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus sub task: ' . $e->getMessage()
            ], 500);
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
