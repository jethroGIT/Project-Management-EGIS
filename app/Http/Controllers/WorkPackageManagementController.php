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
use App\Models\Timesheet;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
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
                'workPackageVolumes.work.user.roles',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volumeNumber', 'asc');
                }
            ])->orderBy('workPack_number', 'asc')->get();

            // Transform data untuk keperluan view
            $workPackagesData = $workPackages->map(function ($wp) {
                // Hitung total volume count
                $volumeCount = $wp->workPackageVolumes->count();

                // Ambil semua resource names dari semua volume
                $resourceNames = collect();
                foreach ($wp->workPackageVolumes as $volume) {
                    foreach ($volume->work as $work) {
                        if ($work->user && $work->role) {
                            $resourceNames->push([
                                'name' => $work->user->name,
                                'role' => $work->role->name
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
                    'workPackage_id' => $wp->workPackage_id,
                    'categoryNumber' => $wp->wpCategory->categoryNumber,
                    'category_name' => $wp->wpCategory->name ?? 'Tidak Berkategori',
                    'workPack_number' => $wp->workPack_number,
                    'name' => $wp->name,
                    'volume_count' => $volumeCount,
                    'volumeQTY' => $wp->volumeQTY,
                    'duration' => $wp->duration,
                    'actualScope' => $wp->actualScope,
                    'deliverable' => $wp->deliverable,
                    'resource_names' => $uniqueResources->implode(', ') ?: 'Belum ada tenaga kerja'
                ];
            });

            // Ambil semua kategori untuk filter
            $categories = WpCategory::orderByRaw('CAST(categoryNumber AS SIGNED) ASC')->get();

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
     * Display the detailed view of a specific work package
     */
    public function detail($workPackage_id) 
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volumeNumber', 'asc');
                },
                'workPackageVolumes.work.user.roles',
                'workPackageVolumes.workOrder',
                'humanResources.role'
            ])->findOrFail($workPackage_id);

            // Volume untuk ditampilkan di card
            $volumesDisplay = $workPackage->workPackageVolumes->filter(function($volume) {
                return $volume->workOrder_id !== null ||
                        ($volume->startDate !== null &&
                        $volume->endDate !== null &&
                        $volume->executionYear !== null);
            });

            // Transform volume data untuk tampilan
            $volumesData = $volumesDisplay->map(function ($volume) use($workPackage) {
                // Ambil resource names untuk volume ini
                $resourceNames = $volume->work->map(function ($work) {
                    if ($work->user && $work->role) {
                        return $work->user->name . ' (' . $work->role->name . ')';
                    }
                    return null;
                })->filter()->unique()->values();

                // Menangani tanggal null
                $periodFormatted = "Belum tersedia";
                if ($volume->startDate && $volume->endDate) {
                    $periodFormatted = Carbon::parse($volume->startDate)->format('d M Y') . 
                                        ' - ' .
                                        Carbon::parse($volume->endDate)->format('d M Y');
                }

                // Mendapatkan nomor work order
                $woNumber = null;
                if ($volume->workOrder_id && $volume->workOrder) {
                    $woNumber = $volume->workOrder->workNumber_id;
                }

                return [
                    'volume_id' => $volume->volume_id,
                    'volumeNumber' => $volume->volumeNumber,
                    'startDate' => $volume->startDate,
                    'endDate' => $volume->endDate,
                    'executionYear' => $volume->executionYear,
                    'period_formatted' => $periodFormatted,
                    'duration_days' => $workPackage->duration,
                    'resource_names' => $resourceNames->implode(', ') ?: 'Belum ada tenaga kerja',
                    'resource_count' => $resourceNames->count(),
                    'workOrder_id' => $volume->workOrder_id,
                    'workNumber_id' => $woNumber,
                    'has_mst_workOrder' => !is_null($volume->workOrder_id)
                ];
            });

            // Transform human resources data
            $humanResourcesData = $workPackage->humanResources->map(function ($hr) use ($workPackage) {
                $roleName = $hr->role->name ?? 'No Role';

                // Ambil semua user yang di-assign dengan role ini di semua volume WP
                $usersWithRole = collect();

                foreach ($workPackage->workPackageVolumes as $volume) {
                    $volumeUsers = $volume->work->filter(function ($work) use ($hr) {
                        return $work->role_id == $hr->role_id && $work->user;
                    })->map(function ($work) {
                        return [
                            'user_id' => $work->user->user_id,
                            'name' => $work->user->name,
                            'volumeNumber' => $work->volume->volumeNumber ?? 'N/A'
                        ];
                    });

                    $usersWithRole = $usersWithRole->merge($volumeUsers);
                }

                // Hapus duplikat user
                $uniqueUsers = $usersWithRole->unique('user_id')->values();

                return [
                    'hr_id' => $hr->hresource_id,
                    'role_id' => $hr->role_id,
                    'role_name' => $roleName,
                    'jtk' => $hr->jtk,
                    'jhk' => $hr->jhk,
                    'assigned_users' => $uniqueUsers,
                    'assigned_users_count' => $uniqueUsers->count()
                ];
            });

            // Hitung total volumes
            $totalVolumesCount = WorkPackageVolume::where('workPackage_id', $workPackage_id)->count();
            $volumesWithWorkOrderCount = $volumesData->count();
            $volumesWithoutWorkOrderCount = $totalVolumesCount - $volumesWithWorkOrderCount;

            Log::info('Work Package detail loaded successfully', [
                'workPackage_id' => $workPackage_id,
                'workPack_number' => $workPackage->workPack_number,
                'volumes_count' => $volumesData->count()
            ]);

            return view('workpackage_management_detail', compact(
                'workPackage', 
                'volumesData', 
                'humanResourcesData',
                'totalVolumesCount',
                'volumesWithWorkOrderCount',
                'volumesWithoutWorkOrderCount'
            ));

        } catch (ModelNotFoundException $e) {
            Log::error('Work Package not found', ['workPackage_id' => $workPackage_id]);

            return redirect()->route('wp-management')
                ->with('error', 'Work Package tidak ditemukan.');

        } catch (Exception $e) {
            Log::error('Error loading work package detail', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('wp-management')
                ->with('error', 'Terjadi kesalahan saat memuat detail work package.');
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
                'workPackageVolume.work.user.roles'
            ]);

            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }

            $workPackages = $query->orderBy('workPack_number', 'asc')->get();

            return response()->json([
                'success' => true,
                'trs_workPackages' => $workPackages
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Work Package'
            ], 500);
        }
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
            if (!isset($category->categoryNumber) || $category->categoryNumber === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori belum memiliki nomor kategori yang valid'
                ], 400);
            }

            // Ambil nomor WP terakhir dalam kategori ini
            $lastWp = WorkPackage::where('workPack_number', 'LIKE', $category->categoryNumber . '.%')
                ->orderByRaw("CAST(SUBSTRING_INDEX(workPack_number, '.', -1) AS SIGNED) DESC")
                ->first();

            if (!$lastWp) {
                // Jika belum ada WP dalam kategori ini, mulai dari .1
                $nextNumber = $category->categoryNumber . '.1';
            } else {
                // Parse nomor terakhir dan tambahkan 1
                $lastNumber = explode('.', $lastWp->workPack_number);
                $nextSequence = (int)end($lastNumber) + 1;
                $nextNumber = $category->categoryNumber . '.' . $nextSequence;
            }

            return response()->json([
                'success' => true,
                'workPack_number' => $nextNumber,
                'categoryNumber' => $category->categoryNumber
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
            if (!isset($category->categoryNumber) || $category->categoryNumber === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori belum memiliki nomor kategori yang valid'
                ], 400);
            }

            $wpNumber = $category->categoryNumber . '.' . $sequence;

            $isAvailable = !WorkPackage::where('workPack_number', $wpNumber)->exists();

            $wpNumber = $category->categoryNumber . '.' . $sequence;

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'workPack_number' => $wpNumber
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
                'category_id' => 'required|exists:trs_category,category_id',
                'wp_sequence' => 'required|integer|min:1',
                'name' => [
                    'required',
                    'string', 
                    'max:255',
                    Rule::unique('trs_workPackage', 'name')
                ],
                'actualScope' => 'nullable|string',
                'deliverable' => 'nullable|string',
                'duration' => 'required|integer|min:1',
                'volumeQTY' => 'required|integer|min:1',

                // Step 2: Resource Data
                'role_assignments' => 'required|array|min:1',
                'role_assignments.*.role_id' => 'required|exists:mst_roles,role_id',
                'role_assignments.*.jhk' => 'required|integer|min:1',
                'role_assignments.*.users' => 'required|array|min:1',
                'role_assignments.*.users.*.user_id' => 'required|exists:users,user_id',

                // Step 3: Task Data
                'tasks' => 'nullable|array',
                'tasks.*.name' => 'required|string|max:255',
                'tasks.*.sub_tasks' => 'nullable|array',
                'tasks.*.sub_tasks.*.name' => 'required|string|max:500',
            ]);

            $duration = (int) $validatedData['duration'];
            $volumeQty = (int) $validatedData['volumeQTY'];

            // Generate WP number berdasarkan kategori
            $category = WpCategory::findOrFail($validatedData['category_id']);
            $wpNumber = $category->categoryNumber . '.' . $validatedData['wp_sequence'];

            // Cek apakah WP number sudah ada
            if (WorkPackage::where('workPack_number', $wpNumber)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => "Nomor Work Package {$wpNumber} sudah digunakan. Silakan pilih nomor lain."
                ], 422);
            }

            // Validasi total JHK dan Durasi Kerja
            $totalJhk = 0;
            $roleJhkDetails = [];

            foreach ($validatedData['role_assignments'] as $index => $roleAssignment) {
                $jhk = (int) $roleAssignment['jhk'];
                $totalJhk += $jhk;

                // Dapatkan role name untuk detail error message
                $role = Role::find($roleAssignment['role_id']);
                $roleJhkDetails[] = [
                    'role_name' => $role->name ?? "Role ID {$roleAssignment['role_id']}",
                    'jhk' => $jhk,
                    'users_count' => count($roleAssignment['users'])
                ];
            }

            if ($totalJhk > $duration) {
                $overLimit = $totalJhk - $duration;

                return response()->json([
                    'success' => false,
                    'message' => "Total Jumlah Hari Kerja melebihi durasi work package",
                    'validation_error' => [
                        'type' => 'jhk_duration_exceeded',
                        'total_jhk' => $totalJhk,
                        'duration' => $duration,
                        'over_limit' => $overLimit,
                        'role_details' => $roleJhkDetails
                    ],
                    'suggestion' => 'Kurangi JHK pada beberapa jabatan atau tingkatkan durasi pengerjaan kategori work package'
                ], 422);
            }

            Log::info('Creating work package with data:', $validatedData);

            // STEP 1: Create Work Package
            $workPackage = WorkPackage::create([
                'category_id' => $validatedData['category_id'],
                'workPack_number' => $wpNumber,
                'name' => $validatedData['name'],
                'volumeQTY' => $volumeQty,
                'duration' => $duration,
                'actualScope' => $validatedData['actualScope'],
                'deliverable' => $validatedData['deliverable'],
            ]);

            // STEP 2: Create Resource Assignments and Human Resources
            foreach ($validatedData['role_assignments'] as $roleAssignment) {
                $roleId = $roleAssignment['role_id'];
                $jhk = (int) $roleAssignment['jhk'];
                $users = $roleAssignment['users'];

                // Validate role exists
                $role = Role::find($roleId);
                if (!$role) {
                    throw new Exception("Role dengan ID {$roleId} tidak ditemukan");
                }

                // Count Jumlah Tenaga Kerja
                $jtk = count($users);

                // Validate all users exist
                foreach ($users as $userAssignment) {
                    $userId = $userAssignment['user_id'];
                    $user = User::find($userId);
                    if (!$user) {
                        throw new Exception("User dengan ID {$userId} tidak ditemukan");
                    }
                }

                // Create Human Resource for this role 
                HumanResource::create([
                    'workPackage_id' => $workPackage->workPackage_id,
                    'role_id' => $roleId,
                    'jtk' => $jtk,
                    'jhk' => $jhk,
                ]);
            }

            // STEP 3: Create Work Package Volumes and Resource Assignments
            $volumes = [];
            for ($i = 1; $i <= $volumeQty; $i++) {
                $volume = WorkPackageVolume::create([
                    'workPackage_id' => $workPackage->workPackage_id,
                    'volumeNumber' => $i,
                    'startDate' => null,
                    'endDate' => null,
                    'executionYear' => null,
                    'workOrder_id' => null,
                ]);

                $volumes[] = $volume;
            }

            foreach ($volumes as $volume) {
                foreach ($validatedData['role_assignments'] as $roleAssignment) {
                    $roleId = $roleAssignment['role_id'];
                    $users = $roleAssignment['users'];

                    foreach ($users as $userAssignment) {
                        $userId = $userAssignment['user_id'];

                        // Assign role to user
                        $user = User::find($userId);
                        $role = Role::find($roleId);

                        if ($user && $role) {
                            // Ensure the user have 'karyawan' role
                            if (!$user->hasRole('karyawan')) {
                                $user->assignRole('karyawan');
                            }
                            
                            // Assign chosen role if not exist
                            if (!$user->hasRole($role->name)) {
                                $user->assignRole($role->name);
                            }
                        }
                        
                        // Create work record for each user on volume
                        Work::create([
                            'volume_id' => $volume->volume_id,
                            'user_id' => $userId,
                            'role_id' => $roleId,
                        ]);
                        
                        Log::info('Created Work assignment:', [
                            'volume_id' => $volume->volume_id,
                            'volumeNumber' => $volume->volumeNumber,
                            'workPackage_id' => $workPackage->workPackage_id,
                            'user_id' => $userId,
                            'user_name' => $user->name,
                            'role_id' => $roleId,
                            'role_name' => $role->name,
                            'jhk' => $roleAssignment['jhk']
                        ]);
                    }
                }
            }
            
            // STEP 4: Create Tasks and Sub Tasks
            if (!empty($validatedData['tasks'])) {
                foreach ($validatedData['tasks'] as $taskIndex => $taskData) {
                    // Create task for all volumes
                    foreach ($volumes as $volume) {
                        $task = Task::create([
                            'volume_id' => $volume->volume_id,
                            'name' => $taskData['name'],
                            'status' => 'open',
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

            $totalUsersAssigned = 0;
            $roleAssignmentSummary = [];

            foreach ($validatedData['role_assignments'] as $roleAssignment) {
                $roleId = $roleAssignment['role_id'];
                $role = Role::find($roleId);
                $usersCount = count($roleAssignment['users']);
                $totalUsersAssigned += $usersCount;

                $roleAssignmentSummary[] = [
                    'role_name' => $role->name,
                    'jtk' => $usersCount,
                    'jhk' => $roleAssignment['jhk'],
                    'users_assigned' => $usersCount
                ];
            }

            Log::info('Work Package created successfully', [
                'workPackage_id' => $workPackage->workPackage_id,
                'workPack_number' => $workPackage->workPack_number,
                'name' => $workPackage->name,
                'volumes_created' => $validatedData['volumeQTY'],
                'tasks_count' => count($validatedData['tasks'] ?? [])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Package berhasil dibuat dengan lengkap',
                'trs_workPackage' => $workPackage->load(['wpCategory', 'workPackageVolumes']),
                'summary' => [
                    'volumes_created' => $volumeQty,
                    'tasks_per_volume' => count($validatedData['tasks'] ?? []),
                    'total_tasks_created' => (count($validatedData['tasks'] ?? []) * $volumeQty),
                    'role_assignments' => count($validatedData['role_assignments']),
                    'total_users_assigned' => $totalUsersAssigned,
                    'human_resources_created' => count($validatedData['role_assignments']),
                    'role_assignment_summary' => $roleAssignmentSummary
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
            $users = User::with('roles')
                    ->whereDoesntHave('roles', function($query) {
                        $query->where('name', 'admin');
                    })
                    ->orderBy('name', 'asc')
                    ->get()
                    ->map(function($user) {
                        return [
                            'user_id' => $user->user_id,
                            'name' => $user->name,
                            'current_roles' => $user->getRoleNames()->toArray()
                        ];
                    })
                    ->filter()
                    ->values();
            
            $roles = Role::whereNotIn('name', ['admin', 'karyawan'])
                        ->orderBy('name', 'asc')
                        ->get();

            return response()->json([
                'success' => true,
                'users' => $users,
                'roles' => $roles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data users dan roles'
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($workPackage_id)
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volumeNumber', 'asc');
                },
                'workPackageVolumes.work.user.roles',
                'workPackageVolumes.workOrder',
                'humanResources.role'
            ])->findOrFail($workPackage_id);

            // Ambil semua kategori untuk dropdown
            $categories = WpCategory::orderByRaw('CAST(categoryNumber AS SIGNED) ASC')->get();

            // Ambil semua users dengan roles untuk resource management
            $users = User::with('roles')->orderBy('name', 'asc')->get();
            $roles = Role::orderBy('name', 'asc')->get();

            // Transform volume data untuk edit form
            $volumesWithWorkOrder = $workPackage->workPackageVolumes()
                ->where(function($query) {
                    $query->whereNotNull('workOrder_id')
                        ->orWhere(function($subQuery) {
                            $subQuery->whereNotNull('startDate')
                                    ->whereNotNull('endDate')
                                    ->whereNotNull('executionYear');
                        });
                })
                ->orderBy('volumeNumber', 'asc')
                ->get();

            $volumesData = $volumesWithWorkOrder->map(function ($volume) {
                // Ambil resource data untuk volume ini
                $resources = $volume->work->map(function ($work) {
                    if ($work->user && $work->role) {
                        return [
                            'work_id' => $work->work_id,
                            'user_id' => $work->user->user_id,
                            'user_name' => $work->user->name,
                            'role_id' => $work->role_id,
                            'role_name' => $work->role->name
                        ];
                    }
                    return null;
                })->filter()->unique('user_id')->values();

                // Menangani period_formatted
                $periodFormatted = 'Belum tersedia';
                if ($volume->startDate && $volume->endDate) {
                    $periodFormatted = Carbon::parse($volume->startDate)->format('d M Y') . 
                                    ' - ' .
                                    Carbon::parse($volume->endDate)->format('d M Y');
                }

                // Mendapatkan nomor work order
                $woNumber = null;
                if ($volume->workOrder_id && $volume->workOrder) {
                    $woNumber = $volume->workOrder->workNumber_id;
                }

                return [
                    'volume_id' => $volume->volume_id,
                    'volumeNumber' => $volume->volumeNumber,
                    'startDate' => $volume->startDate,
                    'endDate' => $volume->endDate,
                    'executionYear' => $volume->executionYear,
                    'period_formatted' => $periodFormatted,
                    'resources' => $resources,
                    'workOrder_id' => $volume->workOrder_id,
                    'workNumber_id' => $woNumber,
                    'has_mst_workOrder' => true
                ];
            });

            // Hitung remaining volumes
            $totalVolumeQty = $workPackage->volumeQTY;
            $totalVolumesCreated = WorkPackageVolume::where('workPackage_id', $workPackage_id)->count();
            $volumesWithWorkOrderCount = $volumesData->count();
            $volumesWithoutWorkOrderCount = $totalVolumesCreated - $volumesWithWorkOrderCount;
            $remainingVolumeSlots = $totalVolumeQty - $volumesWithWorkOrderCount;

            // Transform human resources data dengan assigned users
            $humanResourcesData = $workPackage->humanResources->map(function ($hr) use ($workPackage) {
                $roleName = $hr->role->name ?? 'No Role';

                $assignedUsers = collect();
                foreach($workPackage->workPackageVolumes as $volume) {
                    $volumeUsers = $volume->work->filter(function($work) use ($hr) {
                        return $work->role_id == $hr['role_id'] && $work->user;
                    })->map(function($work) {
                        return [
                            'user_id' => $work->user->user_id,
                            'name' => $work->user->name,
                            'email' => $work->user->email,
                            'volumeNumber' => $work->volume->volumeNumber ?? 'N/A'
                        ];
                    });
                    $assignedUsers = $assignedUsers->merge($volumeUsers);
                }
                $assignedUsers = $assignedUsers->unique('user_id')->values();

                return [
                    'hr_id' => $hr->hresource_id,
                    'role_id' => $hr->role_id,
                    'role_name' => $roleName,
                    'jtk' => $hr->jtk,
                    'jhk' => $hr->jhk,
                    'assigned_users' => $assignedUsers,
                    'assigned_users_count' => $assignedUsers->count()
                ];
            });

            Log::info('Work Package edit form loaded', [
                'workPackage_id' => $workPackage_id,
                'workPack_number' => $workPackage->workPack_number
            ]);

            return view('workpackage_management_edit', compact(
                'workPackage',
                'volumesData',
                'humanResourcesData',
                'categories',
                'users',
                'roles',
                'totalVolumeQty',
                'volumesWithWorkOrderCount',
                'volumesWithoutWorkOrderCount',
                'remainingVolumeSlots'
            ));

        } catch (ModelNotFoundException $e) {
            Log::error('Work Package not found for edit', ['workPackage_id' => $workPackage_id]);

            return redirect()->route('wp-management')
                ->with('error', 'Work Package tidak ditemukan.');

        } catch (Exception $e) {
            Log::error('Error loading work package edit form', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('wp-management')
                ->with('error', 'Terjadi kesalahan saat memuat form edit data work package.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $workPackage_id)
    {
        try {
            DB::beginTransaction();

            Log::info('Updating work package', [
                'workPackage_id' => $workPackage_id, 
                'data' => $request->all(),
                'has_resources' => $request->has('resources'),
                'resources_data' => $request->input('resources', []),
                'has_mst_workOrder_assignments' => $request->has('mst_workOrder_assignments'),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);

            // Temukan data work package
            $workPackage = WorkPackage::findOrFail($workPackage_id);

            // Validasi request
            $validatedData = $request->validate([
                // Informasi umum work package
                'category_id' => 'required|exists:trs_category,category_id',
                'wp_sequence' => 'required|integer|min:1',
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('trs_workPackage', 'name')->ignore($workPackage_id, 'workPackage_id')
                ],
                'actualScope' => 'nullable|string',
                'deliverable' => 'nullable|string',
                'duration' => 'required|integer|min:1',

                // Volume data
                // 'volumes' => 'nullable|array|min:0',
                // 'volumes.*.volume_id' => 'required_with:volumes|integer',
                // 'volumes.*.volumeNumber' => 'required_with:volumes|integer|min:1',

                // Deleted volumes
                'deleted_volumes' => 'nullable|array',
                'deleted_volumes.*' => 'exists:trs_workPackVolume,volume_id',

                // Resource data
                'resources' => 'required|array|min:1',
                'resources.*.hr_id' => 'nullable',
                'resources.*.role_id' => 'required|exists:mst_roles,role_id',
                'resources.*.jtk' => 'required|integer|min:1',
                'resources.*.jhk' => 'required|integer|min:1',
                'resources.*.users' => 'nullable|array',
                'resources.*.users.*.user_id' => 'required_with:resources.*.users|exists:users,user_id',

                // Volume changes validation
                'volume_changes' => 'nullable|string',
            ], [
                'name.unique' => 'Nama Work Package sudah digunakan. Silakan pilih nama yang berbeda.',
                'name.required' => 'Nama Work Package harus diisi.',
            ]);

            // CHECK DATA UPDATE CHANGES
            // Ambil original data untuk perbandingan
            $originalCategoryId = $workPackage->category_id;
            $originalWpNumber = $workPackage->workPack_number;
            $originalName = trim($workPackage->name);
            $originalActualScope = trim($workPackage->actualScope ?? '');
            $originalDeliverable = trim($workPackage->deliverable ?? '');
            $originalDuration = (int)$workPackage->duration;
            
            // Mendapatkan data original human resources
            $originalHumanResources = $workPackage->humanResources()
                ->with(['role'])
                ->orderBy('role_id', 'asc')
                ->get()
                ->map(function($hr) use ($workPackage) {
                    // Ambil user assignments untuk role ini dari semua volume
                    $userAssignments = collect();
                    foreach($workPackage->workPackageVolumes as $volume) {
                        $volumeUsers = $volume->work->filter(function($work) use ($hr) {
                            return $work->role_id == $hr->role_id && $work->user;
                        })->map(function($work) {
                            return $work->user_id;
                        });
                        $userAssignments = $userAssignments->merge($volumeUsers);
                    }
                    
                    // Hapus duplikat dan sort untuk comparison
                    $uniqueUserIds = $userAssignments->unique()->sort()->values()->toArray();

                    return [
                        'role_id' => $hr->role_id,
                        'jtk' => $hr->jtk,
                        'jhk' => $hr->jhk,
                        'assigned_user_ids' => $uniqueUserIds 
                    ];
                })
                ->toArray();

            $category = WpCategory::findOrFail($validatedData['category_id']);
            $newWpNumber = $category->categoryNumber . '.' . $validatedData['wp_sequence'];

            $newCategoryId = (int)$validatedData['category_id'];
            $newName = trim($validatedData['name']);
            $newActualScope = trim($validatedData['actualScope'] ?? '');
            $newDeliverable = trim($validatedData['deliverable'] ?? '');
            $newDuration = (int)$validatedData['duration'];

            // Cek perubahan informasi umum
            $categoryChanged = $originalCategoryId != $newCategoryId;
            $wpNumberChanged = $originalWpNumber !== $newWpNumber;
            $nameChanged = $originalName !== $newName;
            $actualScopeChanged = $originalActualScope !== $newActualScope;
            $deliverableChanged = $originalDeliverable !== $newDeliverable;
            $durationChanged = $originalDuration !== $newDuration;

            // Cek perubahan dengan parse volume
            $volumeChanges = null;
            $hasVolumeChanges = false;

            if ($request->has('volume_changes') && !empty($request->input('volume_changes'))) {
                try {
                    $volumeChanges = json_decode($request->input('volume_changes'), true);

                    // Validate JSON decode 
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $volumeChanges = null;
                    } else {
                        $hasNewVolumes = !empty($volumeChanges['new_volumes']);
                        $hasRemovedVolumes = !empty($volumeChanges['removed_volumes']);
                        $hasVolumeChanges = $hasNewVolumes || $hasRemovedVolumes;
                    }
                    
                } catch (Exception $e) {
                    $volumeChanges = null;
                    $hasVolumeChanges = false;
                }
            }

            // Cek perubahan human resources
            $newHumanResources = collect($validatedData['resources'])
                ->map(function($resource) {
                    // Extract user IDs dan sort untuk comparison
                    $userIds = collect($resource['users'] ?? [])
                        ->pluck('user_id')
                        ->map(function($id) { return (int)$id; })
                        ->sort()
                        ->values()
                        ->toArray();

                    return [
                        'role_id' => (int)$resource['role_id'],
                        'jtk' => (int)$resource['jtk'],
                        'jhk' => (int)$resource['jhk'],
                        'assigned_user_ids' => $userIds
                    ];
                })
                ->sortBy('role_id')
                ->values()
                ->toArray();
            
            $humanResourcesChanged = $originalHumanResources !== $newHumanResources;

            // Perbandingan untuk menentukan adanya perubahan
            $hasChanges = $categoryChanged ||
                        $wpNumberChanged || 
                        $nameChanged || 
                        $actualScopeChanged || 
                        $deliverableChanged || 
                        $durationChanged ||
                        $humanResourcesChanged ||
                        $hasVolumeChanges;

            // Log Perbandingan Perubahan
            Log::info('Final change detection result', [
                'workPackage_id' => $workPackage_id,
                'has_changes' => $hasChanges,
                'detailed_changes' => [
                    'category_changed' => $categoryChanged,
                    'workPack_number_changed' => $wpNumberChanged,
                    'name_changed' => $nameChanged,
                    'actual_scope_changed' => $actualScopeChanged,
                    'deliverable_changed' => $deliverableChanged,
                    'duration_changed' => $durationChanged,
                    'human_resources_changed' => $humanResourcesChanged,
                    'volume_changes' => $hasVolumeChanges
                ],
                'volume_changes_detail' => $volumeChanges
            ]);
            
            if (!$hasChanges) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data yang terdeteksi.',
                    'current_data' => [
                        'workPack_number' => $workPackage->workPack_number,
                        'name' => $workPackage->name,
                        'category' => $workPackage->wpCategory->name ?? 'Unknown',
                        'duration' => $workPackage->duration . ' hari',
                        'resources_count' => count($originalHumanResources),
                        'volume_changes_detected' => $hasVolumeChanges
                    ]
                ], 200);
            }

            // UPDATE OPERATION
            // Step 0: Update WP Number if category or sequence changed
            $category = WpCategory::findOrFail($validatedData['category_id']);
            $newWpNumber = $category->categoryNumber . '.' . $validatedData['wp_sequence'];

            // Cek jika nomor WP berubah dan nomor baru tersedia
            if ($newWpNumber !== $workPackage->workPack_number) {
                if (WorkPackage::where('workPack_number', $newWpNumber)->where('workPackage_id', '!=', $workPackage_id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Nomor Work Package {$newWpNumber} sudah digunakan. Silahkan pilih nomor lain."
                    ], 422);
                }

                Log::info('WP Number changed', [
                    'old_workPack_number' => $workPackage->workPack_number,
                    'new_workPack_number' => $newWpNumber
                ]);
            }

            // Step 1: Update informasi umum work package
            $currentVolumeCount = WorkPackageVolume::where('workPackage_id', $workPackage_id)->count();

            $workPackage->update([
                'category_id' => $validatedData['category_id'],
                'workPack_number' => $newWpNumber,
                'name' => $validatedData['name'],
                'duration' => $validatedData['duration'],
                'actualScope' => $validatedData['actualScope'],
                'deliverable' => $validatedData['deliverable'],
                'volumeQTY' => $currentVolumeCount
            ]);

            // Step 2: Update volume data
            if ($hasVolumeChanges && $volumeChanges) {
                $this->processVolumeChanges($volumeChanges, $workPackage_id);
            }

            // Step 3: Update human resources
            // Get current role IDs from the request
            $newRoleIds = collect($validatedData['resources'])->pluck('role_id')->unique()->toArray();
        
            // Get existing role IDs from current Human Resources
            $existingRoleIds = HumanResource::where('workPackage_id', $workPackage_id)->pluck('role_id')->toArray();
            
            // Find roles that are being removed
            $removedRoleIds = array_diff($existingRoleIds, $newRoleIds);

            // Remove Work assignments for users with removed roles from all volumes
            if (!empty($removedRoleIds)) {
                $volumeIds = WorkPackageVolume::where('workPackage_id', $workPackage_id)->pluck('volume_id');

                // Delete Work assignments for removed roles
                $deletedWorkCount = Work::whereIn('volume_id', $volumeIds)
                    ->whereIn('role_id', $removedRoleIds)
                    ->delete();
                
                // Delete Timesheet records for removed roles
                $deletedTimesheetCount = Timesheet::whereIn('volume_id', $volumeIds)
                    ->whereHas('user', function($query) use ($removedRoleIds) {
                        $query->whereHas('roles', function($subQuery) use ($removedRoleIds) {
                            $subQuery->whereIn('id', $removedRoleIds);
                        });
                    })
                    ->delete();
            }

            // Delete existing human resources
            HumanResource::where('workPackage_id', $workPackage_id)->delete();

            // Get all volume IDs for this work package
            $volumeIds = WorkPackageVolume::where('workPackage_id', $workPackage_id)->pluck('volume_id');

            // Create new human resources and update work assignments
            foreach ($validatedData['resources'] as $resourceData) {
                $roleId = $resourceData['role_id'];
                $jtk = $resourceData['jtk'];
                $jhk = $resourceData['jhk'];
                $users = $resourceData['users'] ?? [];

                // Create Human Resource
                $humanResource = HumanResource::create([
                    'workPackage_id' => $workPackage_id,
                    'role_id' => $roleId,
                    'jtk' => $jtk,
                    'jhk' => $jhk,
                ]);

                // Remove existing work assignments for this role in all volumes
                Work::whereIn('volume_id', $volumeIds)
                    ->where('role_id', $roleId)
                    ->delete();

                // Create new work assignemnts for each user and each volume
                foreach ($users as $userData) {
                    $userId = $userData['user_id'];

                    // Validate user exists
                    $user = User::find($userId);
                    if (!$user) {
                        throw new Exception("User dengan ID {$userId} tidak ditemukan");
                    }

                    // Assign role to user if not already assigned
                    if (!$user->hasRole(Role::find($roleId)->name)) {
                        $user->assignRole(Role::find($roleId)->name);
                    }

                    // Create work assignment for each volume
                    foreach ($volumeIds as $volumeId) {
                        Work::create([
                            'volume_id' => $volumeId,
                            'user_id' => $userId,
                            'role_id' => $roleId,
                        ]);
                    }
                }
            }

            DB::commit();

            Log::info('Work Package updated successfully', [
                'workPackage_id' => $workPackage_id,
                'workPack_number' => $workPackage->workPack_number,
                'name' => $workPackage->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Package berhasil diperbarui',
                'redirect_url' => route('wp-management.detail', $workPackage_id),
                'updated_data' => [
                    'workPack_number' => $workPackage->workPack_number,
                    'name' => $workPackage->name,
                    'category' => $category->name,
                    'duration' => $workPackage->duration,
                    'volumes_count' => 0,
                    'resources_count' => count($validatedData['resources']),
                    'total_users_assigned' => collect($validatedData['resources'])
                        ->sum(function($resource) {
                            return count($resource['users'] ?? []);
                        }),
                    'volume_changes_applied' => $hasVolumeChanges
                ]
            ]);

        } catch (ValidationException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error updating work package', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui Work Package: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if work package name is available
     */
    public function checkWorkPackageName(Request $request)
    {
        try {
            $name = trim($request->get('name'));
            $excludeId = $request->get('exclude_id'); // Untuk edit

            if (!$name) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nama Work Package diperlukan'
                ], 400);
            }

            $query = WorkPackage::where('name', $name);

            // Exclude current work package ID saat edit
            if ($excludeId) {
                $query->where('workPackage_id', '!=', $excludeId);
            }

            $exists = $query->exists();

            return response()->json([
                'success' => true,
                'available' => !$exists,
                'name' => $name,
                'message' => $exists ? 'Nama Sub Work Package sudah digunakan' : 'Nama Sub Work Package tersedia'
            ]);

        } catch (Exception $e) {
            Log::error('Error checking work package name availability', [
                'name' => $request->get('name'),
                'exclude_id' => $request->get('exclude_id'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa ketersediaan nama Work Package'
            ], 500);
        }
    }

    /**
     * Process volume changes
     */
    private function processVolumeChanges($volumeChanges, $workPackage_id) 
    {
        try {
            // Process removed volumes
            if (!empty($volumeChanges['removed_volumes'])) {
                foreach ($volumeChanges['removed_volumes'] as $volumeId) {
                    $volume = WorkPackageVolume::find($volumeId);

                    if ($volume && $volume->workPackage_id == $workPackage_id) {
                        $volume->update([
                            'workOrder_id' => null,
                            'startDate' => null,
                            'endDate' => null,
                            'executionYear' => null
                        ]);
                    }
                }
            }

            // Process new volumes
            if (!empty($volumeChanges['new_volumes'])) {
                foreach ($volumeChanges['new_volumes'] as $newVolumeData) {
                    $volume = WorkPackageVolume::where('workPackage_id', $workPackage_id)
                        ->where('volumeNumber', $newVolumeData['volumeNumber'])
                        ->first();
                    
                    if ($volume) {
                        $volume->update([
                            'startDate' => $newVolumeData['startDate'],
                            'endDate' => $newVolumeData['endDate'],
                            'executionYear' => $newVolumeData['executionYear']
                        ]);
                    }
                }
            }

        } catch (Exception $e) {
            Log::error('Error processing volume changes', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Check if a role has user assignments in work packages volumes
     */
    public function checkRoleAssignments(Request $request)
    {
        try {
            $wpId = $request->input('workPackage_id');
            $roleId = $request->input('role_id');

            // Validate input
            if (!$wpId || !$roleId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Work Package dan Peran tidak ditemukan'
                ], 400);
            }

            // Get work package
            $workPackage = WorkPackage::findOrFail($wpId);

            // Get all volume IDs for this work package
            $volumeIds = WorkPackageVolume::where('workPackage_id', $wpId)->pluck('volume_id');

            if ($volumeIds->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'has_assignments' => false,
                    'assignment_details' => null,
                    'message' => 'Tidak ada volume dalam work package ini'
                ]);
            }

            // Get users with this specific role
            $userWithRoles = User::whereHas('roles', function($query) use ($roleId) {
                $query->where('id', $roleId);
            })->with('roles')->get();

            if ($userWithRoles->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'has_assignments' => false,
                    'assignment_details' => null,
                    'message' => 'Tidak ada user dengan role ini'
                ]);
            }

            $userIds = $userWithRoles->pluck('user_id')->toArray();

            // Check if any of these users have Work assignments in the work package volumes
            $workAssignments = Work::whereIn('volume_id', $volumeIds)
                ->whereIn('user_id', $userIds)
                ->with(['user', 'volume'])
                ->get();
            
            if ($workAssignments->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'has_assignments' => false,
                    'assignment_details' => null,
                    'message' => 'User dengan role ini belum di-assign pada volume work package'
                ]);
            }

            // Build assignment details
            $affectedUsers = $workAssignments->groupBy('user_id')->map(function($assignments, $userId) {
                $user = $assignments->first()->user;
                return [
                    'user_id' => $userId,
                    'name' => $user->name,
                    'volumes' => $assignments->map(function($assignment) {
                        return [
                            'volume_id' => $assignment->volume_id,
                            'volumeNumber' => $assignment->volume->volumeNumber ?? 'Unknown'
                        ];
                    })->unique('volume_id')->values()->toArray()
                ];
            })->values();

            // Count statistics
            $stats = [
                'total_assignments' => $workAssignments->count(),
                'affected_users_count' => $affectedUsers->count(),
                'affected_volumes_count' => $workAssignments->pluck('volume_id')->unique()->count(),
                'total_timesheets' => Timesheet::whereIn('volume_id', $volumeIds)
                    ->whereIn('user_id', $userIds)
                    ->count()
            ];

            $assignmentDetails = [
                'affected_users' => $affectedUsers->toArray(),
                'volumes_count' => $stats['affected_volumes_count'],
                'assignments_count' => $stats['total_assignments'],
                'timesheets_count' => $stats['total_timesheets'],
                'stats' => $stats
            ];

            return response()->json([
                'success' => true,
                'has_assignments' => true,
                'assignment_details' => $assignmentDetails,
                'message' => 'Role memiliki user yang di-assign pada volume work package'
            ]);

        } catch (ModelNotFoundException $e) {
            Log::error('Work Package not found during role assignment check', [
                'workPackage_id' => $request->input('workPackage_id'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Work Package tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error checking role assignments', [
                'workPackage_id' => $request->input('workPackage_id'),
                'role_id' => $request->input('role_id'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa assignment role: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check work package associations before deletion
     */
    public function checkWorkPackageAssociations($workPackage_id) 
    {
        try {
            $workPackage = WorkPackage::findOrFail($workPackage_id);

            // Mendapatkan semua volumes untuk work package ini
            $volumes = WorkPackageVolume::where('workPackage_id', $workPackage_id)->get();
            $volumeIds = $volumes->pluck('volume_id');

            // Cek data asosiasi di seluruh volume
            $volumesCount = $volumes->count();
            $tasksCount = Task::whereIn('volume_id', $volumeIds)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volumeIds) {
                $query->whereIn('volume_id', $volumeIds);
            })->count();
            $workAssignmentsCount = Work::whereIn('volume_id', $volumeIds)->count();
            $timesheetsCount = Timesheet::whereIn('volume_id', $volumeIds)->count();
            $humanResourcesCount = HumanResource::where('workPackage_id', $workPackage_id)->count();

            $hasAssociations = $volumesCount > 0 || $tasksCount > 0 || $subtasksCount > 0 ||
                                $workAssignmentsCount > 0 || $timesheetsCount > 0 || $humanResourcesCount > 0;
            
            return response()->json([
                'success' => true,
                'has_associations' => $hasAssociations,
                'associations' => [
                    'volumes_count' => $volumesCount,
                    'tasks_count' => $tasksCount,
                    'subtasks_count' => $subtasksCount,
                    'work_assignments_count' => $workAssignmentsCount,
                    'timesheets_count' => $timesheetsCount,
                    'human_resources_count' => $humanResourcesCount
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Work Package tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error checking work package associations', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa data work package'
            ], 500);
        }
    }

    /**
     * Force delete the specified work package with all associated data
     */
    public function forceDeleteWorkPackage(Request $request, $workPackage_id)
    {
        try {
            DB::beginTransaction();

            $workPackage = WorkPackage::with(['wpCategory'])->findOrFail($workPackage_id);

            Log::info('Force deleting work package with associations', [
                'workPackage_id' => $workPackage_id,
                'workPack_number' => $workPackage->workPack_number,
                'wp_name' => $workPackage->name,
                'force' => $request->input('force', false)
            ]);

            // Mendapatkan seluruh volume dari work package ini
            $volumes = WorkPackageVolume::where('workPackage_id', $workPackage_id)->get();
            $volumeIds = $volumes->pluck('volume_id');

            // Hitung asosiasi sebelum melakukan penghapusan
            $volumesCount = $volumes->count();
            $tasksCount = Task::whereIn('volume_id', $volumeIds)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volumeIds) {
                $query->whereIn('volume_id', $volumeIds);
            })->count();
            $workAssignmentsCount = Work::whereIn('volume_id', $volumeIds)->count();
            $timesheetsCount = Timesheet::whereIn('volume_id', $volumeIds)->count();
            $humanResourcesCount = HumanResource::where('workPackage_id', $workPackage_id)->count();

            // Hapus semua sub tasks dari suatu task pada semua volume
            if ($subtasksCount > 0) {
                $taskIds = Task::whereIn('volume_id', $volumeIds)->pluck('task_id');
                SubTask::whereIn('task_id', $taskIds)->delete();

                Log::info('Deleted sub tasks', [
                    'workPackage_id' => $workPackage_id,
                    'subtasks_deleted' => $subtasksCount
                ]);
            }

            // Hapus semua task pada semua volume
            if ($tasksCount > 0) {
                Task::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted tasks', [
                    'workPackage_id' => $workPackage_id,
                    'tasks_deleted' => $tasksCount
                ]);
            }

            // Hapus semua timesheet pada semua volume
            if ($timesheetsCount > 0) {
                Timesheet::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted timesheets', [
                    'workPackage_id' => $workPackage_id,
                    'timesheets_deleted' => $timesheetsCount
                ]);
            }

            // Hapus semua work assignment (resources) pada semua volume
            if ($workAssignmentsCount > 0) {
                Work::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted work assignments', [
                    'workPackage_id' => $workPackage_id,
                    'work_assignments_deleted' => $workAssignmentsCount
                ]);
            }

            // Hapus semua human resources untuk work package ini
            if ($humanResourcesCount > 0) {
                HumanResource::where('workPackage_id', $workPackage_id)->delete();

                Log::info('Deleted human resources', [
                    'workPackage_id' => $workPackage_id,
                    'human_resources_deleted' => $humanResourcesCount
                ]);
            }

            // Hapus semua volume untuk work package ini
            if ($volumesCount > 0) {
                WorkPackageVolume::where('workPackage_id', $workPackage_id)->delete();

                Log::info('Deleted volumes', [
                    'workPackage_id' => $workPackage_id,
                    'volumes_deleted' => $volumesCount
                ]);
            }

            // Hapus work package itu sendiri
            $workPackageData = [
                'workPackage_id' => $workPackage->workPackage_id,
                'workPack_number' => $workPackage->workPack_number,
                'name' => $workPackage->name,
                'category_id' => $workPackage->category_id,
                'category_name' => $workPackage->wpCategory->name ?? 'Unknown',
                'duration' => $workPackage->duration,
                'volumeQTY' => $workPackage->volumeQTY,
                'actualScope' => $workPackage->actualScope,
                'deliverable' => $workPackage->deliverable
            ];

            $workPackage->delete();

            DB::commit();

            Log::info('Work Package force deleted successfully', [
                'deleted_trs_workPackage' => $workPackageData,
                'associated_data_deleted' => [
                    'volumes' => $volumesCount,
                    'tasks' => $tasksCount,
                    'subtasks' => $subtasksCount,
                    'work_assignments' => $workAssignmentsCount,
                    'timesheets' => $timesheetsCount,
                    'human_resources' => $humanResourcesCount
                ],
                'deleted_by' => auth()->id() ?? 'system',
                'deleted_at' => now()->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Package dan semua data terkait berhasil dihapus',
                'deleted_data' => [
                    'trs_workPackage' => $workPackageData,
                    'volumes_deleted' => $volumesCount,
                    'tasks_deleted' => $tasksCount,
                    'subtasks_deleted' => $subtasksCount,
                    'work_assignments_deleted' => $workAssignmentsCount,
                    'timesheets_deleted' => $timesheetsCount,
                    'human_resources_deleted' => $humanResourcesCount
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            Log::warning('Work Package not found for deletion', [
                'workPackage_id' => $workPackage_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Work Package tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error force deleting work package', [
                'workPackage_id' => $workPackage_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Work Package: ' . $e->getMessage()
            ], 500);
        }
    }
}
