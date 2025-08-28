<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use App\Models\WorkPackage;
use App\Models\WorkPackageVolume;
use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(){
        $workPackages = WorkPackage::with(['workPackageVolumes.workOrder', 'workPackageVolumes', 'wpCategory'])
            ->orderBy('wp_id', 'asc')
            ->get();
        return view('work_order', compact('workPackages'));
    }
}
