<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\WpCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TimesheetManagementController extends Controller
{
    public function index()
    {
        // Ambil semua timesheet
        $timesheets = Timesheet::with(['user.roles', 'volume.workPackage'])
            ->orderByRaw('volume_id ASC, execution_date ASC')
            ->get();

        // users
        $users = $timesheets->pluck('user')
            ->filter() // pastikan user tidak null
            ->unique('user_id')
            ->sortBy('user_id')
            ->values();
        
        $usersCount = $users->count();

        // Pemendekan nama untuk $users
        $usedShortNames = [];
        $users = $users->map(function($user) use (&$usedShortNames) {
            $parts = explode(' ', trim($user->name));
            $short = $parts[0];
            if (in_array(strtolower($short), $usedShortNames) && count($parts) > 1) {
                $short .= ' ' . strtoupper(substr($parts[1], 0, 1));
            }
            $usedShortNames[] = strtolower($short);

            // Kembalikan user dengan nama pendek
            $user->short_name = $short;
            return $user;
        })->values();

        // Group aktivitas berdasarkan WP, WO, dan tanggal
        $groupedActivities = $timesheets->groupBy(function ($timesheet) {
            // Gabungkan berdasarkan wp_id, wo_id, dan execution_date
            $wpId = optional($timesheet->volume->workPackage)->wp_id;
            $woId = optional($timesheet->volume)->wo_id;
            $executionDate = $timesheet->execution_date;

            return $wpId . '_' . $woId . '_' . $executionDate;
        })->map(function ($group) {
            // Gabungkan aktivitas untuk volume yang sama
            $firstItem = $group->first();
            $volumes = $group->pluck('volume.volume_number')->unique()->sort()->values()->toArray();
            $volumeCount = count($volumes); // Hitung jumlah volume
            $users = $group->pluck('user')->unique('user_id')->values();

            return [
                'wp_number' => optional($firstItem->volume->workPackage)->wp_number,
                'wp_name' => optional($firstItem->volume->workPackage)->name,
                'execution_date' => $firstItem->execution_date, // Ambil langsung dari item pertama
                'volumes' => implode(', ', $volumes), // Gabungkan volume_number
                'timesheets' => [
                    'timesheet_ids' => $group->pluck('timesheet_id')->toArray(),
                    'volume_ids' => $group->pluck('volume_id')->unique()->toArray(),
                ],
                'users' => $users->map(function ($user) use ($group, $volumeCount) {
                    // Gabungkan aktivitas dan durasi untuk setiap pengguna
                    $userActivities = $group->where('user_id', $user->user_id)->reduce(function ($carry, $entry) {
                        $carry['duration'] += $entry->duration;
                        $carry['activities'][] = $entry->activity;
                        return $carry;
                    }, ['duration' => 0, 'activities' => []]);

                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'short_name' => $user->short_name ?? $user->name,
                        // Bagi total durasi dengan jumlah volume
                        'duration' => round($userActivities['duration'] / $volumeCount, 2),
                        'activities' => array_unique($userActivities['activities']), // Hilangkan duplikasi aktivitas
                    ];
                })->toArray(),
                'wpGroupKey' => trim(preg_replace('/\s+/', ' ', optional($firstItem->volume->workPackage)->wp_number . ' - ' . optional($firstItem->volume->workPackage)->name)),
            ];
        })->sortBy('wp_number')->values();

        // Ambil semua WO dan WP
        $workOrders = WorkPackageVolume::whereNotNull('wo_id')
            ->with(['workPackage'])
            ->get()
            ->groupBy('wo_id')
            ->map(function ($volumes, $woId) {
                return [
                    'wo_id' => $woId,
                    'wo_number' => optional($volumes->first()->workOrder)->wo_number,
                    'year' => optional($volumes->first())->execution_year,
                    'work_packages' => $volumes->pluck('workPackage')->unique('wp_id')->values(),
                ];
            })
            ->sortBy('wo_number')->values();

        // Ambil WP berdasarkan WO
        $wpByWo = WorkPackageVolume::whereNotNull('wo_id')
            ->with(['workPackage'])
            ->get()
            ->groupBy('wo_id')
            ->map(function ($volumes) {
                // Hitung jumlah volume dan periode pengerjaan
                $startDates = $volumes->pluck('start_date')->filter()->sort()->values();
                $endDates = $volumes->pluck('end_date')->filter()->sort()->values();

                $period = 'N/A';
                if ($startDates->isNotEmpty() && $endDates->isNotEmpty()) {
                    $startDate = \Carbon\Carbon::parse($startDates->first())->translatedFormat('d M Y');
                    $endDate = \Carbon\Carbon::parse($endDates->last())->translatedFormat('d M Y');
                    $period = "$startDate - $endDate";
                }

                // Gabungkan data WP berdasarkan wp_id
                $workPackages = $volumes->groupBy('wp_id')->map(function ($wpVolumes) {
                    $firstVolume = $wpVolumes->first();
                    return [
                        'wp_id' => $firstVolume->workPackage->wp_id,
                        'wp_number' => $firstVolume->workPackage->wp_number,
                        'name' => $firstVolume->workPackage->name,
                        'volume_count' => $wpVolumes->count(), // Hitung jumlah volume dalam WP
                    ];
                })->sortBy('wp_number')->values(); // Pastikan hasilnya adalah array

                return [
                    'period' => $period, // Periode pengerjaan
                    'work_packages' => $workPackages, // Daftar WP dalam WO
                ];
            })->toArray(); // Konversi hasil akhir menjadi array

        $workPackagesFilter = WorkPackage::whereIn('wp_id', function($query) {
            $query->select('wp_id')
                ->from('work_package_volume')
                ->whereIn('volume_id', function($subQuery) {
                    $subQuery->select('volume_id')
                        ->from('timesheet');
                });
        })
        ->orderByRaw('CAST(SPLIT_PART(wp_number, \'.\', 1) AS INTEGER) ASC, CAST(SPLIT_PART(wp_number, \'.\', 2) AS INTEGER) ASC')
        ->get();

        // $personnelByWp = Work::with(['user.roles'])
        //     ->get()
        //     ->groupBy('wp_id')
        //     ->map(function ($works) {
        //         return $works->map(function ($work) {
        //             return [
        //                 'role_id' => optional($work->role)->role_id,
        //                 'user_id' => $work->user->user_id,
        //                 'name' => $work->user->name,
        //                 'role_name' => optional($work->role)->name,
        //             ];
        //         });
        //     })->sortBy('role_id')->toArray();

        return view('timesheet_management', compact('groupedActivities', 'workOrders', 'wpByWo', 'usersCount',
                                                    'workPackagesFilter', 'users'));
    }

    public function add(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'wo_id' => 'required|exists:work_package_volume,wo_id',
                'execution_date' => 'required|date',
                'activities' => 'required|array',
                'personel_ids' => 'required|array',
                'durations' => 'required|array',
                'wp_id' => [
                    'nullable', // wp_id bersifat opsional
                    function ($attribute, $value, $fail) use ($request) {
                        // Validasi wp_id hanya jika diperlukan
                        $woId = $request->input('wo_id');
                        $workPackages = WorkPackageVolume::where('wo_id', $woId)
                            ->pluck('wp_id')
                            ->unique()
                            ->toArray();

                        if (count($workPackages) > 1 && !$value) {
                            $fail('Kategori Work Package wajib dipilih untuk Work Order ini.');
                        }
                    },
                ],
            ]);

            $woId = $request->input('wo_id');
            $wpId = $request->input('wp_id'); // Optional jika WP tidak dipilih
            $executionDate = $request->input('execution_date');
            $personelIds = $request->input('personel_ids');
            $durations = $request->input('durations');
            $activities = $request->input('activities');

            // Ambil semua volume_id berdasarkan work order dan work package
            $volumeQuery = WorkPackageVolume::where('wo_id', $woId);
            if ($wpId) {
                $volumeQuery->where('wp_id', $wpId);
            }
            $volumes = $volumeQuery->get();

            if ($volumes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada volume yang ditemukan untuk Work Order dan Work Package yang dipilih.',
                ], 404);
            }

            $volumeIds = $volumes->pluck('volume_id')->toArray();

            // Cek apakah sudah ada aktivitas di volume & tanggal yang sama untuk user ini
            $exists = Timesheet::whereIn('user_id', $personelIds)
                ->whereIn('volume_id', $volumeIds)
                ->whereDate('execution_date', $executionDate)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengisi aktivitas untuk WP volume dan tanggal ini.',
                ], 422);
            }

            // Simpan data ke tabel timesheet untuk setiap volume
            $timesheets = [];
            foreach ($volumeIds as $volumeId) {
                foreach ($personelIds as $index => $userId) {
                    if (!isset($activities[$index])) {
                        continue; // Skip jika aktivitas tidak ada
                    }

                    $timesheet = Timesheet::create([
                        'user_id' => $userId,
                        'volume_id' => $volumeId,
                        'execution_date' => $executionDate,
                        'duration' => $durations[$index],
                        'activity' => $activities[$index],
                    ]);

                    $timesheets[] = $timesheet;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $timesheets,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // to get data for edit modal
    public function editData(Request $request)
    {
        try {
            $volumeIds = json_decode($request->query('volume_ids', '[]'), true);
            $executionDate = $request->query('execution_date');

            Log::info('editData called with:', [
                'volume_ids' => $volumeIds,
                'execution_date' => $executionDate,
            ]);

            if (empty($volumeIds) || !$executionDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter volume_ids atau execution_date tidak valid.'
                ], 400);
            }

            // Ambil semua aktivitas berdasarkan volume_id dan execution_date
            $activities = Timesheet::whereIn('volume_id', $volumeIds)
                ->where('execution_date', $executionDate)
                ->with('user.roles', 'volume.workPackage')
                ->orderBy('user_id')
                ->get();

            if ($activities->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada aktivitas ditemukan untuk volume ini pada tanggal tersebut.'
                ], 404);
            }

            // Gabungkan aktivitas berdasarkan user_id, execution_date, dan activity
            $groupedActivities = $activities->groupBy(function ($activity) {
                return $activity->user_id . '-' . $activity->execution_date . '-' . $activity->activity;
            })->map(function ($group) {
                $firstActivity = $group->first();

                return [
                    'user_id' => $firstActivity->user_id,
                    'user' => $firstActivity->user,
                    'execution_date' => $firstActivity->execution_date,
                    'activity' => $firstActivity->activity,
                    'duration' => $group->avg('duration'), // Total durasi dari semua volume
                    'volume_ids' => $group->pluck('volume.volume_id')->unique()->values()->toArray(), // Gabungkan volume_ids
                    'timesheet_ids' => $group->pluck('timesheet_id')->values()->toArray(), // Gabungkan timesheet_ids
                    'work_package' => $firstActivity->volume->workPackage, // Ambil work package dari aktivitas pertama
                    'wo_id' => $firstActivity->volume->wo_id, // Ambil work order ID dari aktivitas pertama
                ];
            })->values();

            // Log hasil penggabungan
            Log::info('editData: Grouped activities result:', [
                'grouped_activities_count' => $groupedActivities->count(),
                'grouped_activities' => $groupedActivities->toArray(),
            ]);

            return response()->json([
                'success' => true,
                'data' => $groupedActivities
            ]);
        } catch (\Exception $e) {
            // Log error
            Log::error('editData: Terjadi kesalahan.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        try {
            $volumeIds = json_decode($request->input('volume_ids', '[]'), true);
            $deletedTimesheetIds = $request->input('deleted_timesheet_ids', '[]');

            Log::info('Raw Deleted Timesheet IDs:', ['value' => $deletedTimesheetIds]);

            // Perbaiki parsing deleted_timesheet_ids
            if (is_string($deletedTimesheetIds)) {
                $decoded = json_decode($deletedTimesheetIds, true);
                if (is_array($decoded)) {
                    // Jika elemen pertama adalah string JSON, decode lagi
                    if (isset($decoded[0]) && is_string($decoded[0]) && str_starts_with($decoded[0], '[')) {
                        $decoded = json_decode($decoded[0], true);
                    }
                    $deletedTimesheetIds = $decoded;
                } else {
                    $deletedTimesheetIds = [];
                }
            }

            // Pastikan deletedTimesheetIds adalah array numerik
            $deletedTimesheetIds = array_map('intval', $deletedTimesheetIds);
            $request->merge(['volume_ids' => $volumeIds, 'deleted_timesheet_ids' => $deletedTimesheetIds]);

            $request->validate([
                'execution_date' => 'date',
                'activities' => 'array',
                'durations' => 'array',
                'personel_ids' => 'array',
                'timesheet_ids' => 'array',
                'volume_ids' => 'array',
            ]);

            Log::info('edit called with:', $request->all());

            $executionDate = $request->input('execution_date');
            $activities = $request->input('activities');
            $durations = $request->input('durations');
            $personelIds = $request->input('personel_ids');
            // $timesheetIds = $request->input('timesheet_ids');

            // Hapus data berdasarkan deletedTimesheetIds
            if (!empty($deletedTimesheetIds)) {
                Timesheet::whereIn('timesheet_id', $deletedTimesheetIds)->delete();
            }

            $hasChanges = false;
            $updatedOrCreated = [];

            // Proses pembaruan data berdasarkan timesheet_ids
            foreach ($personelIds as $index => $userId) {
                $activity = $activities[$index] ?? null;
                $duration = $durations[$index] ?? null;

                if ($executionDate === null || $activity === null || $duration === null) {
                    continue;
                }

                foreach ($volumeIds as $volumeId) {
                    $timesheet = Timesheet::where('volume_id', $volumeId)
                        ->where('user_id', $userId)
                        ->first();

                    if ($timesheet) {
                        // Periksa perubahan
                        $isDurationChanged = (float)$duration !== (float)$timesheet->duration;
                        $isActivityChanged = trim($activity) !== trim($timesheet->activity);
                        $isExecutionDateChanged = $executionDate !== $timesheet->execution_date;

                        Log::info('Checking timesheet:', [
                            'timesheet_id' => $timesheet->timesheet_id,
                            'user_id' => $userId,
                            'volume_id' => $volumeId,
                            'isDurationChanged' => $isDurationChanged,
                            'isActivityChanged' => $isActivityChanged,
                        ]);

                        if ($isDurationChanged || $isActivityChanged || $isExecutionDateChanged) {
                            $timesheet->update([
                                'execution_date' => $executionDate,
                                'duration' => $duration,
                                'activity' => $activity,
                            ]);
                            $hasChanges = true;
                            $updatedOrCreated[] = $timesheet;
                            Log::info('Updated timesheet:', ['timesheet_id' => $timesheet->timesheet_id]);
                        }
                    } else {
                        // Buat entri baru untuk user ini di volume ini
                        $new = Timesheet::create([
                            'user_id' => $userId,
                            'volume_id' => $volumeId,
                            'execution_date' => $executionDate,
                            'duration' => $duration,
                            'activity' => $activity,
                        ]);
                        $hasChanges = true;
                        $updatedOrCreated[] = $new;
                        Log::info('Created new timesheet:', ['timesheet_id' => $new->timesheet_id, 'user_id' => $userId]);
                    }
                }
            }

            if (!$hasChanges && empty($deletedTimesheetIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan yang dilakukan.'
                ], 400);
            }

            $responseData = $this->formatResponseData($updatedOrCreated);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            Log::error('Error in edit:', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function formatResponseData($timesheets){

        $timesheets = collect($timesheets);

        return $timesheets->map(function ($timesheet) {
            $user = $timesheet->user;
            $workPackage = $timesheet->volume->workPackage;

            return [
                'user_id' => $user->user_id,
                'user' => $user->load('roles'),
                'execution_date' => $timesheet->execution_date,
                'activity' => $timesheet->activity,
                'duration' => $timesheet->duration,
                'volume_ids' => $timesheet->volume->pluck('volume_id')->toArray(),
                'timesheet_ids' => [$timesheet->timesheet_id],
                'work_package' => $workPackage,
                'wo_id' => $timesheet->volume->wo_id,
            ];
        });
    }

    public function deleteAll($ids)
    {
        try {
            // $activity = Timesheet::findOrFail($id);

            // Ambil execution_date dan volume_id dari entri tersebut
            // $executionDate = $activity->execution_date;
            // $volumeId = $activity->volume_id;

            $timesheetIds = explode(',', $ids);

            // Hapus semua entri di tanggal & volume yang sama
            Timesheet::whereIn('timesheet_id', $timesheetIds)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPersonelMandays($personelId, $volumeId)
    {
        try {
            // Ambil role_id dari tabel Work
            $roleId = Work::where('user_id', $personelId)
                ->where('volume_id', $volumeId)
                ->value('role_id');

            // Ambil JHK/Mandays Rencana dari tabel human_resource
            $mandaysPlan = HumanResource::where('role_id', $roleId)
                ->where('wp_id', function ($query) use ($volumeId) {
                    $query->select('wp_id')
                        ->from('work_package_volume')
                        ->where('volume_id', $volumeId)
                        ->limit(1);
                })
                ->value('jhk') ?? 0;

            // Hitung JHK/Mandays Realisasi dari tabel timesheet
            $mandaysReal = Timesheet::where('user_id', $personelId)
                ->where('volume_id', $volumeId)
                ->sum('duration') ?? 0;

            // Format nilai mandays agar tidak menampilkan .0 jika tidak diperlukan
            $mandaysReal = (float) $mandaysReal == intval($mandaysReal) ? intval($mandaysReal) : round($mandaysReal, 2);
            
            return response()->json([
                'success' => true,
                'mandays_plan' => $mandaysPlan,
                'mandays_real' => $mandaysReal,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getWorkPackagesByWO($woId)
    {
        try {
            // Ambil data work packages berdasarkan wo_id
            $volumes = WorkPackageVolume::where('wo_id', $woId)
                ->with('workPackage') // Relasi ke tabel work_package
                ->get();

            if ($volumes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada work package yang ditemukan untuk Work Order ini.',
                ], 404);
            }

            // Ambil periode dari salah satu volume (karena semua volume dalam WO memiliki periode yang sama)
            $firstVolume = $volumes->first();
            $startDate = \Carbon\Carbon::parse($firstVolume->start_date)->translatedFormat('d M Y');
            $endDate = \Carbon\Carbon::parse($firstVolume->end_date)->translatedFormat('d M Y');
            $period = "$startDate - $endDate";

            // Kelompokkan data work packages berdasarkan wp_id
            $workPackages = $volumes->groupBy('wp_id')->map(function ($wpVolumes) {
                $firstVolume = $wpVolumes->first();
                return [
                    'wp_id' => $firstVolume->workPackage->wp_id,
                    'wp_number' => $firstVolume->workPackage->wp_number,
                    'name' => $firstVolume->workPackage->name,
                    'volume_count' => $wpVolumes->count(), // Hitung jumlah volume dalam WP
                ];
            })->sortBy('wp_number')->values(); // Ubah hasil menjadi array numerik

            return response()->json([
                'success' => true,
                'period' => $period, // Periode pengerjaan WO
                'work_packages' => $workPackages,
            ]);
        } catch (\Exception $e) {
            // Tangani error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getPersonelByWO(Request $request)
    {
        try {
            $woId = $request->query('wo_id'); // Ambil Work Order ID dari query parameter
            $wpId = $request->query('wp_id') ?? null; // Ambil Work Package ID dari query parameter (opsional)

            // Validasi bahwa wo_id wajib ada
            if (!$woId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Work Order ID tidak ditemukan.',
                ], 400);
            }

            // Ambil salah satu volume_id berdasarkan wo_id dan wp_id (jika ada)
            $volumeQuery = WorkPackageVolume::where('wo_id', $woId);

            if ($wpId) {
                $volumeQuery->where('wp_id', $wpId);
            }

            $volume = $volumeQuery->first(); // Ambil salah satu volume

            if (!$volume) {
                return response()->json([
                    'success' => false,
                    'message' => 'Volume tidak ditemukan untuk Work Order dan Work Package yang dipilih.',
                ], 404);
            }

            $volumeId = $volume->volume_id;

            // Query untuk mengambil personel berdasarkan volume_id
            $personnel = Work::with(['user', 'role']) // Tambahkan relasi 'role'
                ->where('volume_id', $volumeId)
                ->get()
                ->map(function ($work) {
                    return [
                        'user_id' => $work->user->user_id,
                        'name' => $work->user->name,
                        'role' => $work->role ? $work->role->name : null, // Ambil nama role jika ada
                    ];
                });

            // Jika tidak ada personel ditemukan
            if ($personnel->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada personel yang ditemukan untuk Volume ID ini.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'personnel' => $personnel,
                'volume_id' => $volumeId, // Sertakan volume_id untuk referensi di frontend
            ]);
        } catch (\Exception $e) {
            // Tangani error
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // public function delete($id)
    // {
    //     try {
    //         Timesheet::findOrFail($id)
    //             ->delete();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil dihapus.'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }

    // }
}
