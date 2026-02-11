<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    protected $table = 'mst_workOrder';

    protected $primaryKey = 'workOrder_id';

    protected $fillable = [
        'workNumber_id',
    ];

    public function workPackageVolumes()
    {
        return $this->hasMany(WorkPackageVolume::class, 'workOrder_id', 'workOrder_id');
    }
}
