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

        $view->with('workPackagesByYear', $workPackagesByYear);
    }
}