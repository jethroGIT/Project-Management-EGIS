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

class TimesheetManagementController extends Controller
{
    public function index()
    {
        // Ambil semua timesheet
        $timesheets = Timesheet::with(['user.roles', 'volume.workPackage'])
            ->orderByRaw('volume_id ASC, execution_date ASC')
            ->get();
        
        $activitiesForTable = $timesheets->sortBy(function($timesheet) {
            $wpNumber = optional($timesheet->volume->workPackage)->wp_number ?? '';
            $wpName = optional($timesheet->volume->workPackage)->name ?? '';
            $volumeNum = optional($timesheet->volume)->vol_num ?? '';
            $executionDate = optional($timesheet)->execution_date;

            // Gabungkan untuk sorting yang presisi untuk DataTables RowGroup
            return $wpNumber . '|' . $wpName . '|' . $volumeNum . '|' . $executionDate;
        });

        $groupedActivities = $activitiesForTable->groupBy(function($item) {
            return $item->volume_id . '_' . $item->execution_date;
        });

        // Buat array untuk menyimpan personel yang sudah ada di setiap group
        $existingAssignments = [];
        foreach ($groupedActivities as $key => $group) {
            $existingAssignments[$key] = $group->pluck('user_id')->unique()->values();
        }

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = $timesheets->pluck('user')
            ->filter() // pastikan user tidak null
            ->unique('user_id')
            ->sortBy('user_id')
            ->values();

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

        // ambil semua work package dari database, pastikan untuk menghindari duplikasi
        $workPackages = WorkPackage::with(['workPackageVolumes.users'])
            ->whereHas('workPackageVolumes', function ($query) {
                $query->whereNotNull('wo_id'); // Filter hanya volume yang memiliki wo_id
            })
            ->orderBy('wp_number')
            ->get();

        // Ambil hanya volume_id yang memiliki wo_id tidak null
        $validVolumes = WorkPackageVolume::whereNotNull('wo_id')
            ->get(['volume_id', 'volume_number', 'wp_id'])
            ->groupBy('wp_id')
            ->map(function ($group) {
                return $group->map(function ($volume) {
                    return [
                        'volume_id' => $volume->volume_id,
                        'volume_number' => $volume->volume_number,
                    ];
                })->values();
            })
            ->toArray();

        // Proses data untuk personnelByVolume
        $personnelByVolume = [];
        foreach ($workPackages as $wp) {
            foreach ($wp->workPackageVolumes as $vol) {
                // Pastikan hanya memproses volume yang ada di validVolumeIds
                if (in_array($vol->volume_id, array_column($validVolumes, 'volume_id'))) {
                    continue;
                }

                $personnelByVolume[$vol->volume_id] = $vol->users->map(function ($user) use ($vol) {
                    // Ambil work record user pada volume ini
                    $workRecord = $user->work->where('volume_id', $vol->volume_id)->first();
                    $roleId = $workRecord->role_id ?? null;
                    $roleName = $workRecord && $workRecord->role ? $workRecord->role->name : 'No Role';

                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'role_id' => $roleId,
                        'role_name' => $roleName,
                        'roles' => $user->roles->map(function ($role) {
                            return [
                                'id' => $role->id,
                                'name' => $role->name
                            ];
                        })->values()
                    ];
                })->values();
            }
        }

        $workPackagesFilter = WorkPackage::whereIn('wp_id', function($query) {
            $query->select('wp_id')
                ->from('work_package_volume')
                ->whereIn('volume_id', function($subQuery) {
                    $subQuery->select('volume_id')
                        ->from('timesheet');
                });
        })->orderBy('wp_number')->get();

