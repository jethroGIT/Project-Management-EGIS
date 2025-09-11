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
                        if ($work->user && $work->role) {
                            // $userRoles = $work->user->getRoleNames();
                            // $roleName = 'No Role';

                            // if ($userRoles->contains('karyawan')) {
                            //     // Ambil role selain 'karyawan' dan 'admin'
                            //     $karyawanRoles = $userRoles->filter(function($roleName) {
                            //         return $roleName !== 'karyawan' && $roleName !== 'admin';
                            //     });
                                
                            //     if ($karyawanRoles->isNotEmpty()) {
                            //         $roleName = $karyawanRoles->first();
                            //     } else {
                            //         $roleName = 'karyawan';
                            //     }
                            // } else {
                            //     // Jika tidak ada role 'karyawan', ambil role pertama yang bukan admin
                            //     $nonAdminRoles = $userRoles->filter(function($roleName) {
                            //         return $roleName !== 'admin';
                            //     });
                            //     $roleName = $nonAdminRoles->first() ?? $userRoles->first() ?? 'No Role';
                            // }

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
     * Display the detailed view of a specific work package
     */
    public function detail($wp_id) 
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->whereNotNull('wo_id')
                            ->orderBy('volume_number', 'asc');
                },
                'workPackageVolumes.work.user.roles',
                'workPackageVolumes.workOrder',
                'humanResources.role'
            ])->findOrFail($wp_id);

            // Transform volume data untuk tampilan
            $volumesData = $workPackage->workPackageVolumes->map(function ($volume) use($workPackage) {
                // Ambil resource names untuk volume ini
                $resourceNames = $volume->work->map(function ($work) {
                    if ($work->user && $work->role) {
                        // $roleName = $work->user->getRoleNames()->get(1) ?? $work->user->getRoleNames()->first() ?? 'No Role';
                        // return $work->user->name . ' (' . $roleName . ')';
                        // $userRoles = $work->user->getRoleNames();
                        // $roleName = 'No Role';
                        
                        // if ($userRoles->contains('karyawan')) {
                        //     // Ambil role selain 'karyawan' dan 'admin'
                        //     $karyawanRoles = $userRoles->filter(function($roleName) {
                        //         return $roleName !== 'karyawan' && $roleName !== 'admin';
                        //     });
                            
                        //     if ($karyawanRoles->isNotEmpty()) {
                        //         $roleName = $karyawanRoles->first();
                        //     } else {
                        //         $roleName = 'karyawan';
                        //     }
                        // } else {
                        //     // Jika tidak ada role 'karyawan', ambil role pertama yang bukan admin
                        //     $nonAdminRoles = $userRoles->filter(function($roleName) {
                        //         return $roleName !== 'admin';
                        //     });
                        //     $roleName = $nonAdminRoles->first() ?? $userRoles->first() ?? 'No Role';
                        // }

                        return $work->user->name . ' (' . $work->role->name . ')';
                    }
                    return null;
                })->filter()->unique()->values();

                // Menangani tanggal null
                $periodFormatted = "Belum tersedia";
                if ($volume->start_date && $volume->end_date) {
                    $periodFormatted = Carbon::parse($volume->start_date)->format('d M Y') . 
                                        ' - ' .
                                        Carbon::parse($volume->end_date)->format('d M Y');
                }

                // Mendapatkan nomor work order
                $woNumber = null;
                if ($volume->wo_id && $volume->workOrder) {
                    $woNumber = $volume->workOrder->wo_number;
                }

                return [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date,
                    'execution_year' => $volume->execution_year,
                    'period_formatted' => $periodFormatted,
                    'duration_days' => $workPackage->duration,
                    'resource_names' => $resourceNames->implode(', ') ?: 'Belum ada resource',
                    'resource_count' => $resourceNames->count(),
                    'wo_id' => $volume->wo_id,
                    'wo_number' => $woNumber,
                    'has_work_order' => !is_null($volume->wo_id)
                ];
            });

            // Transform human resources data
            $humanResourcesData = $workPackage->humanResources->map(function ($hr) {
                return [
                    'role_id' => $hr->role_id,
                    'role_name' => $hr->role->name ?? 'Unknown Role',
                    'jtk' => $hr->jtk,
                    'jhk' => $hr->jhk
                ];
            });

            // Hitung total volumes
            $totalVolumesCount = WorkPackageVolume::where('wp_id', $wp_id)->count();
            $volumesWithWorkOrderCount = $volumesData->count();
            $volumesWithoutWorkOrderCount = $totalVolumesCount - $volumesWithWorkOrderCount;

            Log::info('Work Package detail loaded successfully', [
                'wp_id' => $wp_id,
                'wp_number' => $workPackage->wp_number,
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
            Log::error('Work Package not found', ['wp_id' => $wp_id]);

            return redirect()->route('wp-management')
                ->with('error', 'Work Package tidak ditemukan.');

        } catch (Exception $e) {
            Log::error('Error loading work package detail', [
                'wp_id' => $wp_id,
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
                // 'resources' => 'required|array|min:1',
                // 'resources.*.user_id' => 'required|exists:user,user_id',
                // 'resources.*.role_id' => 'required|exists:roles,id',
                // 'resources.*.jhk' => 'required|integer|min:1',
                'role_assignments' => 'required|array|min:1',
                'role_assignments.*.role_id' => 'required|exists:roles,id',
                'role_assignments.*.jhk' => 'required|integer|min:1',
                'role_assignments.*.users' => 'required|array|min:1',
                'role_assignments.*.users.*.user_id' => 'required|exists:user,user_id',

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
                    'suggestion' => 'Kurangi JHK pada beberapa role atau tingkatkan durasi work package'
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

            // STEP 2: Create Resource Assignments and Human Resources
            // $volumes = [];
            // for ($i = 1; $i <= $volumeQty; $i++) {
            //     $volume = WorkPackageVolume::create([
            //         'wp_id' => $workPackage->wp_id,
            //         'volume_number' => $i,
            //         'start_date' => null,
            //         'end_date' => null,
            //         'execution_year' => null,
            //     ]);

            //     $volumes[] = $volume;
            // }
            
            // foreach ($volumes as $volume) {
            //     foreach ($validatedData['resources'] as $resourceData) {
            //         $user = User::with('roles')->find($resourceData['user_id']);

            //         if (!$user || $user->roles->isEmpty()) {
            //             throw new Exception("User dengan ID {$resourceData['user_id']} tidak ditemukan atau belum memiliki role");
            //         }

            //         // Create work record for each user on volume
            //         Work::create([
            //             'volume_id' => $volume->volume_id,
            //             'user_id' => $resourceData['user_id'],
            //         ]);

            //         Log::info('Created Work record:', [
            //             'volume_id' => $volume->volume_id,
            //             'volume_number' => $volume->volume_number,
            //             'user_id' => $resourceData['user_id'],
            //             'user_name' => $user->name,
            //             'role_name' => $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first() ?? 'No Role',
            //         ]);
            //     }
            // }

            // Create Human Resources for each volume
            // $resourcesByRole = [];

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
                    'wp_id' => $workPackage->wp_id,
                    'role_id' => $roleId,
                    'jtk' => $jtk,
                    'jhk' => $jhk,
                ]);

                // Group by role untuk menghitung JTK dan total JHK
                // if (!isset($resourcesByRole[$roleId])) {
                //     $resourcesByRole[$roleId] = [
                //         'role_id' => $roleId,
                //         'role_name' => $role->name,
                //         'jtk' => 0,
                //         'total_jhk' => 0,
                //         'assignments' => []
                //     ];
                // }

                // Increment JTK (Jumlah Tenaga Kerja)
                // $resourcesByRole[$roleId]['jtk'] += 1;

                // Tambah JHK ke total
                // $resourcesByRole[$roleId]['total_jhk'] += $jhk;
            
                // Simpan individual assignment
                // $resourcesByRole[$roleId]['assignments'][] = [
                //     'user_id' => $userId,
                //     'user_name' => $user->name,
                //     'role_id' => $roleId,
                //     'jhk' => $jhk
                // ];
            }

            // foreach ($validatedData['resources'] as $resourceData) {
            //     $user = User::with('roles')->find($resourceData['user_id']);

            //     if (!$user || $user->roles->isEmpty()) {
            //         throw new Exception("User dengan ID {$resourceData['user_id']} tidak ditemukan atau belum memiliki role");
            //     }
                
            //     // $roleId = $user->roles->first()?->id ?? null;
            //     // $roleName = $user->getRoleNames()->get(1) ?? $user->getRoleNames()->first() ?? 'No Role';
            //     $userRoles = $user->getRoleNames();
            //     $roleId = null;
            //     $roleName = 'No Role';

            //     // Get role using filter
            //     $karyawanRoles = $userRoles->filter(function($roleName) {
            //         return $roleName !== 'karyawan' && $roleName !== 'admin';
            //     });

            //     if ($karyawanRoles->isNotEmpty()) {
            //         $roleName = $karyawanRoles->first();
            //         $roleId = $user->roles->where('name', $roleName)->first()?->id;
            //     } else if ($userRoles->contains('karyawan')) {
            //         $roleName = 'karyawan';
            //         $roleId = $user->roles->where('name', 'karyawan')->first()?->id;
            //     } else {
            //         $roleName = $userRoles->first() ?? 'No Role';
            //         $roleId = $user->roles->first()?->id;
            //     }

            //     // Group by role_id and count JTK
            //     if (!isset($resourcesByRole[$roleId])) {
            //         $resourcesByRole[$roleId] = [
            //             'role_id' => $roleId,
            //             'role_name' => $roleName,
            //             'jtk' => 0,
            //             'total_jhk' => 0,
            //             'users' => []
            //         ];
            //     }

            //     // Count jumlah orang dengan role yang sama
            //     $resourcesByRole[$roleId]['jtk'] += 1;

            //     // Total hari kerja untuk role ini
            //     $resourcesByRole[$roleId]['total_jhk'] += (int) $resourceData['jhk'];
                
            //     $resourcesByRole[$roleId]['users'][] = [
            //         'user_id' => $user->user_id,
            //         'name' => $user->name,
            //         'jhk' => (int) $resourceData['jhk']
            //     ];
            // }

            // Create Human resource
            // foreach ($resourcesByRole as $roleData) {
                
            // }

            // STEP 3: Create Work Package Volumes and Resource Assignments
            $volumes = [];
            for ($i = 1; $i <= $volumeQty; $i++) {
                $volume = WorkPackageVolume::create([
                    'wp_id' => $workPackage->wp_id,
                    'volume_number' => $i,
                    'start_date' => null,
                    'end_date' => null,
                    'execution_year' => null,
                    'wo_id' => null,
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
                                
                                // Log::info('Role assigned to user', [
                                //     'user_id' => $userId,
                                //     'user_name' => $user->name,
                                //     'role_id' => $roleId,
                                //     'role_name' => $role->name,
                                //     'wp_id' => $workPackage->wp_id
                                // ]);
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
                            'volume_number' => $volume->volume_number,
                            'wp_id' => $workPackage->wp_id,
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
                'wp_id' => $workPackage->wp_id,
                'wp_number' => $workPackage->wp_number,
                'name' => $workPackage->name,
                'volumes_created' => $validatedData['volume_qty'],
                // 'resources_count' => count($validatedData['resources']),
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
                        // $userRoles = $user->getRoleNames();
                        // $displayRole = 'No Role';

                        // if ($userRoles->contains('admin')) {
                        //     $displayRole = 'admin';
                        // } else {
                        //     $karyawanRoles = $userRoles->filter(function($roleName) {
                        //         return $roleName !== 'karyawan';
                        //     });

                        //     if ($karyawanRoles->isNotEmpty()) {
                        //         $displayRole = $karyawanRoles->first();
                        //     }
                        // }

                        return [
                            'user_id' => $user->user_id,
                            'name' => $user->name,
                            // 'role' => [
                            //     'name' => $displayRole
                            // ]
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
    public function edit($wp_id)
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volume_number', 'asc');
                },
                'workPackageVolumes.work.user.roles',
                'workPackageVolumes.workOrder',
                'humanResources.role'
            ])->findOrFail($wp_id);

            // Ambil semua kategori untuk dropdown
            $categories = WpCategory::orderBy('name', 'asc')->get();

            // Ambil semua users dengan roles untuk resource management
            $users = User::with('roles')->orderBy('name', 'asc')->get();
            $roles = Role::orderBy('name', 'asc')->get();

            // Transform volume data untuk edit form
            $volumesWithWorkOrder = $workPackage->workPackageVolumes()
                ->whereNotNull('wo_id')
                ->orderBy('volume_number', 'asc')
                ->get();

            $volumesData = $volumesWithWorkOrder->map(function ($volume) {
                // Ambil resource data untuk volume ini
                $resources = $volume->work->map(function ($work) {
                    if ($work->user && $work->role) {
                        // $userRoles = $work->user->getRoleNames();
                        // $roleName = 'No Role';

                        // ✅ DEBUG: Log untuk melihat roles user
                        // Log::info('User roles debug in edit method', [
                        //     'user_name' => $work->user->name,
                        //     'all_roles' => $userRoles->toArray(),
                        //     'roles_count' => $userRoles->count()
                        // ]);

                        // if ($userRoles->contains('karyawan')) {
                        //     $karyawanRoles = $userRoles->filter(function($roleName) {
                        //         return $roleName !== 'karyawan' && $roleName !== 'admin';
                        //     });
    
                        //     if ($karyawanRoles->isNotEmpty()) {
                        //         $roleName = $karyawanRoles->first();
                        //     } else {
                        //         $roleName = 'karyawan';
                        //     } 
                        // } else {
                        //     $roleName = $userRoles->first() ?? 'No Role';
                        // }

                        // ✅ DEBUG: Log hasil role yang dipilih
                        // Log::info('Selected role debug in edit method', [
                        //     'user_name' => $work->user->name,
                        //     'selected_role' => $roleName
                        // ]);

                        return [
                            'work_id' => $work->work_id,
                            'user_id' => $work->user->user_id,
                            'user_name' => $work->user->name,
                            // 'role_id' => $work->user->roles->first()?->id,
                            'role_id' => $work->role_id,
                            'role_name' => $work->role->name
                        ];
                    }
                    return null;
                })->filter()->unique('user_id')->values();

                // Menangani period_formatted
                $periodFormatted = 'Belum tersedia';
                if ($volume->start_date && $volume->end_date) {
                    $periodFormatted = Carbon::parse($volume->start_date)->format('d M Y') . 
                                    ' - ' .
                                    Carbon::parse($volume->end_date)->format('d M Y');
                }

                // Mendapatkan nomor work order
                $woNumber = null;
                if ($volume->wo_id && $volume->workOrder) {
                    $woNumber = $volume->workOrder->wo_number;
                }

                return [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date,
                    'execution_year' => $volume->execution_year,
                    'period_formatted' => $periodFormatted,
                    'resources' => $resources,
                    'wo_id' => $volume->wo_id,
                    'wo_number' => $woNumber,
                    'has_work_order' => true
                ];
            });

            // Hitung remaining volumes
            $totalVolumeQty = $workPackage->volume_qty;
            $totalVolumesCreated = WorkPackageVolume::where('wp_id', $wp_id)->count();
            $volumesWithWorkOrderCount = $volumesData->count();
            $volumesWithoutWorkOrderCount = $totalVolumesCreated - $volumesWithWorkOrderCount;
            $remainingVolumeSlots = $totalVolumeQty - $volumesWithWorkOrderCount;

            // Transform human resources data untuk edit form
            $humanResourcesData = $this->calculateHumanResourcesFromWork($workPackage);

            Log::info('Work Package edit form loaded', [
                'wp_id' => $wp_id,
                'wp_number' => $workPackage->wp_number
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
            Log::error('Work Package not found for edit', ['wp_id' => $wp_id]);

            return redirect()->route('wp-management')
                ->with('error', 'Work Package tidak ditemukan.');

        } catch (Exception $e) {
            Log::error('Error loading work package edit form', [
                'wp_id' => $wp_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('wp-management')
                ->with('error', 'Terjadi kesalahan saat memuat form edit data work package.');
        }
    }

    /**
     * Calculate human resources based on actual work assignments
     */
    private function calculateHumanResourcesFromWork($workPackage)
    {
        // Collect all users from all volumes with their roles
        $humanResourcesData = $workPackage->humanResources->map(function ($hr) {
            $roleName = $hr->role->name ?? 'No Role';

            // Filter untuk mendapatkan role
            if ($roleName === 'karyawan') {
                $sampleUser = User::whereHas('roles', function($query) use ($hr) {
                    $query->where('id', $hr->role_id);
                })->with('roles')->first();

                if ($sampleUser) {
                    $userRoles = $sampleUser->getRoleNames();
                    $karyawanRoles = $userRoles->filter(function($roleName) {
                        return $roleName !== 'karyawan' && $roleName !== 'admin';
                    });

                    if ($karyawanRoles->isNotEmpty()) {
                        $roleName = $karyawanRoles->first();
                    }
                }
            }

            return [
                'hr_id' => $hr->hresource_id,
                'role_id' => $hr->role_id,
                'role_name' => $roleName,
                'jtk' => $hr->jtk,
                'jhk' => $hr->jhk,
            ];
        });

        return $humanResourcesData;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $wp_id)
    {
        try {
            DB::beginTransaction();

            Log::info('Updating work package', [
                'wp_id' => $wp_id, 
                'data' => $request->all(),
                'has_resources' => $request->has('resources'),
                'resources_data' => $request->input('resources', []),
                'has_work_order_assignments' => $request->has('work_order_assignments'),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);

            // Temukan data work package
            $workPackage = WorkPackage::findOrFail($wp_id);

            // Validasi request
            $validatedData = $request->validate([
                // Informasi umum work package
                'category_id' => 'required|exists:wp_category,category_id',
                'wp_sequence' => 'required|integer|min:1',
                'name' => 'required|string|max:255',
                'actual_scope_contract' => 'nullable|string',
                'deliverable' => 'nullable|string',
                'duration' => 'required|integer|min:1',

                // Volume data
                'volumes' => 'required|array|min:1',
                'volumes.*.volume_id' => 'required',
                'volumes.*.volume_number' => 'required|integer|min:1',

                // Deleted volumes
                'deleted_volumes' => 'nullable|array',
                'deleted_volumes.*' => 'exists:work_package_volume,volume_id',

                // Resource data
                'resources' => 'required|array|min:1',
                'resources.*.role_id' => 'required|exists:roles,id',
                'resources.*.jtk' => 'required|integer|min:1',
                'resources.*.jhk' => 'required|integer|min:1',

                // Work orderassignments validation
                'work_order_assignments' => 'nullable|string',
            ]);

            // CHECK DATA UPDATE CHANGES
            // Ambil original data untuk perbandingan
            $originalCategoryId = $workPackage->category_id;
            $originalWpNumber = $workPackage->wp_number;
            $originalName = trim($workPackage->name);
            $originalActualScope = trim($workPackage->actual_scope_contract ?? '');
            $originalDeliverable = trim($workPackage->deliverable ?? '');
            $originalDuration = (int)$workPackage->duration;

            // Mendapatkan data original volumes
            $originalVolumes = $workPackage->workPackageVolumes()
                ->orderBy('volume_number', 'asc')
                ->get()
                ->map(function($volume) {
                    return [
                        'volume_id' => $volume->volume_id,
                        'volume_number' => $volume->volume_number
                    ];
                })
                ->toArray();
            
            // Mendapatkan data original human resources
            $originalHumanResources = $workPackage->humanResources()
                ->orderBy('role_id', 'asc')
                ->get()
                ->map(function($hr) {
                    return [
                        'role_id' => $hr->role_id,
                        'jtk' => $hr->jtk,
                        'jhk' => $hr->jhk
                    ];
                })
                ->toArray();

            // Mendapatkan data original work order assignments
            $originalWorkOrderAssignments = $workPackage->workPackageVolumes()
                ->orderBy('volume_number', 'asc')
                ->get()
                ->map(function($volume) {
                    return [
                        'volume_id' => $volume->volume_id,
                        'wo_id' => $volume->wo_id
                    ];
                })
                ->toArray();

            $category = WpCategory::findOrFail($validatedData['category_id']);
            $newWpNumber = $category->category_number . '.' . $validatedData['wp_sequence'];

            $newCategoryId = (int)$validatedData['category_id'];
            $newName = trim($validatedData['name']);
            $newActualScope = trim($validatedData['actual_scope_contract'] ?? '');
            $newDeliverable = trim($validatedData['deliverable'] ?? '');
            $newDuration = (int)$validatedData['duration'];

            // Cek perubahan informasi umum
            $categoryChanged = $originalCategoryId != $newCategoryId;
            $wpNumberChanged = $originalWpNumber !== $newWpNumber;
            $nameChanged = $originalName !== $newName;
            $actualScopeChanged = $originalActualScope !== $newActualScope;
            $deliverableChanged = $originalDeliverable !== $newDeliverable;
            $durationChanged = $originalDuration !== $newDuration;

            // Cek perubahan volume
            $newVolumes = collect($validatedData['volumes'])
                ->filter(function($volume) {
                    return $volume['volume_id'] !== 'new';
                })
                ->map(function($volume) {
                    return [
                        'volume_id' => (int)$volume['volume_id'],
                        'volume_number' => (int)$volume['volume_number']
                    ];
                })
                ->sortBy('volume_number')
                ->values()
                ->toArray();
            
            $hasNewVolumes = collect($validatedData['volumes'])->contains(function($volume) {
                return $volume['volume_id'] === 'new';
            });

            $hasDeletedVolumes = !empty($validatedData['deleted_volumes']);

            $volumesChanged = $hasNewVolumes ||
                            $hasDeletedVolumes ||
                            count($originalVolumes) !== count($newVolumes) ||
                            $originalVolumes !== $newVolumes;

            // Cek perubahan human resources
            $newHumanResources = collect($validatedData['resources'])
                ->map(function($resource) {
                    return [
                        'role_id' => (int)$resource['role_id'],
                        'jtk' => (int)$resource['jtk'],
                        'jhk' => (int)$resource['jhk']
                    ];
                })
                ->sortBy('role_id')
                ->values()
                ->toArray();
            
            $humanResourcesChanged = $originalHumanResources !== $newHumanResources;

            // Cek perubahan work order assignments
            $workOrderAssignmentsChanged = false;
            $newWorkOrderAssignments = [];

            if ($request->has('work_order_assignments')) {
                $workOrderAssignments = json_decode($request->input('work_order_assignments'), true);

                if (!empty($workOrderAssignments)) {
                    foreach ($workOrderAssignments as $volumeId => $assignmentData) {
                        if ($assignmentData['type'] === 'new') {
                            $newWorkOrderAssignments[] = [
                                'volume_id' => (int)$volumeId,
                                'wo_id' => 'new_' . $assignmentData['wo_number']
                            ];
                        } else {
                            $newWorkOrderAssignments[] = [
                                'volume_id' => (int)$volumeId,
                                'wo_id' => (int)$assignmentData['wo_id']
                            ];
                        }
                    }

                    // Mengurutkan kedua array untuk perbandingan
                    $originalWorkOrderAssignmentsSorted = collect($originalWorkOrderAssignments)
                        ->sortBy('volume_id')
                        ->values()
                        ->toArray();
                    
                    $newWorkOrderAssignmentsSorted = collect($newWorkOrderAssignments)
                        ->sortBy('volume_id')
                        ->values()
                        ->toArray();
                    
                    // Membandingkan work order assignments
                    $workOrderAssignmentsChanged = $originalWorkOrderAssignmentsSorted !== $newWorkOrderAssignmentsSorted;
                }
            }

            // Perbandingan untuk menentukan adanya perubahan
            $hasChanges = $categoryChanged ||
                        $wpNumberChanged || 
                        $nameChanged || 
                        $actualScopeChanged || 
                        $deliverableChanged || 
                        $durationChanged || 
                        $volumesChanged || 
                        $humanResourcesChanged ||
                        $workOrderAssignmentsChanged;

            // Log Perbandingan Perubahan
            Log::info('Final change detection result', [
                'wp_id' => $wp_id,
                'has_changes' => $hasChanges,
                'detailed_changes' => [
                    'category_changed' => $categoryChanged,
                    'wp_number_changed' => $wpNumberChanged,
                    'name_changed' => $nameChanged,
                    'actual_scope_changed' => $actualScopeChanged,
                    'deliverable_changed' => $deliverableChanged,
                    'duration_changed' => $durationChanged,
                    'volumes_changed' => $volumesChanged,
                    'human_resources_changed' => $humanResourcesChanged,
                    'work_order_assignments_changed' => $workOrderAssignmentsChanged
                ],
                'comparisons' => [
                    'category' => ['old' => $originalCategoryId, 'new' => $newCategoryId],
                    'wp_number' => ['old' => $originalWpNumber, 'new' => $newWpNumber],
                    'name' => ['old' => $originalName, 'new' => $newName],
                    'duration' => ['old' => $originalDuration, 'new' => $newDuration],
                    'volumes' => ['old' => $originalVolumes, 'new' => $newVolumes],
                    'human_resources' => ['old' => $originalHumanResources, 'new' => $newHumanResources],
                    'work_order_assignments' => ['old' => $originalWorkOrderAssignments, 'new' => $newWorkOrderAssignments]
                ]
            ]);
            
            if (!$hasChanges) {
                DB::rollback();

                return response()->json([
                    'success' => false,
                    'no_changes' => true,
                    'message' => 'Tidak ada perubahan data yang terdeteksi.',
                    'current_data' => [
                        'wp_number' => $workPackage->wp_number,
                        'name' => $workPackage->name,
                        'category' => $workPackage->wpCategory->name ?? 'Unknown',
                        'duration' => $workPackage->duration . ' hari',
                        'volumes_count' => count($originalVolumes),
                        'resources_count' => count($originalHumanResources),
                        'work_order_assignments_count' => count($originalWorkOrderAssignments)
                    ]
                ], 200);
            }

            // UPDATE OPERATION
            // Step 0: Update WP Number if category or sequence changed
            $category = WpCategory::findOrFail($validatedData['category_id']);
            $newWpNumber = $category->category_number . '.' . $validatedData['wp_sequence'];

            // Cek jika nomor WP berubah dan nomor baru tersedia
            if ($newWpNumber !== $workPackage->wp_number) {
                if (WorkPackage::where('wp_number', $newWpNumber)->where('wp_id', '!=', $wp_id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Nomor Work Package {$newWpNumber} sudah digunakan. Silahkan pilih nomor lain."
                    ], 422);
                }

                Log::info('WP Number changed', [
                    'old_wp_number' => $workPackage->wp_number,
                    'new_wp_number' => $newWpNumber
                ]);
            }

            // Step 1: Update informasi umum work package
            $workPackage->update([
                'category_id' => $validatedData['category_id'],
                'wp_number' => $newWpNumber,
                'name' => $validatedData['name'],
                'duration' => $validatedData['duration'],
                'actual_scope_contract' => $validatedData['actual_scope_contract'],
                'deliverable' => $validatedData['deliverable'],
                'volume_qty' => count($validatedData['volumes'])
            ]);

            // Step 2: Update volume data
            if (!empty($validatedData['deleted_volumes'])) {
                foreach ($validatedData['deleted_volumes'] as $volumeId) {
                    $volume = WorkPackageVolume::find($volumeId);
                    if ($volume) {
                        // Double check associations before deletion
                        $hasAssociations = Task::where('volume_id', $volumeId)->exists() ||
                                        Work::where('volume_id', $volumeId)->exists() ||
                                        Timesheet::where('volume_id', $volumeId)->exists();

                        if (!$hasAssociations) {
                            $volume->delete();
                            Log::info('Volume deleted', ['volume_id' => $volumeId]);
                        } else {
                            Log::warning('Attempted to delete volume with associations', ['volume_id' => $volumeId]);
                        }
                    }
                }
            }

            // Create new volumes and update existing ones
            foreach ($validatedData['volumes'] as $volumeData) {
                if ($volumeData['volume_id'] === 'new') {
                    // Create new volume
                    WorkPackageVolume::create([
                        'wp_id' => $wp_id,
                        'volume_number' => $volumeData['volume_number'],
                        'start_date' => null,
                        'end_date' => null,
                        'execution_year' => null,
                    ]);
                    Log::info('New volume created', ['volume_number' => $volumeData['volume_number']]);

                } else {
                    // Update existing volume number if changed
                    $volume = WorkPackageVolume::find($volumeData['volume_id']);
                    
                    if ($volume && $volume->volume_number != $volumeData['volume_number']) {
                        $volume->update(['volume_number' => $volumeData['volume_number']]);
                        
                        Log::info('Volume number updated', [
                            'volume_id' => $volumeData['volume_id'],
                            'new_number' => $volumeData['volume_number']
                        ]);
                    }
                }
            }

            // Step 3: Update human resources
            // Get current role IDs from the request
            $newRoleIds = collect($validatedData['resources'])->pluck('role_id')->unique()->toArray();
        
            // Get existing role IDs from current Human Resources
            $existingRoleIds = HumanResource::where('wp_id', $wp_id)->pluck('role_id')->toArray();
            
            // Find roles that are being removed
            $removedRoleIds = array_diff($existingRoleIds, $newRoleIds);

            // Remove Work assignments for users with removed roles from all volumes
            if (!empty($removedRoleIds)) {
                $volumeIds = WorkPackageVolume::where('wp_id', $wp_id)->pluck('volume_id');

                // Get Users with removed roles
                $usersWithRemovedRoles = User::whereHas('roles', function($query) use ($removedRoleIds) {
                    $query->whereIn('id', $removedRoleIds);
                })->pluck('user_id')->toArray();

                if (!empty($usersWithRemovedRoles) && !empty($volumeIds)) {
                    // Delete Work assignments for these users in all volumes of this work package
                    $deletedWorkCount = Work::whereIn('volume_id', $volumeIds)
                        ->whereIn('user_id', $usersWithRemovedRoles)
                        ->delete();
                    
                    // Delete Timesheet records for these users in all volumes of this work package
                    $deletedTimesheetCount = Timesheet::whereIn('volume_id', $volumeIds)
                        ->whereIn('user_id', $usersWithRemovedRoles)
                        ->delete();
                }
            }

            // Delete existing human resources
            HumanResource::where('wp_id', $wp_id)->delete();

            // Create new human resources
            foreach ($validatedData['resources'] as $resourceData) {
                HumanResource::create([
                    'wp_id' => $wp_id,
                    'role_id' => $resourceData['role_id'],
                    'jtk' => $resourceData['jtk'],
                    'jhk' => $resourceData['jhk'],
                ]);
            }

            // Step 4: Update work order assignments
            // Handle work order assignments
            if ($workOrderAssignmentsChanged && $request->has('work_order_assignments')) {
                $workOrderAssignments = json_decode($request->input('work_order_assignments'), true);

                if (!empty($workOrderAssignments)) {
                    $this->processWorkOrderAssignments($workOrderAssignments, $wp_id);
                }
            }

            DB::commit();

            Log::info('Work Package updated successfully', [
                'wp_id' => $wp_id,
                'wp_number' => $workPackage->wp_number,
                'name' => $workPackage->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Work Package berhasil diperbarui',
                'redirect_url' => route('wp-management.detail', $wp_id),
                'updated_data' => [
                    'wp_number' => $workPackage->wp_number,
                    'name' => $workPackage->name,
                    'category' => $category->name,
                    'duration' => $workPackage->duration,
                    'volumes_count' => count($validatedData['volumes']),
                    'resources_count' => count($validatedData['resources']),
                    'work_order_assignments_changed' => $workOrderAssignmentsChanged
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
                'wp_id' => $wp_id,
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
     * Assign work order to new volume slot
     */
    public function assignVolumeWithWorkOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validate([
                'wp_id' => 'required|exists:work_package,wp_id',
                'wo_id' => 'nullable|exists:work_order,wo_id',
                'volume_number' => 'required|integer|min:1',

                // Untuk work order baru
                'create_new_wo' => 'nullable|in:true,false,1,0',
                'new_wo_number' => 'nullable|integer|min:1|max:999'
            ]);

            $workPackage = WorkPackage::findOrFail($validatedData['wp_id']);

            // Validasi volume number tidak melebihi quantity
            if ($validatedData['volume_number'] > $workPackage->volume_qty) {
                return response()->json([
                    'success' => false,
                    'message' => "Volume number tidak boleh melebihi quantity work package ({$workPackage->volume_qty})"
                ], 422);
            }

            // Cek apakah volume dengan nomor tersebut sudah memiliki work order
            $existingVolumeWithWO = WorkPackageVolume::where('wp_id', $validatedData['wp_id'])
                ->where('volume_number', $validatedData['volume_number'])
                ->whereNotNull('wo_id')
                ->first();
            
            if ($existingVolumeWithWO) {
                return response()->json([
                    'success' => false,
                    'message' => "Volume {$validatedData['volume_number']} sudah memiliki Work Order"
                ], 422);
            }

            $workOrder = null;

            // Konversi string boolean menjadi boolean yang sebenarnya
            $createNewWo = $request->input('create_new_wo');
            if ($createNewWo === 'true' || $createNewWo === true) {
                $createNewWo = true;
            } else {
                $createNewWo = false;
            }

            // Menangani pembuatan atau pemilihan work order
            if ($createNewWo) {
                $newWoNumber = (int) $validatedData['new_wo_number'];

                if (WorkOrder::where('wo_number', $newWoNumber)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => "Nomor Work Order {$newWoNumber} sudah digunakan"
                    ], 422);
                }

                // Create new work order
                $workOrder = WorkOrder::create([
                    'wo_number' => $newWoNumber,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            } else {
                if (!$validatedData['wo_id']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Work Order harus dipilih atau dibuat baru'
                    ], 422);
                }

                $workOrder = WorkOrder::findOrFail($validatedData['wo_id']);
            }

            // Cari atau buat volume dengan nomor tersebut
            $volume = WorkPackageVolume::where('wp_id', $validatedData['wp_id'])
                ->where('volume_number', $validatedData['volume_number'])
                ->first();
            
            if (!$volume) {
                // Jika volume belum ada, buat baru
                $volume = WorkPackageVolume::create([
                    'wp_id' => $validatedData['wp_id'],
                    'volume_number' => $validatedData['volume_number'],
                    'start_date' => null,
                    'end_date' => null,
                    'execution_year' => null,
                    'wo_id' => $workOrder->wo_id,
                ]);

                // Copy user assignments dari human resources ke volume baru
                $humanResources = HumanResource::where('wp_id', $validatedData['wp_id'])->get();

                foreach ($humanResources as $hr) {
                    // Get users dengan role ini
                    $usersWithRole = User::whereHas('roles', function($query) use ($hr) {
                        $query->where('id', $hr->role_id);
                    })->take($hr->jtk)->get();

                    foreach ($usersWithRole as $user) {
                        // Pastikan user memiliki role yang benar
                        $role = Role::find($hr->role_id);
                        if ($role) {
                            // Assign role jika belum ada
                            if (!$user->hasRole('karyawan')) {
                                $user->assignRole('karyawan');
                            }
                            
                            if (!$user->hasRole($role->name)) {
                                $user->assignRole($role->name);
                                
                                // Log::info('Role assigned during volume creation', [
                                //     'user_id' => $user->user_id,
                                //     'user_name' => $user->name,
                                //     'role_name' => $role->name,
                                //     'volume_id' => $volume->volume_id
                                // ]);
                            }
                        }

                        // Cek apakah user sudah di-assign ke volume ini
                        $existingWork = Work::where('volume_id', $volume->volume_id)
                            ->where('user_id', $user->user_id)
                            ->where('role_id', $hr->role_id)
                            ->first();
                        
                        if (!$existingWork) {
                            Work::create([
                                'volume_id' => $volume->volume_id,
                                'user_id' => $user->user_id,
                                'role_id' => $hr->role_id,
                            ]);
                        }
                    }
                }
            } else {
                // Update existing volume dengan work order
                $volume->update([
                    'wo_id' => $workOrder->wo_id
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Volume {$validatedData['volume_number']} berhasil di-assign dengan Work Order {$workOrder->wo_number}",
                'volume_data' => [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'wo_number' => $workOrder->wo_number,
                    'wo_id' => $workOrder->wo_id
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

            Log::error('Error assigning volume with work order', [
                'wp_id' => $request->input('wp_id'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan assignment: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove volume (delete work order assignment)
     */
    public function removeVolume(Request $request, $volume_id) 
    {
        try {
            DB::beginTransaction();

            $volume = WorkPackageVolume::findOrFail($volume_id);

            // Store original data for logging
            $originalWoId = $volume->wo_id;
            $originalWoNumber = null;

            if ($originalWoId) {
                $workOrder = WorkOrder::find($originalWoId);
                $originalWoNumber = $workOrder ? $workOrder->wo_number : null;
            }

            // Remove work order assignment
            $volume->update([
                'wo_id' => null
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Work Order berhasil dihapus dari Volume {$volume->volume_number}",
                'volume_data' => [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'wo_removed' => [
                        'wo_id' => $originalWoId,
                        'wo_number' => $originalWoNumber
                    ]
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Volume tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus volume: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check volume associations before deletion
     */
    // public function checkVolumeAssociations($volume_id) 
    // {
    //     try {
    //         $volume = WorkPackageVolume::findOrFail($volume_id);

    //         // Check for associated data
    //         $tasksCount = Task::where('volume_id', $volume_id)->count();
    //         $subtasksCount = SubTask::whereHas('task', function($query) use ($volume_id) {
    //             $query->where('volume_id', $volume_id);
    //         })->count();
    //         $resourcesCount = Work::where('volume_id', $volume_id)->count();
    //         $timesheetsCount = Timesheet::where('volume_id', $volume_id)->count();

    //         $hasAssociations = $tasksCount > 0 || $subtasksCount > 0 || $resourcesCount > 0 || $timesheetsCount > 0;

    //         return response()->json([
    //             'success' => true,
    //             'has_associations' => $hasAssociations,
    //             'associations' => [
    //                 'tasks_count' => $tasksCount,
    //                 'subtasks_count' => $subtasksCount,
    //                 'resources_count' => $resourcesCount,
    //                 'timesheets_count' => $timesheetsCount
    //             ] 
    //         ]);

    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Volume tidak ditemukan'
    //         ], 404);

    //     } catch (Exception $e) {
    //         Log::error('Error checking volume associations', [
    //             'volume_id' => $volume_id,
    //             'error' => $e->getMessage()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan saat memeriksa data volume'
    //         ], 500);
    //     }
    // }

    /**
     * Force delete volume with all associated data
     */
    // public function forceDeleteVolume(Request $request, $volume_id)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $volume = WorkPackageVolume::findOrFail($volume_id);
            
    //         // Count association before deletion for logging
    //         $tasksCount = Task::where('volume_id', $volume_id)->count();
    //         $subtasksCount = SubTask::whereHas('task', function($query) use ($volume_id) {
    //             $query->where('volume_id', $volume_id);
    //         })->count();
    //         $resourcesCount = Work::where('volume_id', $volume_id)->count();
    //         $timesheetsCount = Timesheet::where('volume_id', $volume_id)->count();

    //         // Delete all sub tasks for task in this volume
    //         if ($subtasksCount > 0) {
    //             $taskIds = Task::where('volume_id', $volume_id)->pluck('task_id');
    //             SubTask::whereIn('task_id', $taskIds)->delete();
    //         }

    //         // Delete all tasks in this volume
    //         if ($tasksCount > 0) {
    //             Task::where('volume_id', $volume_id)->delete();
    //         }

    //         // Delete all timesheets for this volume
    //         if ($timesheetsCount > 0) {
    //             Timesheet::where('volume_id', $volume_id)->delete();
    //         }

    //         // Delete all work assignment (resources) for this volume
    //         if ($resourcesCount > 0) {
    //             Work::where('volume_id', $volume_id)->delete();
    //         }

    //         // Delete the volume
    //         $volumeData = [
    //             'volume_id' => $volume->volume_id,
    //             'volume_number' => $volume->volume_number,
    //             'wp_id' => $volume->wp_id,
    //             'start_date' => $volume->start_date,
    //             'end_date' => $volume->end_date,
    //             'execution_year' => $volume->execution_year
    //         ];

    //         $volume->delete();

    //         DB::commit();

    //         Log::info('Volume force deleted successfully', [
    //             'deleted_volume' => $volumeData,
    //             'associated_data_deleted' => [
    //                 'tasks' => $tasksCount,
    //                 'subtasks' => $subtasksCount,
    //                 'work_assignments' => $resourcesCount,
    //                 'timesheets' => $timesheetsCount
    //             ],
    //             'deleted_by' => auth()->id() ?? 'system',
    //             'deleted_at' => now()->format('Y-m-d H:i:s')
    //         ]);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Volume dan semua data terkait berhasil dihapus',
    //             'deleted_data' => [
    //                 'volume' => $volumeData,
    //                 'tasks_deleted' => $tasksCount,
    //                 'subtasks_deleted' => $subtasksCount,
    //                 'resources_deleted' => $resourcesCount,
    //                 'timesheets_deleted' => $timesheetsCount,
    //             ]
    //         ]);

    //     } catch (ModelNotFoundException $e) {
    //         DB::rollback();

    //         Log::warning('Volume not found for force deletion', [
    //             'volume_id' => $volume_id
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Volume tidak ditemukan',
    //         ], 404);

    //     } catch (Exception $e) {
    //         DB::rollback();

    //         Log::error('Error force deleting volume', [
    //             'volume_id' => $volume_id,
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal menghapus volume: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    /**
     * Check if a role has user assignments in work packages volumes
     */
    public function checkRoleAssignments(Request $request)
    {
        try {
            $wpId = $request->input('wp_id');
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
            $volumeIds = WorkPackageVolume::where('wp_id', $wpId)->pluck('volume_id');

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
                            'volume_number' => $assignment->volume->volume_number ?? 'Unknown'
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
                'wp_id' => $request->input('wp_id'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Work Package tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error checking role assignments', [
                'wp_id' => $request->input('wp_id'),
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
    public function checkWorkPackageAssociations($wp_id) 
    {
        try {
            $workPackage = WorkPackage::findOrFail($wp_id);

            // Mendapatkan semua volumes untuk work package ini
            $volumes = WorkPackageVolume::where('wp_id', $wp_id)->get();
            $volumeIds = $volumes->pluck('volume_id');

            // Cek data asosiasi di seluruh volume
            $volumesCount = $volumes->count();
            $tasksCount = Task::whereIn('volume_id', $volumeIds)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volumeIds) {
                $query->whereIn('volume_id', $volumeIds);
            })->count();
            $workAssignmentsCount = Work::whereIn('volume_id', $volumeIds)->count();
            $timesheetsCount = Timesheet::whereIn('volume_id', $volumeIds)->count();
            $humanResourcesCount = HumanResource::where('wp_id', $wp_id)->count();

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
                'wp_id' => $wp_id,
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
    public function forceDeleteWorkPackage(Request $request, $wp_id)
    {
        try {
            DB::beginTransaction();

            $workPackage = WorkPackage::with(['wpCategory'])->findOrFail($wp_id);

            Log::info('Force deleting work package with associations', [
                'wp_id' => $wp_id,
                'wp_number' => $workPackage->wp_number,
                'wp_name' => $workPackage->name,
                'force' => $request->input('force', false)
            ]);

            // Mendapatkan seluruh volume dari work package ini
            $volumes = WorkPackageVolume::where('wp_id', $wp_id)->get();
            $volumeIds = $volumes->pluck('volume_id');

            // Hitung asosiasi sebelum melakukan penghapusan
            $volumesCount = $volumes->count();
            $tasksCount = Task::whereIn('volume_id', $volumeIds)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volumeIds) {
                $query->whereIn('volume_id', $volumeIds);
            })->count();
            $workAssignmentsCount = Work::whereIn('volume_id', $volumeIds)->count();
            $timesheetsCount = Timesheet::whereIn('volume_id', $volumeIds)->count();
            $humanResourcesCount = HumanResource::where('wp_id', $wp_id)->count();

            // Hapus semua sub tasks dari suatu task pada semua volume
            if ($subtasksCount > 0) {
                $taskIds = Task::whereIn('volume_id', $volumeIds)->pluck('task_id');
                SubTask::whereIn('task_id', $taskIds)->delete();

                Log::info('Deleted sub tasks', [
                    'wp_id' => $wp_id,
                    'subtasks_deleted' => $subtasksCount
                ]);
            }

            // Hapus semua task pada semua volume
            if ($tasksCount > 0) {
                Task::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted tasks', [
                    'wp_id' => $wp_id,
                    'tasks_deleted' => $tasksCount
                ]);
            }

            // Hapus semua timesheet pada semua volume
            if ($timesheetsCount > 0) {
                Timesheet::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted timesheets', [
                    'wp_id' => $wp_id,
                    'timesheets_deleted' => $timesheetsCount
                ]);
            }

            // Hapus semua work assignment (resources) pada semua volume
            if ($workAssignmentsCount > 0) {
                Work::whereIn('volume_id', $volumeIds)->delete();

                Log::info('Deleted work assignments', [
                    'wp_id' => $wp_id,
                    'work_assignments_deleted' => $workAssignmentsCount
                ]);
            }

            // Hapus semua human resources untuk work package ini
            if ($humanResourcesCount > 0) {
                HumanResource::where('wp_id', $wp_id)->delete();

                Log::info('Deleted human resources', [
                    'wp_id' => $wp_id,
                    'human_resources_deleted' => $humanResourcesCount
                ]);
            }

            // Hapus semua volume untuk work package ini
            if ($volumesCount > 0) {
                WorkPackageVolume::where('wp_id', $wp_id)->delete();

                Log::info('Deleted volumes', [
                    'wp_id' => $wp_id,
                    'volumes_deleted' => $volumesCount
                ]);
            }

            // Hapus work package itu sendiri
            $workPackageData = [
                'wp_id' => $workPackage->wp_id,
                'wp_number' => $workPackage->wp_number,
                'name' => $workPackage->name,
                'category_id' => $workPackage->category_id,
                'category_name' => $workPackage->wpCategory->name ?? 'Unknown',
                'duration' => $workPackage->duration,
                'volume_qty' => $workPackage->volume_qty,
                'actual_scope_contract' => $workPackage->actual_scope_contract,
                'deliverable' => $workPackage->deliverable
            ];

            $workPackage->delete();

            DB::commit();

            Log::info('Work Package force deleted successfully', [
                'deleted_work_package' => $workPackageData,
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
                    'work_package' => $workPackageData,
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
                'wp_id' => $wp_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Work Package tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error force deleting work package', [
                'wp_id' => $wp_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus Work Package: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process work order assignments
     */
    private function processWorkOrderAssignments($assignments, $wp_id)
    {
        try {
            foreach ($assignments as $volumeId => $assignmentData) {
                $workOrder = null;
    
                if ($assignmentData['type'] === 'new') {
                    $woNumber = (int) $assignmentData['wo_number'];
                    
                    // double check if WO number exists before creating
                    $existingWo = WorkOrder::where('wo_number', $woNumber)->first();
                    if ($existingWo) {
                        $workOrder = $existingWo;
                    } else {
                        try {
                            // Create new work order
                            $workOrder = WorkOrder::create([
                                'wo_number' => $woNumber
                            ]);

                        } catch (QueryException $e) {
                            if ($e->getCode() === '23505' || strpos($e->getMessage(), 'duplicate key') !== false) {
                                // Fetch the existing work order that was created by another process
                                $workOrder = WorkOrder::where('wo_number', $woNumber)->first();
                            } else {
                                throw $e;
                            }
                        }
                    }

                } else {
                    // Use existing work order
                    $workOrder = WorkOrder::find($assignmentData['wo_id']);
                }
    
                if ($workOrder) {
                    // Update volume with work order
                    $volume = WorkPackageVolume::where('volume_id', $volumeId)
                        ->where('wp_id', $wp_id)
                        ->first();

                    $updated = $volume->update(['wo_id' => $workOrder->wo_id]);

                    Log::info('Work order assigned to volume', [
                        'wo_id' => $workOrder->wo_id,
                        'wo_number' => $workOrder->wo_number,
                        'volume_id' => $volumeId,
                        'wp_id' => $wp_id,
                        'updated' => $updated
                    ]);
                }
            }

        } catch (QueryException $e) {
            Log::error('Database error in work order assignments', [
                'wp_id' => $wp_id,
                'assignments' => $assignments,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;

        } catch (Exception $e) {
            Log::error('General error processing work order assignments', [
                'wp_id' => $wp_id,
                'assignments' => $assignments,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Get available work orders for assignment
     */
    public function getAvailableWorkOrders(Request $request)
    {
        try {
            // Get all available work orders
            $workOrders = WorkOrder::orderBy('wo_number', 'asc')
                ->get()
                ->map(function ($wo) {
                    $usageCount = WorkPackageVolume::where('wo_id', $wo->wo_id)->count();

                    return [
                        'wo_id' => $wo->wo_id,
                        'wo_number' => $wo->wo_number,
                        'usage_count' => $usageCount,
                        'is_available' => true
                    ];
                });
            
            return response()->json([
                'success' => true,
                'work_orders' => $workOrders
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching available work orders', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data Work Order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get next available WO number
     */
    public function getNextWoNumber(Request $request)
    {
        try {
            $lastWo = WorkOrder::orderBy('wo_number', 'desc')->first();

            $nextNumber = 1;
            if ($lastWo) {
                $nextNumber = $lastWo->wo_number + 1;
            }

            return response()->json([
                'success' => true,
                'next_wo_number' => $nextNumber
            ]);

        } catch (Exception $e) {
            Log::error('Error fetching next WO number', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil nomor WO berikutnya: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check if work order number is available
     */
    public function checkWoNumberAvailability(Request $request)
    {
        try {
            $woNumber = $request->get('wo_number');

            if (!$woNumber) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor WO diperlukan'
                ], 400);
            }

            $woNumber = (int) $woNumber;
            $isAvailable = !WorkOrder::where('wo_number', $woNumber)->exists();

            return response()->json([
                'success' => true,
                'available' => $isAvailable,
                'wo_number' => $woNumber,
                'message' => $isAvailable ? 'Nomor WO tersedia' : 'Nomor WO sudah digunakan'
            ]);

        } catch (Exception $e) {
            Log::error('Error checking WO number availability', [
                'wo_number' => $request->get('wo_number'),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memeriksa ketersediaan nomor WO'
            ], 500);
        }
    }

    /**
     * Assign work order to selected volumes
     */
    // public function assignWorkOrder(Request $request)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $validatedData = $request->validate([
    //             'wp_id' => 'required|exists:work_package,wp_id',
    //             'wo_id' => 'nullable|exists:work_order,wo_id',
    //             'volume_ids' => 'required|array|min:1',
    //             'volume_ids.*' => 'exists:work_package_volume,volume_id',

    //             // For new work order
    //             'create_new_wo' => 'nullable|boolean',
    //             'new_wo_number' => 'nullable|integer|min:1|max:999'
    //         ]);

    //         $wpId = $validatedData['wp_id'];
    //         $volumeIds = $validatedData['volume_ids'];
    //         $workOrder = null;

    //         // Handle work order creation or selection
    //         if ($request->input('create_new_wo', false)) {
    //             $newWoNumber = (int) $validatedData['new_wo_number'];

    //             $isWoNumberExists = WorkOrder::where('wo_number', $newWoNumber)->exists();
    //             if ($isWoNumberExists) {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => "Nomor WO {$newWoNumber} sudah digunakan"
    //                 ], 422);
    //             }

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Assignment berhasil disimpan sementara. Akan disimpan permanen saat menyimpan Work Package.',
    //                 'assignment_details' => [
    //                     'work_order' => [
    //                         'wo_number' => $newWoNumber,
    //                         'type' => 'new'
    //                     ],
    //                     'affected_volumes' => $volumeIds
    //                 ]
    //             ]);

    //         } else {
    //             // Use existing work order
    //             if (!$validatedData['wo_id']) {
    //                 return response()->json([
    //                     'success' => false,
    //                     'message' => 'Work Order harus dipilih'
    //                 ], 422);
    //             }

    //             $workOrder = WorkOrder::findOrFail($validatedData['wo_id']);
    //         }

    //         // Return temporary assignment info
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Assignment disimpan sementara. Akan disimpan permanen saat menyimpan Work Package.',
    //             'assignment_details' => [
    //                 'work_order' => [
    //                     'wo_id' => $workOrder->wo_id,
    //                     'wo_number' => $workOrder->wo_number,
    //                     'type' => 'existing'
    //                 ],
    //                 'affected_volumes' => $volumeIds
    //             ]
    //         ]);

    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validasi gagal',
    //             'errors' => $e->errors()
    //         ], 422);

    //     } catch (ModelNotFoundException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Work Order atau Volume tidak ditemukan'
    //         ], 404);

    //     } catch (Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal melakukan assignment work order: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
}
