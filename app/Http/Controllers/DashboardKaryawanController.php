<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\Work;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class DashboardKaryawanController extends Controller
{
    public function index(Request $request, $user_id){
        $today = now()->toDateString();
        // hitung wp yg dikerjakan user
        $volumeIds = Work::where('user_id', $user_id)->pluck('volume_id');
        $wpIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)->pluck('wp_id');
        $workPackages = WorkPackage::with('wpCategory', 'workPackageVolumes')
            ->whereIn('wp_id', $wpIds)
            ->get();
        $wpCount = $workPackages->count();


        // Ambil volume yang sedang berjalan (start_date <= today && (end_date >= today || end_date IS NULL))
        $activeVolumeIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->where(function($q) use ($today) {
                $q->where('start_date', '<=', $today)
                ->where(function($q2) use ($today) {
                    $q2->where('end_date', '>=', $today)
                        ->orWhereNull('end_date');
                });
            })
            ->pluck('wp_id');

        // Ambil work package yang sedang berjalan
        $workPackagesActive = WorkPackage::with('wpCategory', 'workPackageVolumes')
            ->whereIn('wp_id', $activeVolumeIds)
            ->get();

        // Tambahkan info volume aktif dan status timesheet ke setiap WP aktif
        foreach ($workPackagesActive as $wp) {
            $activeVolume = $wp->workPackageVolumes
                ->filter(function($v) use ($today) {
                    return $v->start_date &&
                        $v->end_date &&
                        $v->start_date <= $today &&
                        $v->end_date >= $today;
                })
                ->first();

            $wp->activeVolume = $activeVolume;

            $wp->isTimesheetFilled = false;
            if ($activeVolume) {
                $wp->isTimesheetFilled = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $activeVolume->volume_id)
                    ->whereDate('execution_date', $today) // pastikan field tanggal sesuai
                    ->exists();

                // Kondisi 3: Durasi timesheet user sudah mencukupi/melampaui jhk
                // Ambil jhk dari tabel human_resource untuk WP ini
                $humanResource = $wp->humanResources
                    ->where('wp_id', $wp->wp_id)
                    ->first();
                $jhk = $humanResource ? $humanResource->jhk : 0;

                // Hitung total durasi timesheet user pada volume aktif
                $totalDurasi = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $activeVolume->volume_id)
                    ->sum('duration');

                if ($totalDurasi >= $jhk && $jhk > 0) {
                    $wp->timesheetStatus = 'Mandays mencukupi kontrak';
                } elseif ($wp->isTimesheetFilled) {
                    $wp->timesheetStatus = 'Sudah mengisi Timesheet';
                } else {
                    $wp->timesheetStatus = 'Belum mengisi Timesheet';
                }
            } else {
                $wp->timesheetStatus = 'Tidak ada volume aktif';
            }
        }

        // ambil wpv yang udah ada periode pengerjaannya
        $executionYear = WorkPackageVolume::whereNotNull('execution_year')
            ->distinct()
            ->orderBy('execution_year', 'asc')
            ->pluck('execution_year');

        // Ambil tahun yang dipilih, default ke tahun terbaru
        $currentYear = date('Y');
        $selectedYear = $request->input('execution_year', $executionYear->contains($currentYear) ? $currentYear : $executionYear->first());

        // Ambil semua WorkPackageVolume yang start_date dan end_date tidak null, sekaligus relasi WorkPackage-nya
        $wpvWithPeriod = WorkPackageVolume::whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('execution_year', $selectedYear)
            ->with('workPackage')
            ->get();

        // AJAX untuk filter tahun diagram (kembalikan hanya isi diagram-wpv)
        // if($request->ajax() && $request->has('execution_year')){
        //     $view = view('dashboard_karyawan', [
        //         'wpCount' => $wpCount,
        //         'workPackagesActive' => $workPackagesActive,
        //         'executionYear' => $executionYear,
        //         'wpvWithPeriod' => $wpvWithPeriod,
        //         'selectedYear' => $selectedYear,
        //     ])->render();

        //     // Ambil hanya isi #diagram-wpv
        //     preg_match('/<div id="diagram-wpv">(.*?)<\/div>/s', $view, $matches);
        //     $diagramHtml = $matches[1] ?? '';

        //     return response($diagramHtml);
        // }

        // AJAX untuk status timesheet (JSON)
        if($request->ajax()){
            return response()->json([
                'workPackagesActive' => $workPackagesActive,
            ]);
        }

        return view('dashboard_karyawan', compact('wpCount', 'workPackagesActive', 'executionYear', 'wpvWithPeriod', 'selectedYear'));
    }
}
