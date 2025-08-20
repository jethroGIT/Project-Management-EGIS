<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackageVolume extends Model
{
    protected $table = 'work_package_volume';

    protected $primaryKey = 'volume_id';

    protected $fillable = [
        'wp_id',
        'volume_number',
        'execution_year',
        // 'completeness',
        'start_date',
        'end_date',
    ];

    public function task()
    {
        return $this->hasMany(Task::class, 'volume_id', 'volume_id');
    }
    public function timesheets()
    {
        return $this->hasMany(Task::class, 'volume_id', 'volume_id');
    }
    public function work(){
        return $this->hasMany(Work::class, 'volume_id', 'volume_id');
    }
    public function workPackage() 
    {
        return $this->belongsTo(WorkPackage::class, 'wp_id', 'wp_id');
    }
    
    // Untuk akses user langsung
    public function users()
    {
        return $this->hasManyThrough(User::class, Work::class, 'volume_id', 'user_id', 'volume_id', 'user_id');
    }
}
