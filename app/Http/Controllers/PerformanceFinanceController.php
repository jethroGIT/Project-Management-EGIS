<?php

namespace App\Http\Controllers;

use App\Models\HumanResource;
use App\Models\Role;
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
        ])->findOrFail($volume_id);

        $workPackage = $volume->workPackage;

        $humanResources = HumanResource::with('role')
            ->where('wp_id', $workPackage->wp_id)
            ->orderBy('hresource_id')
            ->get();

        // Ambil work
        $works = Work::with('user')
            ->where('volume_id', $volume_id)
            ->get();
        
        // timesheets
        $timesheets = Timesheet::with('user.roles')
            ->where('volume_id', $volume->volume_id)
            ->orderBy('execution_date', 'asc')
            ->get();
        
        // Ambil semua user yang punya work di volume ini
        $assignedUsers = User::whereHas('work', function($query) use ($volume_id) {
                $query->where('volume_id', $volume_id);
            })->with([
                'work' => function($query) use ($volume_id) {
                    $query->where('volume_id', $volume_id)->with('role');
                },
                'timesheets' => function($query) use ($volume_id) {
                    $query->where('volume_id', $volume_id);
                }
            ])->get();

        // Hitung total durasi mandays per role
        $mandaysPerRole = [];
        foreach ($assignedUsers as $user) {
            $workRecord = $user->work->where('volume_id', $volume_id)->first();
            $roleId = $workRecord->role_id ?? null;
            if (!$roleId) continue;
            $duration = $user->timesheets->sum('duration');
            if (!isset($mandaysPerRole[$roleId])) $mandaysPerRole[$roleId] = 0;
            $mandaysPerRole[$roleId] += $duration;
        }

        // Hitung biaya per role
        $costsPerRole = $humanResources->map(function ($hResource) use ($mandaysPerRole) {
            $roleId = $hResource->role_id;
            $roleName = optional($hResource->role)->name ?? 'Unknown Role';
            $resourceCost = optional($hResource->role)->resource_cost ?? 0;

            $timesheetMandays = $mandaysPerRole[$roleId] ?? 0;

            $byYoyCost = $hResource->jhk * $resourceCost;
            $realizationCost = $timesheetMandays * $resourceCost;
            $remainingCost = $byYoyCost - $realizationCost;

            return [
                'role_id' => $roleId,
                'role_name' => $roleName,
                'jhk' => $hResource->jhk,
                'resource_cost' => $resourceCost,
                'timesheet_count' => $timesheetMandays,
                'by_yoy' => $byYoyCost,
                'realization_cost' => $realizationCost,
                'remaining_cost' => $remainingCost,
            ];
        });

        // Hitung total biaya dari semua role
        $totalByYoy = $costsPerRole->sum('by_yoy');
        $totalRealization = $costsPerRole->sum('realization_cost');
        $totalRemaining = $costsPerRole->sum('remaining_cost');

        // Jika realisasi < byYoy maka ada overtime
        $overtimeCost = $totalRealization > $totalByYoy ? ($totalRealization - $totalByYoy) : 0;

        // Persentase realisasi terhadap rencana (hindari pembagian nol)
        $realizationPercentage = $totalByYoy > 0 ? ($totalRealization / $totalByYoy) * 100 : 0;
        
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
    public function edit(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'resource_cost' => 'required|array',
            'resource_cost.*' => 'numeric|min:0',
        ]);

        $updated = [];

        try {
            foreach ($validated['resource_cost'] as $role_id => $resource_cost) {
                $role = Role::findOrFail($role_id);
                $role->update(['resource_cost' => $resource_cost]);
                $updated[$role_id] = $role;
            }
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $updated // Kirim data yang diperbarui jika perlu untuk update UI
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
