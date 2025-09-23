<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use App\Models\Task;
use App\Models\SubTask;
use App\Models\User;
use App\Models\Work;
use App\Models\WorkOrder;
use Illuminate\Support\Facades\Log;
use DB;
use Exception;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Hitung total Work Order yang tersedia
        $totalWorkOrders = WorkOrder::count();

        // Data untuk pie chart WO
        $pieChartDataWo = $this->countWPAsociatedWithWO();

        // Data Bar chart total work package dari SDM (User)
        $userWorkPackageData = $this->getUserWithWorkPackage();

        $barChartWpSDMData = [
            'labels' => $userWorkPackageData->pluck('name')->toArray(),
            'data' => $userWorkPackageData->pluck('work_package_count')->toArray(),
            'details' => $userWorkPackageData->toArray(),
            'total_users' => $userWorkPackageData->count()
        ];

        return view('dashboard', compact(
            'totalWorkOrders',
            'pieChartDataWo',
            'barChartWpSDMData'
        ));
    }

    /**
     * Count WP which have been called by WO
     */
    private function countWPAsociatedWithWO() {
        $totalWorkPackages = WorkPackage::count();

        // Hitung WP yang sudah memiliki WO
        $wpWithWorkOrder = WorkPackage::whereHas('workPackageVolumes', function($query) {
            $query->whereNotNull('wo_id');
        })->count();

        // Hitung WP yang belum memiliki WO
        $wpWithoutWorkOrder = $totalWorkPackages - $wpWithWorkOrder;

        return [
            'labels' => ['Sudah dipanggil WO', 'Belum'],
            'data' => [$wpWithWorkOrder, $wpWithoutWorkOrder],
            'total' => $totalWorkPackages
        ];
    }

    /**
     * Get User with total work package assigned
     */
    private function getUserWithWorkPackage()
    {
        try {
            $userWorkPackageData = User::with(['work.volume.workPackage', 'roles'])
                ->whereDoesntHave('roles', function($query) {
                    $query->where('name', 'admin');
                })
                ->whereHas('work')
                ->get()
                ->map(function($user) {
                    // Hitung jumlah unique work package yang dikerjakan user ini
                    $workPackageIds = $user->work
                        ->pluck('volume.workPackage.wp_id')
                        ->filter() // Remove null values
                        ->unique()
                        ->count();
                    
                    return [
                        'user_id' => $user->user_id,
                        'name' => $user->name,
                        'work_package_count' => $workPackageIds,
                        'work_assignments_count' => $user->work->count()
                    ];
                })
                ->filter(function($user) {
                    return $user['work_package_count'] > 0;
                })
                ->sortByDesc('work_package_count')
                ->values();
    
            return $userWorkPackageData;

        } catch (Exception $e) {
            Log::error('Error in getUserWithWorkPackage', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return collect();
        }
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
