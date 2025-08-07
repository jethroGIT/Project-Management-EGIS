<?php

namespace App\Http\Controllers;

use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\WpCategory;
use App\Models\User;
use App\Models\Role;
use App\Models\HumanResource;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class WorkPackageManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil semua work packages dengan relasi yang dibutuhkan
            $workPackages = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes.work.user.role',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volume_number', 'asc');
                }
            ])-> orderBy('wp_number', 'asc')->get();

            // Transform data untuk keperluan view
            $workPackagesData = $workPackages->map(function ($wp) {
                // Hitung total volume count
                $volumeCount = $wp->workPackageVolumes->count();

                // Ambil semua resource names dari semua volume
                $resourceNames = collect();
                foreach ($wp->workPackageVolumes as $volume) {
                    foreach ($volume->work as $work) {
                        if ($work->user && $work->user->role) {
                            $resourceNames->push([
                                'name' => $work->user->name,
                                'role' => $work->user->role->name
                            ]);
                        }
                    }
                }

                // Hapus duplikat dan format resource names
                $uniqueResources = $resourceNames->unique(function($resource) {
                    return $resource['name'] . '_' . $resource['role'];
                })->map(function($resource) {
                    return $resource['name'] . ' (' . $resource['role'] . ')';
                })->values();

                return [
                    'wp_id' => $wp->wp_id,
                    'category_name' => $wp->wpCategory->name ?? 'Tidak Berkategori',
                    'wp_number' => $wp->wp_number,
                    'name' => $wp->name,
                    'volume_count' => $volumeCount,
                    'duration' => $wp->duration,
                    'actual_scope_contract' => $wp->actual_scope_contract,
                    'deliverable' => $wp->deliverable,
                    'resource_names' => $uniqueResources->implode(', ') ?: 'Belum ada resource'
                ];
            });

            // Ambil semua kategori untuk filter
            $categories = WpCategory::orderBy('name', 'asc')->get();

            Log::info('Work Package Management data loaded successfully', [
                'total_wp' => $workPackages->count(),
                'total_categories' => $categories->count()
            ]);

            return view('workpackage_management', compact('workPackagesData', 'categories'));

        } catch (Exception $e) {
            Log::error('Error loading work package management data', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return view dengan data kosong jika terjadi error
            return view('workpackage_management', [
                'workPackagesData' => collect(),
                'categories' => collect()
            ]);
        }
    }

    /**
     * Get work packages by category for filtering
     */
    public function getByCategory(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');

            $query = WorkPackage::with([
                'wpCategory',
                'workPackageVolume.work.user.role'
            ]);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $workPackages = $query->orderBy('wp_number', 'asc')->get();

            return response()->json([
                'success' => true,
                'work_packages' => $workPackages
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Work Package'
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
     * Get next available work package number for a category
     */
    public function getNextWpNumber(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');
            
            if (!$categoryId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category ID diperlukan'
                ], 400);
            }

            $category = WpCategory::findOrFail($categoryId);

            // Cek apakah category memiliki nomor category_field
            if (!isset($category->category_number) || $category->category_number === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori belum memiliki nomor kategori yang valid'
                ], 400);
            }

            // Ambil nomor WP terakhir dalam kategori ini
            $lastWp = WorkPackage::where('wp_number', 'LIKE', $category->category_number . '.%')
                ->orderByRaw('CAST(SPLIT_PART(wp_number, \'.\', 2) AS INTEGER) DESC')
                ->first();

            if (!$lastWp) {
                // Jika belum ada WP dalam kategori ini, mulai dari .1
                $nextNumber = $category->category_number . '.1';
            } else {
                // Parse nomor terakhir dan tambahkan 1
                $lastNumber = explode('.', $lastWp->wp_number);
                $nextSequence = (int)end($lastNumber) + 1;
                $nextNumber = $category->category_number . '.' . $nextSequence;
            }

            return response()->json([
                'success' => true,
                'wp_number' => $nextNumber,
                'category_number' => $category->category_number
            ]);

        } catch (Exception $e) {
            Log::error('Error getting next WP number', [
                'category_id' => $categoryId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil nomor WP berikutnya: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if work package number is available
     */
    public function checkWpNumberAvailability(Request $request)
    {
        try {
            $categoryId = $request->get('category_id');
            $sequence = $request->get('sequence');

            if (!$categoryId || !$sequence) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category ID dan sequence diperlukan'
                ], 400);
            }

            $category = WpCategory::findOrFail($categoryId);

            // Cek apakah category memiliki nomor category_field
            if (!isset($category->category_number) || $category->category_number === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori belum memiliki nomor kategori yang valid'
                ], 400);
            }

            $wpNumber = $category->category_number . '.' . $sequence;

            $isAvailable = !WorkPackage::where('wp_number', $wpNumber)->exists();

            $wpNumber = $category->category_number . '.' . $sequence;

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'wp_number' => $wpNumber
            ]);

        } catch (Exception $e) {
            Log::error('Error checking WP number availability', [
                'category_id' => $categoryId ?? 'null',
                'sequence' => $sequence ?? 'null',
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa ketersediaan nomor WP'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            Log::info('Incoming request data:', $request->all());

            // Validate the request
            $validatedData = $request->validate([
                // Step 1: Basic Work Package Data
                'category_id' => 'required|exists:wp_category,category_id',
                'wp_sequence' => 'required|integer|min:1',
                'name' => 'required|string|max:255',
                'actual_scope_contract' => 'nullable|string',
                'deliverable' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'volume_qty' => 'required|integer|min:1',

                // Step 2: Resource Data
                'resources' => 'required|array|min:1',
                'resources.*.user_id' => 'required|exists:user,user_id',
                'resources.*.jhk' => 'required|integer|min:1',

                // Step 3: Task Data
                'tasks' => 'nullable|array',
                'tasks.*.name' => 'required|string|max:255',
                'tasks.*.sub_tasks' => 'nullable|array',
                'tasks.*.sub_tasks.*.name' => 'required|string|max:500',
            ]);

            $duration = (int) $validatedData['duration'];
            $volumeQty = (int) $validatedData['volume_qty'];

            // Generate WP number berdasarkan kategori
            $category = WpCategory::findOrFail($validatedData['category_id']);
            $wpNumber = $category->category_number . '.' . $validatedData['wp_sequence'];

            // Cek apakah WP number sudah ada
            if (WorkPackage::where('wp_number', $wpNumber)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => "Nomor Work Package {$wpNumber} sudah digunakan. Silakan pilih nomor lain."
                ], 422);
            }

            Log::info('Creating work package with data:', $validatedData);

            // STEP 1: Create Work Package
            $workPackage = WorkPackage::create([
                'category_id' => $validatedData['category_id'],
                'wp_number' => $wpNumber,
                'name' => $validatedData['name'],
                'volume_qty' => $volumeQty,
                'duration' => $duration,
                'actual_scope_contract' => $validatedData['actual_scope_contract'],
                'deliverable' => $validatedData['deliverable'],
            ]);

            // STEP 2: Create Work Package Volume and Resource
            $volumes = [];
            for ($i = 1; $i <= $volumeQty; $i++) {
                $volume = WorkPackageVolume::create([
                    'wp_id' => $workPackage->wp_id,
                    'volume_number' => $i,
                    'start_date' => now(),
                    'end_date' => now()->addDays($duration),
                    'execution_year' => now()->year,
                ]);

                $volumes[] = $volume;
            }
            
            foreach ($volumes as $volume) {
                foreach ($validatedData['resources'] as $resourceData) {
                    $user = User::with('role')->find($resourceData['user_id']);

                    if (!$user || !$user->role) {
                        throw new Exception("User dengan ID {$resourceData['user_id']} tidak ditemukan atau belum memiliki role");
                    }

                    // Create work record for each user on volume
                    Work::create([
                        'volume_id' => $volume->volume_id,
                        'user_id' => $resourceData['user_id'],
                    ]);

                    Log::info('Created Work record:', [
                        'volume_id' => $volume->volume_id,
                        'volume_number' => $volume->volume_number,
                        'user_id' => $resourceData['user_id'],
                        'user_name' => $user->name,
                        'role_name' => $user->role->name
                    ]);
                }
            }

            // Create Human Resources for each volume
            $resourcesByRole = [];

            foreach ($validatedData['resources'] as $resourceData) {
                $user = User::with('role')->find($resourceData['user_id']);

                if (!$user || !$user->role) {
                    throw new Exception("User dengan ID {$resourceData['user_id']} tidak ditemukan atau belum memiliki role");
                }
                
                $roleId = $user->role_id;

                // Group by role_id and count JTK
                if (!isset($resourcesByRole[$roleId])) {
                    $resourcesByRole[$roleId] = [
                        'role_id' => $roleId,
                        'role_name' => $user->role->name,
                        'jtk' => 0,
                        'total_jhk' => 0,
                        'users' => []
                    ];
                }

                // Count jumlah orang dengan role yang sama
                $resourcesByRole[$roleId]['jtk'] += 1;

                // Total hari kerja untuk role ini
                $resourcesByRole[$roleId]['total_jhk'] += (int) $resourceData['jhk'];
                
                $resourcesByRole[$roleId]['users'][] = [
                    'user_id' => $user->user_id,
                    'name' => $user->name,
                    'jhk' => (int) $resourceData['jhk']
                ];
            }

            // Create Human resource
            foreach ($resourcesByRole as $roleData) {
                HumanResource::create([
                    'wp_id' => $workPackage->wp_id,
                    'role_id' => $roleData['role_id'],
                    'jtk' => $roleData['jtk'],
                    'jhk' => $roleData['total_jhk'],
                ]);
            }
            
            // STEP 3: Create Tasks and Sub Tasks
            if (!empty($validatedData['tasks'])) {
                foreach ($validatedData['tasks'] as $taskIndex => $taskData) {
                    // Create task for the first volume (you can modify this logic)
                    // $firstVolume = $workPackage->workPackageVolumes()->first();

                    // Create task for all volumes
                    foreach ($volumes as $volume) {
                        // Calculate order index for proper ordering
                        $maxOrderIndex = Task::where('volume_id', $volume->volume_id)
                            ->max('order_index') ?? 0;

                        $task = Task::create([
                            'volume_id' => $volume->volume_id,
                            'name' => $taskData['name'],
                            'status' => 'open',
                            'order_index' => $maxOrderIndex + 1
                        ]);

                        // Create sub tasks if provided
                        if (!empty($taskData['sub_tasks'])) {
                            foreach ($taskData['sub_tasks'] as $subTaskData) {
                                SubTask::create([
                                    'task_id' => $task->task_id,
                                    'name' => $subTaskData['name'],
                                    'completeness' => 0.00, // Default to 0%
                                ]);
                            }
                        }
                    }
                }
            }

            DB::commit();

            Log::info('Work Package created successfully', [
                'wp_id' => $workPackage->wp_id,
                'wp_number' => $workPackage->wp_number,
                'name' => $workPackage->name,
                'volumes_created' => $validatedData['volume_qty'],
                'resources_count' => count($validatedData['resources']),
                'tasks_count' => count($validatedData['tasks'] ?? [])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Package berhasil dibuat dengan lengkap',
                'work_package' => $workPackage->load(['wpCategory', 'workPackageVolumes']),
                'summary' => [
                    'volumes_created' => $volumeQty,
                    'tasks_per_volume' => count($validatedData['tasks'] ?? []),
                    'total_tasks_created' => (count($validatedData['tasks'] ?? []) * $volumeQty),
                    'resources_assigned' => count($validatedData['resources'])
                ]
            ]);

        } catch (ValidationException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error creating work package', [
                'error' => $e->getMessage(),
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat Work Package: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get users with roles for resource selection
     */
    public function getUsersWithRoles()
    {
        try {
            $users = User::with('role')->orderBy('name', 'asc')->get();
            $roles = Role::orderBy('name', 'asc')->get();

            return response()->json([
                'success' => true,
                'users' => $users,
                'roles' => $roles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data users'
            ], 500);
        }
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
