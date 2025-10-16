<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\WorkPackageVolume;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Contracts\Service\Attribute\Required;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $volume_id = null)
    {
        // Use volume_id from URL segment or query parameter
        $volume_id = $volume_id ?: $request->query('volume_id');

        // Jika ada parameter volume_id di query string
        if ($request->has('volume_id')) {
            return $this->detail($volume_id, $request);
        }

        return view('timesheet');

    }

    public function detail($volume_id, Request $request)
    {
        // work package volume
        $volume = WorkPackageVolume::with(['workPackage', 'task'])->findOrFail($volume_id);
        $workPackage = $volume->workPackage;

        // ambil jhk
        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('role_id') 
            ->get();

        // timesheets
        $timesheets = Timesheet::with('user.roles')
            ->where('volume_id', $volume->volume_id)
            ->orderBy('execution_date', 'asc')
            ->get();

        // daftar bulan unik dari timesheets
        $months = $timesheets->groupBy(function ($timesheet) {
            return Carbon::parse($timesheet->execution_date)->format('F'); // "January", "February", etc.
        })->keys()->sort(function ($a, $b) { // Sort bulan secara kronologis
            return Carbon::parse($a)->month - Carbon::parse($b)->month;
        })->values();

        // bulan yang terpilih untuk dilihat
        $selectedMonth = $request->query('month');
        if (!$selectedMonth && $months->isNotEmpty()) {
            $selectedMonth = $months->first(); // Default ke bulan pertama jika tidak ada param
        } else if (!$selectedMonth) {
            $selectedMonth = Carbon::now()->format('F'); // Fallback ke bulan saat ini jika tidak ada timesheet
        }

        // timesheets yang difilter berdasarkan bulan terpilih
        $monthTimesheets = $timesheets->filter(function ($timesheet) use ($selectedMonth) {
            return Carbon::parse($timesheet->execution_date)->format('F') === $selectedMonth;
        });

        // mengelompokkan timesheets berdasarkan tanggal eksekusi
        $monthDates = $monthTimesheets->groupBy('execution_date')->sortKeys();

        // daftar unique timesheet dari bulan yang dipilih
        $usersInSelectedMonth = $timesheets->pluck('user')->unique('user_id')
                                            ->sortBy(function($user) {
                                                return $user->roles->get(1)?->id ?? $user->roles->first()?->id;
                                })->values();

        $assignedUsers = User::whereHas('work', function($query) use ($volume_id) {
            $query->where('volume_id', $volume_id);
        })->with(['work' => function($query) use ($volume_id) {
            $query->where('volume_id', $volume_id)->with('role');
        }])
        ->withCount(['timesheets as total_mandays' => function ($query) use ($volume_id) {
            $query->where('volume_id', $volume_id);
        }])
        ->get()
        ->map(function ($user) use ($workPackage, $volume_id) {
            $workRecord = $user->work->where('volume_id', $volume_id)->first();
            $roleId = $workRecord->role_id ?? null;
            $roleName = $workRecord->role->name ?? 'No Role';

            $humanResource = HumanResource::where('wp_id', $workPackage->wp_id)
                                            ->where('role_id', $roleId)
                                            ->first();

            static $usedShortNames = [];
                $parts = explode(' ', trim($user->name));
                $short = $parts[0];
                if (in_array(strtolower($short), $usedShortNames) && count($parts) > 1) {
                    $short .= ' ' . strtoupper(substr($parts[1], 0, 1));
                }
                $usedShortNames[] = strtolower($short);

            return [
                'user_id' => $user->user_id,
                'name' => $short,
                'role_name' => $roleName,
                'role_id' => $roleId,
                'jhk' => $humanResource ? $humanResource->jhk : null,
                'realisasiMandays' => $user->timesheets->where('volume_id', $volume_id)->sum('duration'),
            ];
        })->groupBy('role_id')
        ->sortKeys() // urutkan role_id ascending
        ->map(function($group) {
            return $group->sortBy('user_id')->values(); // urutkan user_id ascending di setiap role
        })
        ->flatten(1) // gabungkan semua group jadi satu array
        ->values();

        // menghitung jumlah aktivitas untuk setiap role
        $timesheetCountPerRole = $timesheets->groupBy(function ($entry) {
            $user = $entry->user;
            if (!$user || !$user->roles || $user->roles->isEmpty()) {
                return null;
            }
            return $user->roles->get(1)?->id ?? $user->roles->first()?->id;
        })->map(function ($entriesPerRole) {
            return $entriesPerRole->sum('duration');
        });

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $monthTimesheets = $timesheets->filter(function ($timesheet) use ($selectedMonth, $startDate, $endDate) {
            $date = Carbon::parse($timesheet->execution_date);
            
            // Cek bulan
            $isInSelectedMonth = $date->format('F') === $selectedMonth;

            // Cek rentang tanggal jika diberikan
            $isInDateRange = true;
            if ($startDate && $endDate) {
                $isInDateRange = $date->between(Carbon::parse($startDate), Carbon::parse($endDate));
            }

            return $isInSelectedMonth && $isInDateRange;
        });

        return view('timesheet', compact('workPackage', 'volume', 'timesheets', 'usersInSelectedMonth', 
                                         'humanResources', 'months', 'selectedMonth', 'assignedUsers',
                                         'monthTimesheets', 'monthDates', 'timesheetCountPerRole'));
    }

    public function detailperUser($volume_id, $user_id){
        // work package volume
        $volume = WorkPackageVolume::with('workPackage')->findOrFail($volume_id);
        $workPackage = $volume->workPackage;
        
        // timesheet activity
        $activities = Timesheet::with('user.roles', 'volume')
            ->where('user_id', $user_id)
            ->whereIn('volume_id', function ($query) use ($volume) {
                $query->select('volume_id')
                    ->from('work_package_volume')
                    ->where('wp_id', $volume->wp_id)
                    ->where('wo_id', $volume->wo_id);
            })
            ->orderBy('execution_date', 'asc')
            ->get()
            ->groupBy(function ($activity) {
                // Kelompokkan berdasarkan execution_date dan wo_id
                return $activity->execution_date . '-' . $activity->volume->wo_id;
            })
            ->map(function ($group) {
                // Ambil aktivitas pertama dalam grup
                $firstActivity = $group->first();

                // Gabungkan aktivitas menjadi satu string (ambil salah satu saja)
                $firstActivity->activity = $group->pluck('activity')->unique()->first();

                // Jumlahkan durasi dan hitung rata-rata
                $totalDuration = $group->sum('duration');
                $averageDuration = $totalDuration / $group->count();

                // Set durasi menjadi rata-rata
                $firstActivity->duration = round($averageDuration, 2);

                // Tambahkan related_timesheet_ids
                $firstActivity->related_timesheet_ids = $group->pluck('timesheet_id')->toArray();

                return $firstActivity;
            })
            ->values();

        // user info
        $user = User::with('roles')->findOrFail($user_id);

        $workRecord = $user->work->where('volume_id', $volume_id)->first();
        $roleId = $workRecord->role_id ?? null;
        $roleName = $workRecord && $workRecord->role ? $workRecord->role->name : 'No Role';

        // $role_id = $user->roles->get(1)?->id ?? $user->roles->first()?->id;
        
        // ambil jhk
        $humanResources = HumanResource::where('wp_id', $workPackage->wp_id)
            ->where('role_id', $roleId)
            ->first();

        // menghitung jumlah aktivitas dari role tertentu
        $activitiesCount = $activities->sum('duration');

        if ($volume->start_date && $volume->end_date) {
            $startDate = Carbon::parse($volume->start_date)->format('Y-m-d');
            $endDate = Carbon::parse($volume->end_date)->format('Y-m-d');
            $dateNow = Carbon::now()->format('Y-m-d');

            if ($startDate <= $dateNow && $dateNow <= $endDate) {
                $periodValid = true; // dalam periode
            } else {
                $periodValid = false; // di luar periode
            }
        } else {
            $periodValid = false; // Jika tanggal tidak valid
        }

        return view('timesheet_per_user', compact('volume', 'workPackage', 'humanResources', 'activities', 
                                                  'user', 'roleName', 'activitiesCount', 'periodValid'));
    }
    
    /**
     * adding the user activity.
     */
    public function addperUser(Request $request, $volume_id, $user_id)
    {
        try {
            // Validasi input
            $request->validate([
                'execution_date' => 'required|date',
                'duration' => 'required|numeric',
                'activity' => 'required'
            ]);

            // Ambil volume yang sedang diproses
            $currentVolume = WorkPackageVolume::with('workPackage')->findOrFail($volume_id);

            // Cari semua volume milik WP yang memiliki wo_id yang sama
            $relatedVolumes = WorkPackageVolume::where('wp_id', $currentVolume->wp_id)
                ->where('wo_id', $currentVolume->wo_id)
                ->get();

            // Jika tidak ada volume terkait, hanya simpan untuk volume saat ini
            if ($relatedVolumes->count() <= 1) {
                // Cek apakah sudah ada aktivitas di volume & tanggal yang sama untuk user ini
                $exists = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $volume_id)
                    ->whereDate('execution_date', $request->execution_date)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Anda sudah mengisi aktivitas untuk WP volume dan tanggal ini.'
                    ], 422);
                }

                // Simpan aktivitas baru
                $activity = Timesheet::create([
                    'user_id' => $user_id,
                    'volume_id' => $volume_id,
                    'duration' => $request->duration,
                    'execution_date' => $request->execution_date,
                    'activity' => $request->activity,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil ditambahkan.',
                    'data' => $activity
                ]);
            }

            // Jika ada lebih dari 1 volume terkait, simpan aktivitas untuk semua volume
            $activities = [];
            foreach ($relatedVolumes as $volume) {
                // Cek apakah sudah ada aktivitas di volume & tanggal yang sama untuk user ini
                $exists = Timesheet::where('user_id', $user_id)
                    ->where('volume_id', $volume->volume_id)
                    ->whereDate('execution_date', $request->execution_date)
                    ->exists();

                if (!$exists) {
                    $activities[] = Timesheet::create([
                        'user_id' => $user_id,
                        'volume_id' => $volume->volume_id,
                        'duration' => $request->duration,
                        'execution_date' => $request->execution_date,
                        'activity' => $request->activity,
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan untuk semua volume terkait.',
                'data' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * editing the user activity.
     */
    public function editperUser(Request $request, $volume_id, $user_id)
    {
        try {
            // Validasi input
            $request->validate([
                'execution_date' => 'nullable|date',
                'duration' => 'nullable|numeric',
                'activity' => 'nullable|string',
                'timesheet_ids' => 'required' // Pastikan timesheet_ids diterima sebagai array atau string
            ]);

            // Ambil data langsung dari request JSON
            $timesheetIds = $request->input('timesheet_ids');

            // Pengecekan apakah data sudah ada
            if ($request->filled('execution_date')) {
                // Ambil volume yang sedang diproses
                $currentVolume = WorkPackageVolume::with('workPackage')->findOrFail($volume_id);

                // Cari semua volume milik WP yang memiliki wo_id yang sama
                $relatedVolumes = WorkPackageVolume::where('wp_id', $currentVolume->wp_id)
                                                    ->where('wo_id', $currentVolume->wo_id)
                                                    ->pluck('volume_id');
                
                // Periksa apakah ada entri timesheet lain pada tanggal yang sama
                $exists = Timesheet::where('user_id', $user_id)
                                    ->whereIn('volume_id', $relatedVolumes)
                                    ->whereDate('execution_date', $request->execution_date)
                                    ->whereNotIn('timesheet_id', $timesheetIds) // Pastikan bukan data yang sedang diedit
                                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data dengan tanggal ini sudah ada untuk WP volume yang sama.'
                    ], 422);
                }
            }

            // Perbarui semua timesheet_id yang diberikan
            $updateData = [];
            if ($request->filled('execution_date')) {
                $updateData['execution_date'] = $request->execution_date;
            }
            if ($request->filled('duration')) {
                $updateData['duration'] = $request->duration;
            }
            if ($request->filled('activity')) {
                $updateData['activity'] = $request->activity;
            }
            
            // Periksa apakah ada data yang perlu diperbarui
            if (!empty($updateData)) {
                $updatedRows = Timesheet::whereIn('timesheet_id', $timesheetIds)
                                        ->where('user_id', $user_id)
                                        ->update($updateData);

                // Jika tidak ada baris yang diperbarui, berikan pesan
                if ($updatedRows === 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data yang diperbarui. Mungkin timesheet_id tidak ditemukan atau user tidak memiliki izin.'
                    ], 404);
                }
            }

             $message = count($timesheetIds) > 1 
                ? 'Data berhasil diperbarui untuk semua volume terkait.' 
                : 'Data berhasil diperbarui.';
            return response()->json([
                'success' => true,
                'message' => $message,
                // 'data' => $updatedActivities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteperUser($timesheet_id){
        try {
            $activity = Timesheet::findorfail($timesheet_id);
            $activity->delete();

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
