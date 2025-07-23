<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Role;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Database\Eloquent;

class WorkPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika ada parameter volume_id di query string
        if ($request->has('volume_id')) {
            return $this->detail($request->get('volume_id'));
        }
        
        // Ambil work package volume pertama atau redirect
        $firstVolume = WorkPackageVolume::with('workPackage')->first();
        if ($firstVolume) {
            return redirect()->route('work-package.detail', ['volume_id' => $firstVolume->volume_id]);
        }

        return view('workpackage');

    }

    public function detail($volume_id)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task' => function($query) {
                $query->orderBy('order_index')->orderBy('task_id');
            },
            'work.user'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;

        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();

        // Ambil users yang terlibat di work package ini berdasarkan tabel work
        $assignedUsers = User::whereHas('work', function($query) use ($volume_id) {
            $query->where('volume_id', $volume_id);
        })->with('role')->get();

        // Hitung total completion dari task performance
        $tasks = $volume->task;
        $totalCompletion = 0;

        if ($tasks->count() > 0) {
            $taskCompletions = $tasks->map(function ($task) {
                if ($task->subTask->count() > 0) {
                    return $task->subTask->avg('completeness');
                }
                return 0;
            });
            $totalCompletion = round($taskCompletions->avg(), 2);
        }
        
        return view('workpackage', compact(
            'humanResources',
            'workPackage', 
            'volume', 
            'volume_id',
            'assignedUsers',
            'totalCompletion'
        ));
    }

    /**
     * Store new task with position ordering
     */
    public function storeTask(Request $request)
    {
        $request->validate([
            'volume_id' => 'required|exists:work_package_volume,volume_id',
            'task_name' => 'required|string|max:255',
            'reference_task_id' => 'nullable|exists:task,task_id',
            'insert_position' => 'nullable|in:above,below'
        ]);

        try {
            \DB::beginTransaction();

            $volumeId = (int) $request->volume_id;
            $referenceTaskId = $request->reference_task_id ? (int) $request->reference_task_id : null;

            // Jika ada reference task, perlu mengatur ulang order
            if ($referenceTaskId && $request->insert_position) {
                $referenceTask = Task::where('task_id', $referenceTaskId)
                    ->where('volume_id', $volumeId)
                    ->firstOrFail();
                
                if ($request->insert_position === 'above') {
                    // Task baru akan menempati order_index yang sama dengan reference task
                    $newOrderIndex = $referenceTask->order_index;
                    
                    // Geser semua task yang memiliki order_index >= reference task
                    Task::where('volume_id', $volumeId)
                        ->where('order_index', '>=', $referenceTask->order_index)
                        ->increment('order_index');
                } else { // below
                    // Task baru akan menempati order_index = reference task + 1
                    $newOrderIndex = $referenceTask->order_index + 1;
                    
                    // Geser semua task yang memiliki order_index > reference task
                    Task::where('volume_id', $volumeId)
                        ->where('order_index', '>', $referenceTask->order_index)
                        ->increment('order_index');
                }
            } else {
                // Jika tidak ada reference task, tambahkan di akhir
                $maxOrder = Task::where('volume_id',  $volumeId)
                    ->max('order_index') ?? 0;
                $newOrderIndex = $maxOrder + 1;
            }

            // Create task baru
            $task = Task::create([
                'volume_id' => $volumeId,
                'name' => trim($request->task_name),
                'status' => 'open',
                'order_index' => $newOrderIndex
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil ditambahkan',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            \DB::rollback();

            \Log::error('Error creating task', [
                'message' => $e->getMessage(),
                'volume_id' => $request->volume_id,
                'task_name' => $request->task_name,
                'reference_task_id' => $request->reference_task_id
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get task data by Id
     */
    public function getTask($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            return response()->json([
                'success' => true,
                'task' => [
                    'task_id' => $task->task_id,
                    'name' => $task->name,
                    'status' => $task->status,
                    'volume_id' => $task->volume_id
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Update existing task
     */
    public function updateTask(Request $request, $taskId)
    {
        $request->validate([
            'task_name' => 'required|string|max:255',
            'volume_id' => 'required|exists:work_package_volume,volume_id'
        ]);

        try {
            \DB::beginTransaction();

            $task = Task::where('task_id', $taskId)
                ->where('volume_id', $request->volume_id)
                ->firstOrFail();
            
            $task->update([
                'name' => trim($request->task_name)
            ]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil diperbarui',
                'task' => [
                    'task_id' => $task->task_id,
                    'name' => $task->name,
                    'status' => $task->status,
                    'volume_id' => $task->volume_id
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            \DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            \Log::error('Error updating task', [
                'message' => $e->getMessage(),
                'task_id' => $taskId,
                'volume_id' => $request->volume_id,
                'task_name' => $request->task_name,
                'trace' => $e->getTraceAsString()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete existing task
     */
    public function deleteTask($taskId)
    {
        try {
            \DB::beginTransaction();

            $task = Task::with('subTask')->findOrFail($taskId);

            // Cek apakah task masih memiliki sub task
            if ($task->subTask->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Task tidak dapat dihapus karena masih memiliki ' . $task->subTask->count() . ' sub task. Hapus sub task terlebih dahulu.',
                    'has_subtasks' => true,
                    'subtask_count' => $task->subTask->count()
                ], 400);
            }

            // Menangani order_index dan volume_id sebelum penghapusan
            $deleteOrderIndex = $task->order_index;
            $volumeId = $task->volume_id;

            // Hapus task
            $task->delete();

            // Melakukan pengurutan kembali order_index dengan menggeser task order_index > deleted task turun - 1
            Task::where('volume_id', $volumeId)
                ->where('order_index', '>', $deleteOrderIndex)
                ->decrement('order_index');

            \DB::commit();

            \Log::info('Task deleted successfully', [
                'task_id' => $taskId,
                'task_name' => $task->name,
                'volume_id' => $volumeId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil dihapus'
            ]);

        } catch (ModelNotFoundException $e) {
            \DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            \DB::rollback();

            \Log::error('Error deleting task', [
                'message' => $e->getMessage(),
                'task_id' => $taskId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus task: ' . $e->getMessage()
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
    public function editHResource(Request $request, $volume_id)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task',
            'work.user'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;
        try {
            $request->validate([
                'hresource_id' => 'required|exists:human_resource,hresource_id', 
                'role_id' => 'required|exists:role,role_id', 
                'jhk' => 'integer|min:0', 
            ]);

            $resource = HumanResource::where('hresource_id', $request->hresource_id)
                                ->where('wp_id', $workPackage->wp_id)
                                ->where('role_id', $request->role_id)
                                ->firstOrFail();
            $resource->jhk = $request->jhk;
            $resource->save();

            return response()->json([
                'success' => true,
                'message' => 'Data resource berhasil diperbarui.',
                'data' => $resource // Kirim data yang diperbarui jika perlu untuk update UI
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
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
