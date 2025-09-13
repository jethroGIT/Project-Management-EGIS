<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\WorkOrder;
use App\Models\WorkPackageVolume;

class SidebarComposer
{
    public function compose(View $view)
    {
        $workOrdersByYear = WorkOrder::with(['workPackageVolumes' => function($query) {
            $query->with('workPackage')
                ->whereNotNull('start_date')
                ->whereNotNull('end_date')
                ->whereNotNull('execution_year')
                ->orderBy('volume_number');
        }])
        ->whereHas('workPackageVolumes', function($query) {
            $query->whereNotNull('start_date')
                ->whereNotNull('end_date')
                ->whereNotNull('execution_year');
        })
        ->orderBy('wo_number')
        ->get()
        ->groupBy(function($workOrder) {
            // Group berdasarkan tahun execution year dari volume pertama
            $firstVolume = $workOrder->workPackageVolumes->first();
            return $firstVolume ? $firstVolume->execution_year : 'Unknown';
        });

        $workPackagesByYear = WorkPackageVolume::with('workPackage')
            ->whereNotNull('start_date')
            ->whereNotNull('end_date')
            ->whereNotNull('execution_year')
            ->orderBy('execution_year')
            ->orderBy('volume_number')
            ->get()
            ->groupBy('execution_year');

        // Mendapatkan wo_id yang sedang aktif dari route
        $currentWoId = null;
        if (request()->routeIs('wo.content-list')) {
            $currentWoId = request()->route('wo_id');
        }
        
        // Mendapatkan volume_id yang sedang aktif dari route
        $currentVolumeId = null;
        if (request()->routeIs('work-package.detail')) {
            $currentVolumeId = request()->route('volume_id');
        }

        // Mendapatkan year yang sedang aktif untuk expand sidebar
        $activeYear = null;
        $activeWoYear = null;

        if ($currentVolumeId) {
            foreach ($workPackagesByYear as $year => $volumes) {
                foreach ($volumes as $volume) {
                    if ($volume->volume_id == $currentVolumeId) {
                        $activeYear = $year;
                        break 2;
                    }
                }
            }
        }

        if ($currentWoId) {
            foreach ($workOrdersByYear as $year => $workOrders) {
                foreach ($workOrders as $workOrder) {
                    if ($workOrder->wo_id == $currentWoId) {
                        $activeWoYear = $year;
                        break 2;
                    }
                }
            }
        }

        $view->with([
            'workPackagesByYear' => $workPackagesByYear,
            'workOrdersByYear' => $workOrdersByYear,
            'currentVolumeId' => $currentVolumeId,
            'currentWoId' => $currentWoId,
            'activeYear' => $activeYear,
            'activeWoYear' => $activeWoYear
        ]);
    }
}