<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackageVolume extends Model
{
    protected $table = 'trs_workPackVolume';

    protected $primaryKey = 'volume_id';

    protected $fillable = [
        'workPackage_id',
        'volumeNumber',
        'executionYear',
        'workOrder_id',
        'startDate',
        'endDate',
    ];

    public function task()
    {
        return $this->hasMany(Task::class, 'volume_id', 'volume_id');
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'volume_id', 'volume_id');
    }

    public function work()
    {
        return $this->hasMany(Work::class, 'volume_id', 'volume_id');
    }

    public function workPackage()
    {
        return $this->belongsTo(WorkPackage::class, 'workPackage_id', 'workPackage_id');
    }

    // Untuk akses user langsung
    public function users()
    {
        return $this->hasManyThrough(User::class, Work::class, 'volume_id', 'user_id', 'volume_id', 'user_id');
    }

    public function workOrder()
    {
        return $this->belongsTo(WorkOrder::class, 'workOrder_id', 'workOrder_id');
    }
}
