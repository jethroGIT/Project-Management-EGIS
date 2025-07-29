<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;

class TimesheetManagementController extends Controller
{
    public function index()
    {
        // Ambil semua timesheet
        $timesheets = Timesheet::with(['user.role', 'volume.workPackage'])
            ->orderByRaw('volume_id ASC, execution_date ASC')
            ->get();
        
        $groupedTimesheets = $timesheets->groupBy(function($item) {
            return $item->volume_id . '|' . $item->execution_date;
        });

        $groupedByWP = $timesheets->groupBy(function($ts){
            $wp = optional($ts->volume->workPackage);
            return $wp->wp_number . '|' . $wp->name;
        });

        // Ambil semua user unique di timesheet untuk semua bulan
        $users = User::whereHas('timesheets')->get();

        return view('timesheet_management', compact('timesheets', 'groupedTimesheets', 'groupedByWP', 'users'));
    }
}
