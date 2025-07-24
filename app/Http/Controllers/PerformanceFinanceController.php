<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Timesheet;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class PerformanceFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('performance_finance');
    }

    public function detail($volume_id)
    {
        $volume = WorkPackageVolume::with([
            'workPackage', 
            'task',
            'work.user'
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;

        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();

        // Ambil work
        $works = Work::with(['user.role'])
            ->where('volume_id', $volume_id)
            ->get();
        
        // timesheets
        $timesheets = Timesheet::with('user.role')
            ->where('volume_id', $volume->volume_id)
            ->orderBy('execution_date', 'asc')
            ->get();
        
        // menghitung jumlah aktivitas untuk setiap role
        $timesheetCountPerRole = $timesheets->groupBy('user.role_id')->map(function ($entriesPerRole) {
            return $entriesPerRole->count();
        });

        // Kelompokkan resource_cost berdasarkan role
        $resourceCostPerRole = $works->groupBy(function ($work) {
            return optional($work->user->role)->role_id;
        })->map(function ($groupedWorks) {
            return [
                'role_id' => optional($groupedWorks->first()->user->role)->role_id,
                'role_name' => optional($groupedWorks->first()->user->role)->name,
                'resource_cost' => $groupedWorks->sum('resource_cost'),
            ];
        });

        $costsPerRole = $humanResources->map(function ($hResource) use ($resourceCostPerRole, $timesheetCountPerRole) {
            $roleId = $hResource->role_id;

            // Ambil resource cost untuk role
            $resCost = $resourceCostPerRole->firstWhere('role_id', $roleId);
            $resourceCost = $resCost['resource_cost'] ?? 0;

            // Ambil jumlah aktivitas dari timesheet untuk role ini
            $timesheetCount = $timesheetCountPerRole[$roleId] ?? 0;

            // Hitung biaya-biaya
            $byYoyCost = $hResource->jhk * $resourceCost;
            $realizaationCost = $timesheetCount * $resourceCost;
            $remainingCost = $byYoyCost - $realizaationCost;

            return [
                'role_id' => $roleId,
                'role_name' => $hResource->role->name,
                'jhk' => $hResource->jhk,
                'resource_cost' => $resourceCost,
                'timesheet_count' => $timesheetCount,
                'by_yoy' => $byYoyCost,
                'actual' => $realizaationCost,
                'remaining' => $remainingCost,
            ];
        });

        // Hitung total biaya dari semua role
        $totalByYoy = $costsPerRole->sum('by_yoy');
        $totalRealization = $costsPerRole->sum('actual');
        $totalRemaining = $costsPerRole->sum('remaining');

        // Jika realisasi < byYoy maka ada overtime
        $overtimeCost = $totalRealization > $totalByYoy ? ($totalRealization - $totalByYoy) : 0;

        // Persentase realisasi terhadap rencana (hindari pembagian nol)
        $realizationPercentage = $totalByYoy > 0 ? ($totalRealization / $totalByYoy) * 100 : 0;
        if($realizationPercentage > 100){
            $realizationPercentage = 100;
        }
        
        return view('performance_finance', compact(
            'volume_id',
            'workPackage',
            'costsPerRole',
            'totalByYoy',
            'totalRealization',
            'totalRemaining',
            'overtimeCost',
            'realizationPercentage'
        ));
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
