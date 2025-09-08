<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
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
            $wpNumber = optional($timesheet->volume->workPackage)->wp_number ?? ''; // Sesuaikan jika WP Anda punya kolom lain untuk number
            $wpName = optional($timesheet->volume->workPackage)->name ?? '';
            $volumeNum = optional($timesheet->volume)->vol_num ?? ''; // Tambahkan volume number jika ingin urutan di dalam WP Group
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

        // ambil semua work package dari database, pastikan untuk menghindari duplikasi
        $workPackages = WorkPackage::with('workPackageVolumes.users')->get();

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = $timesheets->pluck('user')
                            ->filter() // pastikan user tidak null
                            ->unique('user_id')
                            ->sortBy(function($user) {
                                return $user->roles->get(1)?->id ?? $user->roles->first()?->id ?? 0;
                            })->values();

        $personnelByVolume = [];

        foreach ($workPackages as $wp) {
            foreach ($wp->workPackageVolumes as $vol) {
                $personnelByVolume[$vol->volume_id] = $vol->users->map(function($user) {
                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'roles' => $user->roles->map(function($role) {
                            return [
                                'id' => $role->id,
                                'name' => $role->name
                            ];
                        })->values()
                    ];
                });
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
                                                    'groupedActivities', 'users', 'workPackages', 'personnelByVolume'));
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
        // edit and or delete activity
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

            $hasChanges = false;
            $updatedOrCreated = [];

            // Cek apakah ada perubahan pada volume_id atau execution_date
            // tidak sekedar cek apakah terisi, tapi apakah ada perubahan !!
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
                }
                // Create
                else {
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
            if (!$hasChanges) {
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

    public function delete($id)
    {
        try {
            Timesheet::findOrFail($id)
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
}
