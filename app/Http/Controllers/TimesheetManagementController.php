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
        })->values();

        // ambil semua work package dari database, pastikan untuk menghindari duplikasi
        $workPackages = WorkPackage::with('workPackageVolumes.users')->get();

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = $timesheets->pluck('user')->unique('user_id')->sortBy('role_id')->values();

        return view('timesheet_management', compact('activitiesForTable', 'users', 'workPackages'));
    }

    public function add(Request $request){
        try {
            $request->validate([
                'Activity' => 'required|string|max:255',
            ]);

            $activity = new Timesheet();
            $activity->user_id = $request->input('user_id');
            $activity->volume_number = $request->input('volume_number');
            $activity->execution_date = $request->input('execution_date');
            $activity->activity = $request->input('activity');
            $activity->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $activity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }

    }

    public function edit(Request $request){
        try {
            //code...
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }

    }

    public function delete($id){
        try {
            //code...
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }

    }
}
