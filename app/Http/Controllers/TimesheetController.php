<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\WorkPackageVolume;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                                                return $user->roles->first()?->id ?? 0;
                                })->values();

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
                                         'humanResources', 'months', 'selectedMonth', 
                                         'monthTimesheets', 'monthDates', 'timesheetCountPerRole'));
    }

    public function detailperUser($volume_id, $user_id){
        // work package volume
        $volume = WorkPackageVolume::with('workPackage')->findOrFail($volume_id);
        $workPackage = $volume->workPackage;
        
        // timesheet activity
        $activities= Timesheet::with('user.roles')
            ->where('user_id', $user_id)
            ->where('volume_id', $volume_id)
            ->orderBy('execution_date', 'asc')
            ->get();

        // user info
        $user = User::with('roles')->findOrFail($user_id);

        $role_id = $user->roles->get(1)?->id ?? $user->roles->first()?->id;
        
        // ambil jhk
        $humanResources = HumanResource::where('wp_id', $workPackage->wp_id)
            ->where('role_id', $role_id)
            ->first();

        // menghitung jumlah aktivitas dari role tertentu
        $activitiesCount = $activities->sum('duration');

        return view('timesheet_per_user', compact('volume', 'workPackage', 'humanResources', 'activities', 'user', 'activitiesCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    
    /**
     * adding the user activity.
     */
    public function addperUser(Request $request, $volume_id, $user_id){
        try {
            // validate
            // save
            $request->validate([
                'execution_date' => 'required|date',
                'activity' => 'required'
            ]);

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
                'execution_date' => $request->execution_date,
                'activity' => $request->activity,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan.',
                'data' => $activity // Kirim data yang diperbarui jika perlu untuk update UI
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
            // validation
            // save
            $activity = Timesheet::where('timesheet_id', $request->timesheet_id)
                                ->where('user_id', $user_id)
                                ->where('volume_id', $volume_id)
                                ->firstOrFail();

            if ($request->filled('execution_date')) {
                $activity->execution_date = $request->execution_date;
            }

            if ($request->filled('activity')) {
                $activity->activity = $request->activity;
            }

            $activity->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $activity // Kirim data yang diperbarui jika perlu untuk update UI
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
