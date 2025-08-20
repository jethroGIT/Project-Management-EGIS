<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackage extends Model
{
    protected $table = 'work_package';

    protected $primaryKey = 'wp_id';

    protected $fillable = [
        'category_id',
        'wp_number',
        'name',
        'volume_qty',
        'duration',
        'actual_scope_contract',
        'deliverable',
        // 'completeness',
    ];

    public function wpCategory()
    {
        return $this->belongsTo(WpCategory::class, 'category_id', 'category_id');
    }

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'wp_id', 'wp_id');
    }

    public function workPackageVolumes()
    {
        return $this->hasMany(WorkPackageVolume::class, 'wp_id', 'wp_id');
    }
}
