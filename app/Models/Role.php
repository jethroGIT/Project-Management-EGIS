<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    protected $table = 'mst_roles';

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'name',
        'guard_name',
        'altName',
        'desc',
        'resourceCost',
    ];

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'role_id', 'role_id');
    }
}
