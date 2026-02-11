<?php

namespace App\Http\Controllers;

use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class WorkPackagesListController extends Controller
{
    public function index(){
        $workPackages = WorkPackage::with(['workPackageVolumes' => function($query) {
            $query->whereNull('workOrder_id');
        },'wpCategory', 'humanResources.role'])->get();

        // Filter hanya WP yang punya volume belum ber-WO
        $workPackages = $workPackages->filter(function($wp) {
            return $wp->workPackageVolumes->count() > 0;
        })->sortBy(function($wp) {
            // Pastikan urutan numerik, misal 1.1, 1.2, 2.1, dst
            return floatval($wp->workPack_number);
        })
        ->values();

        $countWPs = $workPackages->count();
        return view('workpackages_list', compact('workPackages', 'countWPs'));
    }
}
