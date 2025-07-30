<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
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

        $uniqueWorkPackages = $activitiesForTable->map(function($activity) {
            return $activity->volume->workPackage;
        })
        ->filter() // Hapus entri null jika ada workPackage yang tidak ditemukan
        ->unique('wp_id') // Pastikan hanya WP yang unik berdasarkan wp_id
        ->sortBy('name') // Urutkan berdasarkan nama untuk tampilan di dropdown
        ->values();

        $uniqueVolumes = $activitiesForTable->map(function($activity) {
            return $activity->volume;
        })
        ->filter() // Hapus entri null jika ada volume yang tidak ditemukan
        ->unique('volume_id') // Pastikan hanya volume yang unik berdasarkan volume_id
        ->sortBy('volume_number') // Urutkan berdasarkan nomor volume untuk tampilan di dropdown
        ->values();

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = $timesheets->pluck('user')->unique('user_id')->sortBy('role_id')->values();

        return view('timesheet_management', compact('activitiesForTable', 'users', 'uniqueWorkPackages', 'uniqueVolumes'));
    }
}
