<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\WorkPackageVolume;

class SidebarComposer
{
    public function compose(View $view)
    {
        $workPackagesByYear = WorkPackageVolume::with('workPackage')
            ->orderBy('execution_year')
            ->orderBy('volume_number')
            ->get()
            ->groupBy('execution_year');
        
        // Mendapatkan volume_id yang sedang aktif dari route
        $currentVolumeId = null;
        if (request()->routeIs('work-package.detail')) {
            $currentVolumeId = request()->route('volume_id');
        }

        // Mendapatkan year yang sedang aktif untuk expand sidebar
        $activeYear = null;
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

        $view->with([
            'workPackagesByYear' => $workPackagesByYear,
            'currentVolumeId' => $currentVolumeId,
            'activeYear' => $activeYear
        ]);
    }
}