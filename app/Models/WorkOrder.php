<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'work_order';

    protected $primaryKey = 'wo_id';

    protected $fillable = [
        'wo_number'
    ];

    public function workPackageVolumes()
    {
        return $this->hasMany(WorkPackageVolume::class, 'wo_id', 'wo_id');
    }
}