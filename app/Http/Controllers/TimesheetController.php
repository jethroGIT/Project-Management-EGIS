<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Timesheet;
use App\Models\WorkPackageVolume;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $timesheets = Timesheet::with('user.role')
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
        $usersInSelectedMonth = $monthTimesheets->pluck('user')->unique('user_id')->sortBy('role_id')->values();

        // menghitung jumlah timesheet untuk setiap role
        $timesheetCountPerRole = $timesheets->groupBy('user.role_id')->map(function ($entriesPerRole) {
            return $entriesPerRole->count();
        });
        return view('timesheet', compact('workPackage', 'volume', 'timesheets', 'usersInSelectedMonth', 
                                         'humanResources', 'months', 'selectedMonth', 
                                         'monthTimesheets', 'monthDates', 'timesheetCountPerRole'));
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
