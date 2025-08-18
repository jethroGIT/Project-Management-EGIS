<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Role;
use App\Models\SubTask;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\User;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\Work;
use App\Models\WpCategory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class WorkPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Jika ada parameter volume_id di query string
        if ($request->has('volume_id')) {
            return $this->detail($request->get('volume_id'), $request);
        }
        
        // Ambil work package volume pertama atau redirect
        $firstVolume = WorkPackageVolume::with('workPackage')->first();
        if ($firstVolume) {
            return redirect()->route('work-package.detail', ['volume_id' => $firstVolume->volume_id]);
        }

        return view('workpackage');

    }

    public function detail($volume_id, Request $request)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task' => function($query) {
                $query->orderBy('order_index')->orderBy('task_id');
            },
            'work.user.role'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;

        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();

        $assignedUsers = User::whereHas('work', function($query) use ($volume_id) {
            $query->where('volume_id', $volume_id);
        })->with(['role', 'humanResource']) // ambil relasi role
            ->withCount(['timesheets' => function ($query) use ($volume_id) {
                // Filter timesheet berdasarkan volume_id dan bulan yang dipilih
                $query->where('volume_id', $volume_id);
            }])
            ->get()
            ->map(function ($user) {
                // $humanResource = HumanResource::where('role_id', $user->role_id)->first();
                return [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'role_name' => $user->role->name ?? 'No Role',
                    'jhk' => $user->humanResource->jhk ?? null,
                    'timesheets_count' => $user->timesheets_count,
                ];
        });

        // Hitung total completion dari task performance
        $tasks = $volume->task;
        $totalCompletion = 0;

        $tasksWithUtilization = $tasks->map(function ($task) {
            $subTasks = $task->subTask;
            if ($subTasks->count() > 0) {
                $avgCompleteness = $subTasks->avg('completeness');
                $task->utilization = round($avgCompleteness, 2);
            } else {
                $task->utilization = 0;
            }
            return $task;
        });

        if ($tasksWithUtilization->count() > 0) {
            $totalCompletion = round($tasksWithUtilization->avg('utilization'), 2);
        }

        // hitung persentase finance performance
        // Ambil semua work dan timesheet berdasarkan volume
        $works = Work::with('user.role')->where('volume_id', $volume_id)->get();
        $timesheets = Timesheet::with('user.role')->where('volume_id', $volume_id)->get();

        // Group dan jumlahkan resource cost per role
        $resourceCostPerRole = $works->groupBy(fn($w) => optional($w->user->role)->role_id)
            ->map(fn($group) => $group->first()->user->role->resource_cost ?? 0);

        // Hitung aktivitas per role dari timesheet
        $timesheetCountPerRole = $timesheets->groupBy(fn($t) => optional($t->user->role)->role_id)
            ->map(fn($group) => $group->count());
        
        $totalByYoy = 0;
        $totalRealization = 0;

        foreach ($humanResources as $hr) {
            $roleId = $hr->role_id;
            $jhk = $hr->jhk ?? 0;
            $resourceCost = $resourceCostPerRole[$roleId] ?? 0;
            $timesheetCount = $timesheetCountPerRole[$roleId] ?? 0;

            $totalByYoy += $jhk * $resourceCost;
            $totalRealization += $timesheetCount * $resourceCost;
        }

        // Hitung persentase realisasi
        $realizationPercentage = $totalByYoy > 0 ? ($totalRealization / $totalByYoy) * 100 : 0;

        // Mendapatkan informasi referrer dari query parameter
        $referrer = $request->get('referrer');
        $wpId = $request->get('wp_id');

        // Menentukan URL kembali berdasarkan referrer
        $backUrl = route('wp-management');
        $backText = 'Kembali ke Manajemen';

        if ($referrer === 'detail' && $wpId) {
            $backUrl = route('wp-management.detail', ['wp_id' => $wpId]);
            $backText = 'Kembali ke Detail WP';
        } else if ($referrer === 'edit' && $wpId) {
            $backUrl = route('wp-management.edit', ['wp_id' => $wpId]);
            $backText = 'Kembali ke Edit WP';
        }
        
        return view('workpackage', compact(
            'humanResources',
            'workPackage', 
            'volume', 
            'volume_id',
            'assignedUsers',
            'totalCompletion',
            'realizationPercentage',
            'tasks',
            'tasksWithUtilization',
            'backUrl',
            'backText'
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
            // 'reference_task_id' => 'nullable|exists:task,task_id',
            // 'insert_position' => 'nullable|in:above,below'
        ]);

        try {
            DB::beginTransaction();

            $volumeId = (int) $request->volume_id;
            // Find the max order for this volume
            $maxOrder = Task::where('volume_id', $request->volume_id)->max('order_index');
            $order = $maxOrder ? $maxOrder + 1 : 1;

            // $referenceTaskId = $request->reference_task_id ? (int) $request->reference_task_id : null;

            // // Jika ada reference task, perlu mengatur ulang order
            // if ($referenceTaskId && $request->insert_position) {
            //     $referenceTask = Task::where('task_id', $referenceTaskId)
            //         ->where('volume_id', $volumeId)
            //         ->firstOrFail();
                
            //     if ($request->insert_position === 'above') {
            //         // Task baru akan menempati order_index yang sama dengan reference task
            //         $newOrderIndex = $referenceTask->order_index;
                    
            //         // Geser semua task yang memiliki order_index >= reference task
            //         Task::where('volume_id', $volumeId)
            //             ->where('order_index', '>=', $referenceTask->order_index)
            //             ->increment('order_index');
            //     } else { // below
            //         // Task baru akan menempati order_index = reference task + 1
            //         $newOrderIndex = $referenceTask->order_index + 1;
                    
            //         // Geser semua task yang memiliki order_index > reference task
            //         Task::where('volume_id', $volumeId)
            //             ->where('order_index', '>', $referenceTask->order_index)
            //             ->increment('order_index');
            //     }
            // } else {
            //     // Jika tidak ada reference task, tambahkan di akhir
            //     $maxOrder = Task::where('volume_id',  $volumeId)
            //         ->max('order_index') ?? 0;
            //     $newOrderIndex = $maxOrder + 1;
            // }

            // Create task baru
            $task = Task::create([
                'volume_id' => $volumeId,
                'name' => trim($request->task_name),
                'status' => 'open',
                'order_index' => $order
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Task berhasil ditambahkan',
                'task' => $task
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error creating task', [
                'message' => $e->getMessage(),
                'volume_id' => $request->volume_id,
                'task_name' => $request->task_name,
                // 'reference_task_id' => $request->reference_task_id
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
            DB::beginTransaction();

            $task = Task::where('task_id', $taskId)
                ->where('volume_id', $request->volume_id)
                ->firstOrFail();
            
            $task->update([
                'name' => trim($request->task_name)
            ]);

            DB::commit();

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
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error updating task', [
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
            DB::beginTransaction();

            $task = Task::with('subTask')->findOrFail($taskId);

            $subTaskCount = $task->subTask->count();

            if( $subTaskCount > 0) {
                SubTask::where('task_id', $taskId)->delete();
            }

            // Cek apakah task masih memiliki sub task
            // if ($task->subTask->count() > 0) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Task tidak dapat dihapus karena masih memiliki ' . $task->subTask->count() . ' sub task. Hapus sub task terlebih dahulu.',
            //         'has_subtasks' => true,
            //         'subtask_count' => $task->subTask->count()
            //     ], 400);
            // }

            // Menangani order_index dan volume_id sebelum penghapusan
            $deleteOrderIndex = $task->order_index;
            $volumeId = $task->volume_id;

            // Hapus task
            $task->delete();

            // Melakukan pengurutan kembali order_index dengan menggeser task order_index > deleted task turun - 1
            Task::where('volume_id', $volumeId)
                ->where('order_index', '>', $deleteOrderIndex)
                ->decrement('order_index');

            DB::commit();

            Log::info('Task and related subtasks deleted successfully', [
                'task_id' => $taskId,
                'task_name' => $task->name,
                'volume_id' => $volumeId,
                'deleted_subtask_count' => $subTaskCount
            ]);

            return response()->json([
                'success' => true,
                'message' => $subTaskCount > 0
                    ? "Task dan $subTaskCount sub task berhasil dihapus"
                    : "Task berhasil dihapus"
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error deleting task', [
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

    public function getSubTaskCount($taskId)
    {
        $task = Task::withCount('subTask')->find($taskId);
        if (!$task) {
            return response()->json(['success' => false, 'subtask_count' => 0]);
        }
        return response()->json(['success' => true, 'subtask_count' => $task->sub_task_count]);
    }

    /**
     * Store new sub task
     */
    public function storeSubTask(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:task,task_id',
            'subtask_name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Pastikan parent task ada
            $task = Task::findOrFail($request->task_id);

            // Buat subtask baru
            $subTask = $task->subTask()->create([
                'name' => trim($request->subtask_name),
                'completeness' => 0, // default value, bisa diubah sesuai kebutuhan
                'status' => 'open'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sub Task berhasil ditambahkan',
                'subtask' => $subTask
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error creating subtask', [
                'message' => $e->getMessage(),
                'task_id' => $request->task_id,
                'subtask_name' => $request->subtask_name
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan sub task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get sub task data by Id
     */
    public function getSubTask($subTaskId)
    {
        try {
            $subTask = SubTask::findOrFail($subTaskId);

            return response()->json([
                'success' => true,
                'subtask' => [
                    'sub_task_id' => $subTask->sub_task_id,
                    'task_id' => $subTask->task_id,
                    'name' => $subTask->name,
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
     * Update existing sub task
     */
    public function updateSubTask(Request $request, $subTaskId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sub_task_id' => 'required|exists:sub_task,sub_task_id',
            'task_id' => 'required|exists:task,task_id'
        ]);

        try {
            DB::beginTransaction();

            $subTask = SubTask::where('sub_task_id', $subTaskId)
                ->where('task_id', $request->task_id)
                ->firstOrFail();
            
            $subTask->update([
                'name' => trim($request->name)
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Sub Task berhasil diperbarui',
                'subtask' => [
                    'sub_task_id' => $subTask->sub_task_id,
                    'name' => $subTask->name,
                    'task_id' => $subTask->task_id
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Sub Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error updating sub task', [
                'message' => $e->getMessage(),
                'sub_task_id' => $subTaskId,
                'task_id' => $request->task_id,
                'subtask_name' => $request->subtask_name,
                'trace' => $e->getTraceAsString()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui sub task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete existing sub task
     */
    public function deleteSubTask($subTaskId)
    {
        try {
            DB::beginTransaction();

            $subTask = SubTask::findOrFail($subTaskId);

            // Hapus sub task
            $subTask->delete();

            DB::commit();

            Log::info('Sub Task deleted successfully', [
                'sub_task_id' => $subTaskId,
                'name' => $subTask->name,
                'task_id' => $subTask->task_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Sub Task berhasil dihapus'
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Sub Task tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error deleting sub task', [
                'message' => $e->getMessage(),
                'subtask_id' => $subTaskId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus sub task: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update work package volume data
     */
    public function updateVolumeData(Request $request, $volume_id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'resources' => 'nullable|array',
            'resources.*' => 'exists:user,user_id',
            'jhk' => 'nullable|array',
            'jhk.*' => 'nullable|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            // Update tanggal periode work package volume
            $volume = WorkPackageVolume::findOrFail($volume_id);

            // Update execution_year dari data start_date
            $executionYear = Carbon::parse($request->start_date)->year;

            // Deteksi Perubahan
            $originalStartDate = Carbon::parse($volume->start_date)->format('Y-m-d');
            $originalEndDate = Carbon::parse($volume->end_date)->format('Y-m-d');
            $originalExecutionYear = $volume->execution_year;
            $originalResources = Work::where('volume_id', $volume_id)->pluck('user_id')->sort()->values()->toArray();

            $newStartDate = $request->start_date;
            $newEndDate = $request->end_date;
            $newExecutionYear = $executionYear;
            $newResources = collect($request->resources ?? [])
                ->filter()
                ->map(function($userId) {
                    return (int) $userId;
                })
                ->unique()
                ->sort()
                ->values()
                ->toArray();
            $jhkChanged = false;
            if (!empty($request->jhk) && !empty($request->resources)) {
                foreach ($request->resources as $index => $userId) {
                    $newJhk = (int) ($request->jhk[$index] ?? 0);

                    $user = User::with('role')->find($userId);
                    if (!$user || !$user->role) {
                        continue; // skip jika user atau role tidak valid
                    }

                    $roleId = $user->role->role_id;

                    // Cari jhk lama dari human_resource berdasarkan role_id dan wp_id
                    $hr = HumanResource::where('role_id', $roleId)
                        ->where('wp_id', $volume->wp_id)
                        ->first();

                    $originalJhk = $hr ? (int) $hr->jhk : 0;

                    if ($newJhk !== $originalJhk) {
                        $jhkChanged = true;
                        break; // cukup satu perubahan untuk dianggap berubah
                    }
                }
            }

            // Check for changes
            $startDateChanged = $originalStartDate !== $newStartDate;
            $endDateChanged = $originalEndDate !== $newEndDate;
            $executionYearChanged = $originalExecutionYear !== $newExecutionYear;
            $resourcesChanged = $originalResources != $newResources;
            $hasChanges = $startDateChanged || $endDateChanged || $executionYearChanged || $resourcesChanged || $jhkChanged;

            // Jika tidak ada perubahan
            if (!$hasChanges) {
                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data yang terdeteksi.',
                    'original_data' => [
                        'start_date' => $originalStartDate,
                        'end_date' => $originalEndDate,
                        'execution_year' => $originalExecutionYear,
                        'resources_count' => count($originalResources),
                        'jhk_changed' => $jhkChanged,
                    ]
                ], 200);
            }

            $volume->update([
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'execution_year' => $executionYear
            ]);

            // Menangani Resource dengan tabel Work
            Work::where('volume_id', $volume_id)->delete();

            // Tambah assignments baru berdasarkan user_id
            $wpId = $volume->wp_id;
            foreach ($newResources as $index => $userId) {
                Work::create([
                    'user_id' => (int) $userId,
                    'volume_id' => (int) $volume_id
                ]);

                // Update jhk jika tersedia
                if (isset($request->jhk[$index]) && $request->jhk[$index] !== null) {
                    $jhkValue = (int) $request->jhk[$index];

                    // Cari role user terkait
                    $user = User::with('role')->find($userId);
                    if ($user && $user->role) {
                        // Update jhk di HumanResource
                        $hr = HumanResource::where('role_id', $user->role->role_id)
                                            ->where('wp_id', $wpId)
                                            ->first();
                        if ($hr) {
                            $hr->jhk = $jhkValue;
                            $hr->save();
                        }
                    }
                }
            }

            DB::commit();

            // $resourcesCount = $request->resources ? count(array_filter($request->resources)) : 0;
            $resourcesCount = count($newResources);

            Log::info('Volume data updated successfully', [
                'volume_id' => $volume_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'execution_year' => $executionYear,
                'resources_count' => $resourcesCount,
                'role_ids' => $newResources,
                'has_resources' => $resourcesCount > 0
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui',
                'data' => [
                    'volume_id' => $volume->volume_id,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date,
                    'execution_year' => $volume->execution_year,
                    'resources_count' => $resourcesCount,
                    'has_resources' => $resourcesCount > 0
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();
        
            return response()->json([
                'success' => false,
                'message' => 'Volume tidak ditemukan'
            ], 404);

        } catch (\Exception $e) {
            DB::rollback();

            Log::error('Error updating volume data', [
                'message' => $e->getMessage(),
                'volume_id' => $volume_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'execution_year' => $executionYear ?? null,
                'resources' => $request->resources,
                'trace' => $e->getTraceAsString()
            ]);
        
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data: ' . $e->getMessage()
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
            'work.role'
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
                'message' => 'Data berhasil diperbarui.',
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
