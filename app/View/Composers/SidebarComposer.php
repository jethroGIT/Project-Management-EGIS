<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\WorkOrder;
use App\Models\WorkPackageVolume;

class SidebarComposer
{
    public function compose(View $view)
    {
        $user = auth()->user();
        $isKaryawan = $user && method_exists($user, 'hasRole') && $user->hasRole('karyawan');
        $userId = $user->user_id ?? null;

        $workOrdersQuery = WorkOrder::with([
            'workPackageVolumes' => function ($query) use ($isKaryawan, $userId) {
                $query->with('workPackage')
                    ->whereNotNull('startDate')
                    ->whereNotNull('endDate')
                    ->whereNotNull('executionYear');
                if ($isKaryawan && $userId) {
                    // Hanya volume yang dikerjakan user (dari tabel work)
                    $query->whereHas('work', function ($w) use ($userId) {
                        $w->where('work.user_id', $userId);
                    });
                }
                $query->orderBy('volumeNumber');
            }
        ])
        ->whereHas('workPackageVolumes', function ($query) use ($isKaryawan, $userId) {
            $query->whereNotNull('startDate')
                ->whereNotNull('endDate')
                ->whereNotNull('executionYear');
            if ($isKaryawan && $userId) {
                $query->whereHas('work', function ($w) use ($userId) {
                    $w->where('work.user_id', $userId);
                });
            }
        })
        ->orderBy('workNumber_id');

        $workOrdersByYear = $workOrdersQuery->get()
            ->groupBy(function($workOrder) {
                $firstVolume = $workOrder->workPackageVolumes->first();
                return $firstVolume ? $firstVolume->executionYear : 'Unknown';
            });

        $workPackagesByYear = WorkPackageVolume::with('workPackage')
            ->whereNotNull('startDate')
            ->whereNotNull('endDate')
            ->whereNotNull('executionYear')
            ->orderBy('executionYear')
            ->orderBy('volumeNumber')
            ->get()
            ->groupBy('executionYear');

        // Mendapatkan workOrder_id yang sedang aktif dari route
        $currentWoId = null;
        if (request()->routeIs('wo.content-list')) {
            $currentWoId = request()->route('workOrder_id');
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
                    if ($workOrder->workOrder_id == $currentWoId) {
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