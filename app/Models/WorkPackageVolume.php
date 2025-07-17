<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackageVolume extends Model
{
    protected $table = 'work_package_volume';

    protected $primaryKey = 'volume_id';

    protected $fillable = [
        'volume_number',
        'execution_year',
        'completeness',
        'start_date',
        'end_date',
    ];

    public function task()
    {
        return $this->hasMany(Task::class, 'volume_id', 'volume_id');
    }
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'volume_id', 'volume_id');
    }
}