        return view('timesheet_management', compact('activitiesForTable', 'existingAssignments', 'workPackagesFilter',
                                                    'groupedActivities', 'users', 'workPackages', 'personnelByVolume', 'validVolumes'));
    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'volume_id' => 'required|exists:work_package_volume,volume_id',
                'execution_date' => 'required|date',
                'activities' => 'required'
            ]);

            $personelIds = $request->input('personel_ids', []);
            $durations = $request->input('durations', []);
            $activities = $request->input('activities', []);

            // Cek apakah sudah ada aktivitas di volume & tanggal yang sama untuk user ini
            $exists = Timesheet::whereIn('user_id', $personelIds)
                ->where('volume_id', $request->volume_id)
                ->whereDate('execution_date', $request->execution_date)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah mengisi aktivitas untuk WP volume dan tanggal ini.'
                ], 422);
            }

            // dd($request->all());
            $timesheets =[];
            foreach ($personelIds as $index => $userId) {
                if (!isset($activities[$index])) {
                    continue; // atau return error jika ingin strict
                }
                $timesheet = Timesheet::create([
                    'user_id' => $userId, // ingat: user_id = personel_id
                    'volume_id' => $request->volume_id,
                    'execution_date' => $request->execution_date,
                    'duration' => $durations[$index],
                    'activity' => $activities[$index]
                ]);
                $timesheets[] = $timesheet;

            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $timesheets
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // to get data for edit modal
    public function editData($volumeId, $executionDate)
    {
        try {
            $activities = Timesheet::where('volume_id', $volumeId)
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

            return response()->json([
                'success' => true,
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        try {
            $request->validate([
                'execution_date' => 'date',
                'activity' => 'string|max:255'
            ]);

            $timesheetIds = $request->input('timesheet_ids', []);
            $personelIds = $request->input('personel_ids', []);
            $durations = $request->input('durations', []);
            $activities = $request->input('activities', []);
            $executionDate = $request->input('execution_date');
            $volumeId = $request->input('volume_id');
            $deletedTimesheetIds = json_decode($request->input('deleted_timesheet_ids', '[]'), true);

            // Hapus data berdasarkan deletedTimesheetIds
            if (!empty($deletedTimesheetIds)) {
                Timesheet::whereIn('timesheet_id', $deletedTimesheetIds)->delete();
            }

            $hasChanges = false;
            $updatedOrCreated = [];

            // Proses pembaruan atau penambahan data
            foreach ($personelIds as $index => $userId) {
                $activity = $activities[$index] ?? null;
                $duration = $durations[$index] ?? null;
                $timesheetId = $timesheetIds[$index] ?? null;

                if ($activity === null) continue;

                // Update jika ada ID, Create jika tidak
                if ($timesheetId) {
                    $timesheet = Timesheet::findOrFail($timesheetId);

                    $isUserChanged = $userId != $timesheet->user_id;
                    $isVolumeChanged = $volumeId != $timesheet->volume_id;
                    $isDateChanged = $executionDate != Carbon::parse($timesheet->execution_date)->format('Y-m-d');
                    $isDurationChanged = $duration != $timesheet->duration;
                    $isActivityChanged = $activity != $timesheet->activity;

                    if ($isUserChanged || $isVolumeChanged || $isDateChanged || $isDurationChanged || $isActivityChanged) {
                        $timesheet->update([
                            'user_id' => $userId,
                            'volume_id' => $volumeId,
                            'execution_date' => $executionDate,
                            'duration' => $duration,
                            'activity' => $activity,
                        ]);
                        $hasChanges = true;
                        $updatedOrCreated[] = $timesheet;
                    }
                } else {
                    $new = Timesheet::create([
                        'user_id' => $userId,
                        'volume_id' => $volumeId,
                        'execution_date' => $executionDate,
                        'duration' => $duration,
                        'activity' => $activity,
                    ]);
                    $hasChanges = true;
                    $updatedOrCreated[] = $new;
                }
            }

            if (!$hasChanges && empty($deletedTimesheetIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada perubahan yang dilakukan.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $updatedOrCreated
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAll($id)
    {
        try {
            $activity = Timesheet::findOrFail($id);

            // Ambil execution_date dan volume_id dari entri tersebut
            $executionDate = $activity->execution_date;
            $volumeId = $activity->volume_id;

            // Hapus semua entri di tanggal & volume yang sama
            Timesheet::where('execution_date', $executionDate)
                ->where('volume_id', $volumeId)
                ->delete();

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
