<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class TimesheetManagementController extends Controller
{
    public function index()
    {
        // Ambil semua timesheet
        $timesheets = Timesheet::with(['user.role', 'volume.workPackage'])
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

        // ambil semua work package dari database, pastikan untuk menghindari duplikasi
        $workPackages = WorkPackage::with('workPackageVolumes.users')->get();

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = $timesheets->pluck('user')->unique('user_id')->sortBy('role_id')->values();

        $personnelByVolume = [];

        foreach ($workPackages as $wp) {
            foreach ($wp->workPackageVolumes as $volume) {
                $personnelByVolume[$volume->volume_id] = $volume->users->map(function ($user) {
                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'role' => $user->role->name ?? '-',
                    ];
                })->values();
            }
        }

        return view('timesheet_management', compact('activitiesForTable', 'groupedActivities', 'users', 'workPackages', 'personnelByVolume'));
    }

    public function add(Request $request){
        try {
            $request->validate([
                'volume_id' => 'required|exists:work_package_volumes,volume_id',
                'execution_date' => 'required|date',
                'activity' => 'required'
            ]);

            $personelIds = $request->input('personel_ids', []);
            $activities = $request->input('activities', []);

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

    public function edit(Request $request){
        // edit and or delete activity
        try {
             $activity = Timesheet::where('timesheet_id', $request->timesheet_id)
                                ->where('user_id', $request->user_id)
                                ->where('volume_id', $request->volume_id)
                                ->firstOrFail();

            if ($request->filled('execution_date')) {
                $activity->execution_date = $request->execution_date;
            }

            if ($request->filled('activity')) {
                $activity->activity = $request->activity;
            }

            $activity->save();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function delete($id){
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
}
