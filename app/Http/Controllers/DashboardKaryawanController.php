<?php

namespace App\Http\Controllers;

use App\Models\SubTask;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardKaryawanController extends Controller
{
    public function index(Request $request, $user_id)
    {
        $today = now()->toDateString();
        
        // 1. Ambil semua volume_id yang dikerjakan user
        $volumeIds = Work::where('user_id', $user_id)->pluck('volume_id');
        
        // 2. Ambil semua WP yang terkait dengan volume tersebut
        $wpIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)->pluck('wp_id')->unique();
        
        // 3. Ambil semua WP dengan eager loading yang diperlukan
        $workPackages = WorkPackage::with([
                'wpCategory', 
                'workPackageVolumes',
                'humanResources',
                'workPackageVolumes.task.subTask'
            ])
            ->whereIn('wp_id', $wpIds)
            ->get();
        
        $wpCount = $workPackages->count();
        $selesai = 0;
        $berjalan = 0;
        
        // 4. Proses status untuk setiap WP
        foreach ($workPackages as $wp) {
            // Cek apakah ada volume dari WP ini yang dikerjakan user
            $userVolume = $wp->workPackageVolumes->whereIn('volume_id', $volumeIds)->first();
            $woId = $userVolume ? $userVolume->wo_id : null;
            
            if (!$woId) {
                $wp->volumes_count = 0;
                $wp->execution_year = '-';
                $wp->status = 'Berjalan';
                $wp->performance = 0;
                $berjalan++;
                continue;
            }
            
            // Ambil volume dengan WO yang sama
            $volumesWithSameWo = $wp->workPackageVolumes->where('wo_id', $woId);
            $wp->volumes_count = $volumesWithSameWo->count();
            
            // Ambil execution_year dari volume
            $executionYears = $volumesWithSameWo->pluck('execution_year')->unique()->filter();
            $wp->execution_year = $executionYears->count() === 1 
                ? $executionYears->first() 
                : $executionYears->implode(', ');
            
            // Hitung performance & cek tanggal
            $allDatesExpired = true;
            $performance = $this->calculateWpPerformance($wp->workPackageVolumes, $today, $allDatesExpired);
            $wp->performance = $performance;
            $wp->allDatesExpired = $allDatesExpired;
            
            // Tentukan status WP
            if ($allDatesExpired && $performance >= 100) {
                $wp->status = 'Selesai';
                $selesai++;
            } else {
                $wp->status = 'Berjalan';
                $berjalan++;
            }
        }
        
        // 5. Identifikasi WP aktif (dalam periode atau expired tapi belum 100%)
        $workPackagesActive = $this->getActiveWorkPackages($workPackages, $volumeIds, $user_id, $today);
        
        // 6. Data untuk timeline dan filter tahun
        $executionYear = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->whereNotNull('execution_year')
            ->distinct()
            ->orderBy('execution_year', 'asc')
            ->pluck('execution_year');
            
        $currentYear = date('Y');
        $selectedYear = $request->input('execution_year', 
            $executionYear->contains($currentYear) ? $currentYear : $executionYear->first());
            
        $wpvWithPeriod = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('execution_year', $selectedYear)
            ->with(['workPackage', 'task.subTask'])  // Tambahkan eager loading task dan subTask
            ->get();
        
        foreach ($wpvWithPeriod as $wpv) {
            // Gunakan relasi yang sudah di-eager load
            $tasks = $wpv->task;
            
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0;
            
            foreach ($tasks as $task) {
                $taskCompleteness = 0;
                // Gunakan relasi yang sudah di-eager load
                $subTasks = $task->subTask;
                
                if ($subTasks->count() > 0) {
                    // Jika ada subtask, hitung rata-rata completeness subtask
                    $subTasksSum = $subTasks->sum('completeness');
                    $taskCompleteness = $subTasks->count() > 0 ? 
                        $subTasksSum / $subTasks->count() : 0;
                } else {
                    // Jika tidak ada subtask, gunakan completeness task langsung
                    $taskCompleteness = $task->completeness ?? 0;
                }
                
                $totalTasksCompleteness += $taskCompleteness;
                $totalTasksCount++;
            }
            
            // Hitung rata-rata performance dan simpan ke volume
            $wpv->performance = $totalTasksCount > 0 ? 
                round($totalTasksCompleteness / $totalTasksCount, 0) : 0;
        }

        // 7. Data untuk pie chart
        $pieChartDataWP = [
            'labels' => ['Berjalan', 'Selesai'],
            'data' => [(int)$berjalan, (int)$selesai],
            'total' => (int)$wpCount
        ];
        
        // 8. AJAX response jika diperlukan
        if ($request->ajax()) {
            return response()->json([
                'workPackagesActive' => $workPackagesActive,
            ]);
        }
        
        // 9. Return view dengan semua data
        return view('dashboard_karyawan', compact(
            'workPackages', 
            'wpCount', 
            'workPackagesActive', 
            'executionYear', 
            'wpvWithPeriod', 
            'selectedYear',
            'pieChartDataWP'
        ));
    }

    private function calculateWpPerformance($volumes, $today, &$allDatesExpired)
    {
        $totalTasksCount = 0;
        $totalTasksCompleteness = 0;
        
        foreach ($volumes as $volume) {
            // Cek apakah volume masih dalam periode
            if (!$volume->end_date || $volume->end_date > $today) {
                $allDatesExpired = false;
            }
            
            // Ambil semua task untuk volume ini
            $tasks = Task::where('volume_id', $volume->volume_id)->get();
            
            foreach ($tasks as $task) {
                $taskCompleteness = 0;
                $subTasks = SubTask::where('task_id', $task->task_id)->get();
                
                if ($subTasks->count() > 0) {
                    // Jika ada subtask, hitung rata-rata completeness subtask
                    $subTasksSum = $subTasks->sum('completeness');
                    $taskCompleteness = $subTasks->count() > 0 ? 
                        $subTasksSum / $subTasks->count() : 0;
                } else {
                    // Jika tidak ada subtask, gunakan completeness task langsung
                    $taskCompleteness = $task->completeness ?? 0;
                }
                
                $totalTasksCompleteness += $taskCompleteness;
                $totalTasksCount++;
            }
        }
        
        return $totalTasksCount > 0 ? 
            round($totalTasksCompleteness / $totalTasksCount, 2) : 0;
    }

    private function getActiveWorkPackages($workPackages, $volumeIds, $user_id, $today)
    {
        $activeWorkPackages = $workPackages->filter(function($wp) use ($today) {
            // WP aktif jika:
            // 1. Ada volume yang masih dalam periode, ATAU
            // 2. Ada volume yang periodenya sudah lewat tapi performance < 100%
            
            $hasActiveVolume = $wp->workPackageVolumes->contains(function($volume) use ($today) {
                return $volume->start_date && $volume->end_date && 
                       $volume->start_date <= $today && $volume->end_date >= $today;
            });
            
            if ($hasActiveVolume) return true;
            
            // Cek apakah ada volume expired tapi performance < 100%
            foreach ($wp->workPackageVolumes as $volume) {
                if ($volume->end_date && $volume->end_date < $today) {
                    $tasks = Task::where('volume_id', $volume->volume_id)->get();
                    
                    if ($tasks->isEmpty()) return true;
                    
                    foreach ($tasks as $task) {
                        $subTasks = SubTask::where('task_id', $task->task_id)->get();
                        
                        if ($subTasks->isNotEmpty()) {
                            foreach ($subTasks as $subTask) {
                                if (($subTask->completeness ?? 0) < 100) {
                                    return true;
                                }
                            }
                        } else if (($task->completeness ?? 0) < 100) {
                            return true;
                        }
                    }
                }
            }
            
            return false;
        });
        
        // Tambahkan status timesheet ke WP aktif
        foreach ($activeWorkPackages as $wp) {
            // Cari volume aktif (dalam periode)
            $activeVolume = $wp->workPackageVolumes->first(function($v) use ($today) {
                return $v->start_date && $v->end_date && 
                       $v->start_date <= $today && $v->end_date >= $today;
            });
            
            $wp->activeVolume = $activeVolume;
            
            // Cek apakah ada volume yang periodenya sudah lewat tapi belum 100%
            $hasExpiredVolumeWithLowPerformance = $wp->workPackageVolumes->contains(function($v) use ($today) {
                if (!($v->end_date && $v->end_date < $today)) return false;
                
                $tasks = Task::where('volume_id', $v->volume_id)->get();
                
                if ($tasks->isEmpty()) return true;
                
                foreach ($tasks as $task) {
                    $subTasks = SubTask::where('task_id', $task->task_id)->get();
                    
                    if ($subTasks->isNotEmpty()) {
                        foreach ($subTasks as $subTask) {
                            if (($subTask->completeness ?? 0) < 100) return true;
                        }
                    } else if (($task->completeness ?? 0) < 100) {
                        return true;
                    }
                }
                
                return false;
            });
            
            if ($hasExpiredVolumeWithLowPerformance) {
                $wp->timesheetStatus = 'Periode melewati kontrak';
            } 
            else if ($activeVolume) {
                // Cek status timesheet untuk volume aktif
                $isTimesheetFilled = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $activeVolume->volume_id)
                    ->whereDate('execution_date', $today)
                    ->exists();
                    
                $humanResource = $wp->humanResources
                    ->where('wp_id', $wp->wp_id)
                    ->first();
                    
                $jhk = $humanResource ? $humanResource->jhk : 0;
                
                $totalDurasi = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $activeVolume->volume_id)
                    ->sum('duration');
                
                if ($totalDurasi >= $jhk && $jhk > 0) {
                    $wp->timesheetStatus = 'Mandays mencukupi kontrak';
                } else if ($isTimesheetFilled) {
                    $wp->timesheetStatus = 'Sudah mengisi Timesheet';
                } else {
                    $wp->timesheetStatus = 'Belum mengisi Timesheet';
                }
            } 
            else {
                $wp->timesheetStatus = 'Tidak ada volume aktif';
            }
        }
        
        return $activeWorkPackages;
    }

    public function getPeriodAllWPByYear(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $user_id = auth()->user()->user_id;
        
        // 1. Ambil volume_id yang dikerjakan oleh user yang login
        $volumeIds = Work::where('user_id', $user_id)->pluck('volume_id');
        
        // 2. Ambil WorkPackageVolume dengan eager loading task dan subtask
        $wpvWithPeriod = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->where('execution_year', $year)
            ->with(['workPackage', 'task.subTask'])
            ->get();
        
        // 3. Hitung performance untuk setiap volume
        foreach ($wpvWithPeriod as $wpv) {
            // GUNAKAN RELASI YANG SUDAH DI-EAGER LOAD
            $tasks = $wpv->task; // Bukan Task::where('volume_id', $wpv->volume_id)->get();
            
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0;
            
            foreach ($tasks as $task) {
                $taskCompleteness = 0;
                // GUNAKAN RELASI YANG SUDAH DI-EAGER LOAD
                $subTasks = $task->subTask; // Bukan SubTask::where('task_id', $task->task_id)->get();
                
                if ($subTasks->count() > 0) {
                    // Jika ada subtask, hitung rata-rata completeness subtask
                    $subTasksSum = $subTasks->sum('completeness');
                    $taskCompleteness = $subTasks->count() > 0 ? 
                        $subTasksSum / $subTasks->count() : 0;
                } else {
                    // Jika tidak ada subtask, gunakan completeness task langsung
                    $taskCompleteness = $task->completeness ?? 0;
                }
                
                $totalTasksCompleteness += $taskCompleteness;
                $totalTasksCount++;
            }
            
            // Hitung rata-rata performance dan simpan ke volume
            $wpv->performance = $totalTasksCount > 0 ? 
                round($totalTasksCompleteness / $totalTasksCount, 0) : 0;
        }
        
        // 4. Render partial view diagram
        $html = view('partials.diagram_wpv', [
            'wpvWithPeriod' => $wpvWithPeriod,
            'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            'lebarBulan' => 160,
            'tinggiDiagram' => 340,
        ])->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'year' => $year
        ]);
    }

    public function getUserWorkPackageDetails($user_id)
    {
        if (!$user_id) {
            $user_id = auth()->user()->user_id;
        }
        
        $user = User::find($user_id);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak ditemukan'
            ]);
        }
        
        // Ambil data work package seperti di method index()
        $today = now()->toDateString();
        
        // 1. Ambil semua volume_id yang dikerjakan user
        $volumeIds = Work::where('user_id', $user_id)->pluck('volume_id');
        
        // 2. Ambil semua WP yang terkait dengan volume tersebut
        $wpIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)->pluck('wp_id')->unique();
        
        // 3. Ambil semua WP dengan eager loading yang diperlukan
        $workPackages = WorkPackage::with([
                'wpCategory', 
                'workPackageVolumes',
                'humanResources',
                'workPackageVolumes.task.subTask'
            ])
            ->whereIn('wp_id', $wpIds)
            ->get();
        
        $wpCount = $workPackages->count();
        $selesai = 0;
        $berjalan = 0;
        
        // 4. Proses status untuk setiap WP
        foreach ($workPackages as $wp) {
            // Cek apakah ada volume dari WP ini yang dikerjakan user
            $userVolume = $wp->workPackageVolumes->whereIn('volume_id', $volumeIds)->first();
            $woId = $userVolume ? $userVolume->wo_id : null;
            
            if (!$woId) {
                $wp->volumes_count = 0;
                $wp->execution_year = '-';
                $wp->status = 'Berjalan';
                $wp->performance = 0;
                $berjalan++;
                $wp->planned_mandays = 0;
                $wp->actual_mandays = 0;
                continue;
            }
            
            // Ambil volume dengan WO yang sama
            $volumesWithSameWo = $wp->workPackageVolumes->where('wo_id', $woId);
            $wp->volumes_count = $volumesWithSameWo->count();
            
            // Ambil execution_year dari volume
            $executionYears = $volumesWithSameWo->pluck('execution_year')->unique()->filter();
            $wp->execution_year = $executionYears->count() === 1 
                ? $executionYears->first() 
                : $executionYears->implode(', ');
            
            // Hitung performance & cek tanggal
            $allDatesExpired = true;
            $performance = $this->calculateWpPerformance($wp->workPackageVolumes, $today, $allDatesExpired);
            $wp->performance = $performance;
            $wp->allDatesExpired = $allDatesExpired;
            
            // Tentukan status WP
            if ($allDatesExpired && $performance >= 100) {
                $wp->status = 'Selesai';
                $selesai++;
            } else {
                $wp->status = 'Berjalan';
                $berjalan++;
            }

            $userWork = Work::where('user_id', $user_id)
            ->whereIn('volume_id', $volumesWithSameWo->pluck('volume_id'))
            ->first();
        
            $role_id = $userWork ? $userWork->role_id : null;
            
            // Tambahan: Hitung mandays rencana (JHK) dari humanResources
            $humanResource = $wp->humanResources
                ->where('role_id', $role_id)
                ->first();
            
            $planned_mandays = $humanResource ? $humanResource->jhk : 0;
            $wp->planned_mandays = $planned_mandays;
            
            // Tambahan: Hitung mandays realisasi dari timesheet
            $volumeIdsInWp = $volumesWithSameWo->pluck('volume_id')->toArray();
            $actual_mandays = Timesheet::where('user_id', $user_id)
                ->whereIn('volume_id', $volumeIdsInWp)
                ->sum('duration'); // Konversi dari menit ke jam
            
            $wp->actual_mandays = round($actual_mandays, 2);
            
            // Hitung persentase mandays terhadap rencana
            $wp->mandays_percentage = $planned_mandays > 0 ? 
                round(($actual_mandays / $planned_mandays) * 100, 2) : 0;
        }
        
        // Total Mandays rencana dan realisasi
        // $total_planned_mandays = $workPackages->sum('planned_mandays');
        // $total_actual_mandays = $workPackages->sum('actual_mandays');
        // $total_mandays_percentage = $total_planned_mandays > 0 ? 
        //     round(($total_actual_mandays / $total_planned_mandays) * 100, 2) : 0;
        
        // Render partial view
        $html = view('partials.user_wp_details', [
            'workPackages' => $workPackages,
            'username' => $user->name,
            'totalWp' => $wpCount,
            'selesai' => $selesai,
            'berjalan' => $berjalan,
            // 'total_planned_mandays' => $total_planned_mandays,
            // 'total_actual_mandays' => $total_actual_mandays,
            // 'total_mandays_percentage' => $total_mandays_percentage
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}