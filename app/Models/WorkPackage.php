<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackage extends Model
{
    protected $table = 'work_package';

    protected $primaryKey = 'wp_id';

    protected $fillable = [
        'wp_number',
        'name',
        'volume_qty',
        'duration',
        'actual_scope_contract',
        'deliverable',
        // 'completeness',
    ];

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'wp_id', 'wp_id');
    }

    public function workPackageVolumes()
    {
        return $this->hasMany(WorkPackageVolume::class, 'wp_id', 'wp_id');
    }
}
