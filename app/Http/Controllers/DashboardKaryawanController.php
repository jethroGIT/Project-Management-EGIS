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
            ->orderByRaw('CAST(SPLIT_PART(wp_number, \'.\', 1) AS INTEGER) ASC, CAST(SPLIT_PART(wp_number, \'.\', 2) AS INTEGER) ASC')
            ->get();
        
        $wpCount = $workPackages->count();
        $selesai = 0;
        $berjalan = 0;
        
        // 4. Proses status untuk setiap WP
        foreach ($workPackages as $wp) {
            // Cek apakah ada volume dari WP ini yang dikerjakan user
            $userVolume = $wp->workPackageVolumes->whereIn('volume_id', $volumeIds)->first();
            $woId = $userVolume ? $userVolume->wo_id : null;
            
            // if (!$woId) {
            //     $wp->volumes_count = 0;
            //     $wp->execution_year = '-';
            //     $wp->status = 'Berjalan';
            //     $wp->performance = 0;
            //     $berjalan++;
            //     continue;
            // }
            
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
            
        $wpvWithPeriod = WorkPackageVolume::whereIn('work_package_volume.volume_id', $volumeIds)
            ->whereNotNull('work_package_volume.end_date')
            ->whereNotNull('work_package_volume.wo_id')
            ->where('work_package_volume.execution_year', $selectedYear)
            ->with(['workPackage', 'workOrder', 'task.subTask'])
            ->join('work_order as wo_sort', 'work_package_volume.wo_id', '=', 'wo_sort.wo_id')
            ->orderByRaw('CAST(wo_sort.wo_number AS INTEGER) ASC')
            ->select('work_package_volume.*')
            ->get();
        
        $groupedByWo = $wpvWithPeriod->groupBy('wo_id');
        $woGroups = collect();

        foreach ($groupedByWo as $woId => $volumes) {
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0.0;

            $startDates = [];
            $endDates = [];
            $wpNumbers = [];

            foreach ($volumes as $volume) {
                // collect period bounds
                if ($volume->start_date) $startDates[] = $volume->start_date;
                if ($volume->end_date) $endDates[] = $volume->end_date;

                // collect WP numbers
                $wpNum = optional($volume->workPackage)->wp_number;
                if ($wpNum) $wpNumbers[$wpNum] = true;

                // get tasks (use eager loaded relationship if present)
                $tasks = $volume->task ?? collect();
                // if relation not loaded, fallback to query
                if ($tasks instanceof \Illuminate\Database\Eloquent\Collection === false) {
                    $tasks = Task::where('volume_id', $volume->volume_id)->with('subTask')->get();
                }

                foreach ($tasks as $task) {
                    $taskCompleteness = null;
                    if ($task->completeness !== null) {
                        $taskCompleteness = floatval($task->completeness);
                    } else {
                        // compute from sub tasks
                        $subTasks = $task->subTask ?? collect();
                        if ($subTasks->count() > 0) {
                            $subsAvg = $subTasks->avg(function($st) {
                                return $st->completeness !== null ? floatval($st->completeness) : 0;
                            });
                            $taskCompleteness = floatval($subsAvg);
                        }
                    }

                    if ($taskCompleteness !== null) {
                        $totalTasksCompleteness += $taskCompleteness;
                        $totalTasksCount++;
                    }
                }
            }

            $groupPerformance = $totalTasksCount > 0
                ? round($totalTasksCompleteness / $totalTasksCount, 2)
                : 0.0;

            // determine group period (earliest start, latest end)
            $groupStart = count($startDates) ? collect($startDates)->min() : null;
            $groupEnd = count($endDates) ? collect($endDates)->max() : null;

            $woNumber = optional($volumes->first()->workOrder)->wo_number ?? $woId;

            $woGroups->push((object)[
                'wo_id' => $woId,
                'wo_number' => $woNumber,
                'start_date' => $groupStart,
                'end_date' => $groupEnd,
                'performance' => $groupPerformance,
                'wp_numbers' => array_values(array_keys($wpNumbers)),
                'volumes' => $volumes, // include volumes if view needs details
            ]);
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
            'woGroups', 
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
        $activeWorkPackages = collect();

        foreach ($workPackages as $wp) {
            // Kelompokkan volume berdasarkan wo_id
            $volumesByWo = $wp->workPackageVolumes->groupBy('wo_id');

            foreach ($volumesByWo as $woId => $volumes) {
                // Cek apakah ada volume aktif (dalam periode)
                $hasActiveVolume = $volumes->contains(function ($volume) use ($today) {
                    return $volume->start_date && $volume->end_date &&
                        $volume->start_date <= $today && $volume->end_date >= $today;
                });

                // Cek apakah ada volume expired tapi performance < 100%
                $hasExpiredVolumeWithLowPerformance = $volumes->contains(function ($volume) use ($today) {
                    if (!($volume->end_date && $volume->end_date < $today)) return false;

                    $tasks = Task::where('volume_id', $volume->volume_id)->get();

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

                // Jika ada volume aktif atau expired dengan performance < 100%, tambahkan ke WP aktif
                if ($hasActiveVolume || $hasExpiredVolumeWithLowPerformance) {
                    $activeVolume = $volumes->first(function ($v) use ($today) {
                        return $v->start_date && $v->end_date &&
                            $v->start_date <= $today && $v->end_date >= $today;
                    });

                    $woNumber = optional($volumes->first()->workOrder)->wo_number ?? $woId;

                    $wpClone = clone $wp; // Clone WP untuk menghindari konflik data
                    $wpClone->activeVolume = $activeVolume;
                    $wpClone->wo_number = $woNumber;

                    // Tentukan status timesheet
                    if ($hasExpiredVolumeWithLowPerformance) {
                        $wpClone->timesheetStatus = 'Periode melewati kontrak';
                    } else if ($activeVolume) {
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
                            $wpClone->timesheetStatus = 'Mandays mencukupi kontrak';
                        } else if ($isTimesheetFilled) {
                            $wpClone->timesheetStatus = 'Sudah mengisi Timesheet';
                        } else {
                            $wpClone->timesheetStatus = 'Belum mengisi Timesheet';
                        }
                    } else {
                        $wpClone->timesheetStatus = 'Tidak ada volume aktif';
                    }

                    $activeWorkPackages->push($wpClone);
                }
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
        $wpvWithPeriod = WorkPackageVolume::whereIn('work_package_volume.volume_id', $volumeIds)
            ->whereNotNull('work_package_volume.end_date')
            ->whereNotNull('work_package_volume.wo_id')
            ->where('work_package_volume.execution_year', $year)
            ->with(['workPackage', 'workOrder', 'task.subTask'])
            ->join('work_order as wo_sort', 'work_package_volume.wo_id', '=', 'wo_sort.wo_id')
            ->orderByRaw('CAST(wo_sort.wo_number AS INTEGER) ASC')
            ->select('work_package_volume.*')
            ->get();
        
        $groupedByWo = $wpvWithPeriod->groupBy('wo_id');
        $woGroups = collect();

        foreach ($groupedByWo as $woId => $volumes) {
            $totalTasksCount = 0;
            $totalTasksCompleteness = 0.0;

            $startDates = [];
            $endDates = [];
            $wpNumbers = [];

            foreach ($volumes as $volume) {
                // collect period bounds
                if ($volume->start_date) $startDates[] = $volume->start_date;
                if ($volume->end_date) $endDates[] = $volume->end_date;

                // collect WP numbers
                $wpNum = optional($volume->workPackage)->wp_number;
                if ($wpNum) $wpNumbers[$wpNum] = true;

                // get tasks (use eager loaded relationship if present)
                $tasks = $volume->task ?? collect();
                // if relation not loaded, fallback to query
                if ($tasks instanceof \Illuminate\Database\Eloquent\Collection === false) {
                    $tasks = Task::where('volume_id', $volume->volume_id)->with('subTask')->get();
                }

                foreach ($tasks as $task) {
                    $taskCompleteness = null;
                    if ($task->completeness !== null) {
                        $taskCompleteness = floatval($task->completeness);
                    } else {
                        // compute from sub tasks
                        $subTasks = $task->subTask ?? collect();
                        if ($subTasks->count() > 0) {
                            $subsAvg = $subTasks->avg(function($st) {
                                return $st->completeness !== null ? floatval($st->completeness) : 0;
                            });
                            $taskCompleteness = floatval($subsAvg);
                        }
                    }

                    if ($taskCompleteness !== null) {
                        $totalTasksCompleteness += $taskCompleteness;
                        $totalTasksCount++;
                    }
                }
            }

            $groupPerformance = $totalTasksCount > 0
                ? round($totalTasksCompleteness / $totalTasksCount, 2)
                : 0.0;

            // determine group period (earliest start, latest end)
            $groupStart = count($startDates) ? collect($startDates)->min() : null;
            $groupEnd = count($endDates) ? collect($endDates)->max() : null;

            $woNumber = optional($volumes->first()->workOrder)->wo_number ?? $woId;

            $woGroups->push((object)[
                'wo_id' => $woId,
                'wo_number' => $woNumber,
                'start_date' => $groupStart,
                'end_date' => $groupEnd,
                'performance' => $groupPerformance,
                'wp_numbers' => array_values(array_keys($wpNumbers)),
                'volumes' => $volumes, // include volumes if view needs details
            ]);
        }
        
        // 4. Render partial view diagram
        $html = view('partials.diagram_timeline', [
            'woGroups' => $woGroups,
            'bulanIndonesia' => ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
            'lebarBulan' => 110,
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
        $wpIds = WorkPackageVolume::whereIn('volume_id', $volumeIds)
            ->whereNotNull('wo_id')
            ->pluck('wp_id')
            ->unique();
        
        // 3. Ambil semua WP dengan eager loading yang diperlukan
        $workPackages = WorkPackage::with([
                'wpCategory', 
                'workPackageVolumes',
                'humanResources',
                'workPackageVolumes.task.subTask'
            ])
            ->whereIn('wp_id', $wpIds)
            ->orderByRaw('CAST(SPLIT_PART(wp_number, \'.\', 1) AS INTEGER) ASC, CAST(SPLIT_PART(wp_number, \'.\', 2) AS INTEGER) ASC')
            ->get();
        
        $wpDetails = collect();
        
        // 4. Proses setiap WP dan kelompokkan berdasarkan wo_id
        foreach ($workPackages as $wp) {
            $volumesByWo = $wp->workPackageVolumes->whereIn('volume_id', $volumeIds)->groupBy('wo_id');

            foreach ($volumesByWo as $woId => $volumes) {
                if (!$woId) continue; // Abaikan volume tanpa WO

                $wpClone = clone $wp; // Clone WP untuk menghindari konflik data
                $wpClone->volumes_count = $volumes->count();

                // Ambil execution_year dari volume
                $executionYears = $volumes->pluck('execution_year')->unique()->filter();
                $wpClone->execution_year = $executionYears->count() === 1
                    ? $executionYears->first()
                    : $executionYears->implode(', ');

                // Hitung performance & cek tanggal
                $allDatesExpired = true;
                $performance = $this->calculateWpPerformance($volumes, $today, $allDatesExpired);
                $wpClone->performance = $performance;
                $wpClone->allDatesExpired = $allDatesExpired;

                // Tentukan status WP
                if ($allDatesExpired && $performance >= 100) {
                    $wpClone->status = 'Selesai';
                } else {
                    $wpClone->status = 'Berjalan';
                }

                // Tambahkan wo_number
                $wpClone->wo_number = optional($volumes->first()->workOrder)->wo_number ?? $woId;

                // Tambahan: Hitung mandays rencana (JHK) dari humanResources
                $userWork = Work::where('user_id', $user_id)
                    ->whereIn('volume_id', $volumes->pluck('volume_id'))
                    ->first();

                $role_id = $userWork ? $userWork->role_id : null;

                $humanResource = $wp->humanResources
                    ->where('role_id', $role_id)
                    ->first();

                $planned_mandays = $humanResource ? $humanResource->jhk : 0;
                $wpClone->planned_mandays = $planned_mandays;

                // Tambahan: Hitung mandays realisasi dari timesheet
                $volumeIdsInWp = $volumes->pluck('volume_id')->toArray();

                // Ambil semua aktivitas timesheet untuk volume terkait
                $timesheets = Timesheet::where('user_id', $user_id)
                    ->whereIn('volume_id', $volumeIdsInWp)
                    ->get();

                // Kelompokkan aktivitas berdasarkan tanggal
                $timesheetsGroupedByDate = $timesheets->groupBy('execution_date');

                // Hitung rata-rata durasi per hari
                $averageDurations = $timesheetsGroupedByDate->map(function ($activities) {
                    return $activities->avg('duration'); // Rata-rata durasi per hari
                });

                // Hitung rata-rata keseluruhan
                $actual_mandays = $averageDurations->sum(); // Rata-rata dari rata-rata harian

                $wpClone->actual_mandays = round($actual_mandays, 2);

                // Hitung persentase mandays terhadap rencana
                $wpClone->mandays_percentage = $planned_mandays > 0
                    ? round(($actual_mandays / $planned_mandays) * 100, 2)
                    : 0;

                $wpDetails->push($wpClone);
            }
        }

        // Render partial view
        $html = view('partials.user_wp_details', [
            'workPackages' => $wpDetails,
            'username' => $user->name,
            'totalWp' => $wpDetails->count(),
            'selesai' => $wpDetails->where('status', 'Selesai')->count(),
            'berjalan' => $wpDetails->where('status', 'Berjalan')->count(),
        ])->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }
}