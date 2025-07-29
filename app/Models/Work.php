<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'work';

    protected $primaryKey = 'work_id';

    protected $fillable = [
        // 'mandays_realization',
        'role_id',
        'volume_id',
        'resource_cost',
    ];

    public function role()
    {
        return $this->belongsTo(User::class, 'role_id', 'role_id');
    }

    public function volume()
    {
        return $this->belongsTo(WorkPackageVolume::class, 'volume_id', 'volume_id');
    }
}
