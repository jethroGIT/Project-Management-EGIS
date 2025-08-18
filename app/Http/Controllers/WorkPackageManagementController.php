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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Display the detailed view of a specific work package
     */
    public function detail($wp_id) 
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volume_number', 'asc');
                },
                'workPackageVolumes.work.user.role',
                'humanResources.role'
            ])->findOrFail($wp_id);

            // Transform volume data untuk tampilan
            $volumesData = $workPackage->workPackageVolumes->map(function ($volume) use($workPackage) {
                // Ambil resource names untuk volume ini
                $resourceNames = $volume->work->map(function ($work) {
                    if ($work->user && $work->user->role) {
                        return $work->user->name . ' (' . $work->user->role->name . ')';
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

                return [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date,
                    'execution_year' => $volume->execution_year,
                    'period_formatted' => $periodFormatted,
                    'duration_days' => $workPackage->duration,
                    'resource_names' => $resourceNames->implode(', ') ?: 'Belum ada resource',
                    'resource_count' => $resourceNames->count()
                ];
            });

            // Transform human resources data
            $humanResourcesData = $workPackage->humanResources->map(function ($hr) {
                return [
                    'role_name' => $hr->role->name ?? 'Unknown Role',
                    'jtk' => $hr->jtk,
                    'jhk' => $hr->jhk
                ];
            });

            Log::info('Work Package detail loaded successfully', [
                'wp_id' => $wp_id,
                'wp_number' => $workPackage->wp_number,
                'volumes_count' => $volumesData->count()
            ]);

            return view('workpackage_management_detail', compact('workPackage', 'volumesData', 'humanResourcesData'));

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
                    'start_date' => null,
                    'end_date' => null,
                    'execution_year' => null,
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
                        // $maxOrderIndex = Task::where('volume_id', $volume->volume_id)
                        //     ->max('order_index') ?? 0;

                        $task = Task::create([
                            'volume_id' => $volume->volume_id,
                            'name' => $taskData['name'],
                            'status' => 'open',
                            // 'order_index' => $maxOrderIndex + 1
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
    public function edit($wp_id)
    {
        try {
            // Ambil work package dengan semua relasi yang dibutuhkan
            $workPackage = WorkPackage::with([
                'wpCategory',
                'workPackageVolumes' => function($query) {
                    $query->orderBy('volume_number', 'asc');
                },
                'workPackageVolumes.work.user.role',
                'humanResources.role'
            ])->findOrfail($wp_id);

            // Ambil semua kategori untuk dropdown
            $categories = WpCategory::orderBy('name', 'asc')->get();

            // Ambil semua users dengan roles untuk resource management
            $users = User::with('role')->orderBy('name', 'asc')->get();
            $roles = Role::orderBy('name', 'asc')->get();

            // Transform volume data untuk edit form
            $volumesData = $workPackage->workPackageVolumes->map(function ($volume) {
                // Ambil resource data untuk volume ini
                $resources = $volume->work->map(function ($work) {
                    if ($work->user && $work->user->role) {
                        return [
                            'work_id' => $work->work_id,
                            'user_id' => $work->user->user_id,
                            'user_name' => $work->user->name,
                            'role_name' => $work->user->role->name,
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

                return [
                    'volume_id' => $volume->volume_id,
                    'volume_number' => $volume->volume_number,
                    'start_date' => $volume->start_date,
                    'end_date' => $volume->end_date,
                    'execution_year' => $volume->execution_year,
                    'period_formatted' => $periodFormatted,
                    'resources' => $resources
                ];
            });

            // Transform human resources data untuk edit form
            $humanResourcesData = $workPackage->humanResources->map(function ($hr) {
                return [
                    'hr_id' => $hr->hresource_id,
                    'role_id' => $hr->role_id,
                    'role_name' => $hr->role->name ?? 'Unknown Role',
                    'jtk' => $hr->jtk,
                    'jhk' => $hr->jhk
                ];
            });

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
                'roles'
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $wp_id)
    {
        try {
            DB::beginTransaction();

            Log::info('Updating work package', [
                'wp_id' => $wp_id, 
                'data' => $request->all()
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
                'resources.*.role_id' => 'required|exists:role,role_id',
                'resources.*.jtk' => 'required|integer|min:1',
                'resources.*.jhk' => 'required|integer|min:1',
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

            // Perbandingan untuk menentukan adanya perubahan
            $hasChanges = $categoryChanged ||
                        $wpNumberChanged || 
                        $nameChanged || 
                        $actualScopeChanged || 
                        $deliverableChanged || 
                        $durationChanged || 
                        $volumesChanged || 
                        $humanResourcesChanged;

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
                    'human_resources_changed' => $humanResourcesChanged
                ],
                'comparisons' => [
                    'category' => ['old' => $originalCategoryId, 'new' => $newCategoryId],
                    'wp_number' => ['old' => $originalWpNumber, 'new' => $newWpNumber],
                    'name' => ['old' => $originalName, 'new' => $newName],
                    'duration' => ['old' => $originalDuration, 'new' => $newDuration],
                    'volumes' => ['old' => $originalVolumes, 'new' => $newVolumes],
                    'human_resources' => ['old' => $originalHumanResources, 'new' => $newHumanResources]
                ]
            ]);
            
            if (!$hasChanges) {
                DB::rollback();

                Log::info('No changes detected in work package update', [
                    'wp_id' => $wp_id,
                    'wp_number' => $workPackage->wp_number,
                    'validation_details' => [
                        'category_changed' => $categoryChanged,
                        'wp_number_changed' => $wpNumberChanged,
                        'name_changed' => $nameChanged,
                        'actual_scope_changed' => $actualScopeChanged,
                        'deliverable_changed' => $deliverableChanged,
                        'duration_changed' => $durationChanged,
                        'volumes_changed' => $volumesChanged,
                        'human_resources_changed' => $humanResourcesChanged
                    ]
                ]);

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
                        'resources_count' => count($originalHumanResources)
                    ]
                ], 200);
            }

            // Log detected changes
            Log::info('Changes detected, proceeding with update', [
                'wp_id' => $wp_id,
                'changes' => [
                    'category_changed' => $categoryChanged,
                    'wp_number_changed' => $wpNumberChanged,
                    'name_changed' => $nameChanged,
                    'actual_scope_changed' => $actualScopeChanged,
                    'deliverable_changed' => $deliverableChanged,
                    'duration_changed' => $durationChanged,
                    'volumes_changed' => $volumesChanged,
                    'human_resources_changed' => $humanResourcesChanged
                ]
            ]);

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

            // Create new volumes and update exisitng ones
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
            // Delete existing human resources
            HumanResource::where('wp_id', $wp_id)->delete();

            // Buat human resources baru
            foreach ($validatedData['resources'] as $resourceData) {
                HumanResource::create([
                    'wp_id' => $wp_id,
                    'role_id' => $resourceData['role_id'],
                    'jtk' => $resourceData['jtk'],
                    'jhk' => $resourceData['jhk'],
                ]);
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
                    'resources_count' => count($validatedData['resources'])
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
     * Check volume associations before deletion
     */
    public function checkVolumeAssociations($volume_id) 
    {
        try {
            $volume = WorkPackageVolume::findOrFail($volume_id);

            // Check for associated data
            $tasksCount = Task::where('volume_id', $volume_id)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volume_id) {
                $query->where('volume_id', $volume_id);
            })->count();
            $resourcesCount = Work::where('volume_id', $volume_id)->count();
            $timesheetsCount = Timesheet::where('volume_id', $volume_id)->count();

            $hasAssociations = $tasksCount > 0 || $subtasksCount > 0 || $resourcesCount > 0 || $timesheetsCount > 0;

            return response()->json([
                'success' => true,
                'has_associations' => $hasAssociations,
                'associations' => [
                    'tasks_count' => $tasksCount,
                    'subtasks_count' => $subtasksCount,
                    'resources_count' => $resourcesCount,
                    'timesheets_count' => $timesheetsCount
                ] 
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Volume tidak ditemukan'
            ], 404);

        } catch (Exception $e) {
            Log::error('Error checking volume associations', [
                'volume_id' => $volume_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memeriksa data volume'
            ], 500);
        }
    }

    /**
     * Force delete volume with all associated data
     */
    public function forceDeleteVolume(Request $request, $volume_id)
    {
        try {
            DB::beginTransaction();

            $volume = WorkPackageVolume::findOrFail($volume_id);
            
            // Count association before deletion for logging
            $tasksCount = Task::where('volume_id', $volume_id)->count();
            $subtasksCount = SubTask::whereHas('task', function($query) use ($volume_id) {
                $query->where('volume_id', $volume_id);
            })->count();
            $resourcesCount = Work::where('volume_id', $volume_id)->count();
            $timesheetsCount = Timesheet::where('volume_id', $volume_id)->count();

            // Delete all sub tasks for task in this volume
            if ($subtasksCount > 0) {
                $taskIds = Task::where('volume_id', $volume_id)->pluck('task_id');
                SubTask::whereIn('task_id', $taskIds)->delete();
            }

            // Delete all tasks in this volume
            if ($tasksCount > 0) {
                Task::where('volume_id', $volume_id)->delete();
            }

            // Delete all timesheets for this volume
            if ($timesheetsCount > 0) {
                Timesheet::where('volume_id', $volume_id)->delete();
            }

            // Delete all work assignment (resources) for this volume
            if ($resourcesCount > 0) {
                Work::where('volume_id', $volume_id)->delete();
            }

            // Delete the volume
            $volumeData = [
                'volume_id' => $volume->volume_id,
                'volume_number' => $volume->volume_number,
                'wp_id' => $volume->wp_id,
                'start_date' => $volume->start_date,
                'end_date' => $volume->end_date,
                'execution_year' => $volume->execution_year
            ];

            $volume->delete();

            DB::commit();

            Log::info('Volume force deleted successfully', [
                'deleted_volume' => $volumeData,
                'associated_data_deleted' => [
                    'tasks' => $tasksCount,
                    'subtasks' => $subtasksCount,
                    'work_assignments' => $resourcesCount,
                    'timesheets' => $timesheetsCount
                ],
                'deleted_by' => auth()->id() ?? 'system',
                'deleted_at' => now()->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Volume dan semua data terkait berhasil dihapus',
                'deleted_data' => [
                    'volume' => $volumeData,
                    'tasks_deleted' => $tasksCount,
                    'subtasks_deleted' => $subtasksCount,
                    'resources_deleted' => $resourcesCount,
                    'timesheets_deleted' => $timesheetsCount,
                ]
            ]);

        } catch (ModelNotFoundException $e) {
            DB::rollback();

            Log::warning('Volume not found for force deletion', [
                'volume_id' => $volume_id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Volume tidak ditemukan',
            ], 404);

        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error force deleting volume', [
                'volume_id' => $volume_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus volume: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
