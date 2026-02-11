<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkPackage extends Model
{
    protected $table = 'trs_workPackage';

    protected $primaryKey = 'workPackage_id';

    protected $fillable = [
        'category_id',
        'workPack_number',
        'name',
        'volumeQTY',
        'duration',
        'actualScope',
        'deliverable',
    ];

    public function wpCategory()
    {
        return $this->belongsTo(WpCategory::class, 'category_id', 'category_id');
    }

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'workPackage_id', 'workPackage_id');
    }

    public function workPackageVolumes()
    {
        return $this->hasMany(WorkPackageVolume::class, 'workPackage_id', 'workPackage_id');
    }
}
