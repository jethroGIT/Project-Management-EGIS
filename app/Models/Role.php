<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // protected $table = 'role';

    // protected $primaryKey = 'role_id';

    protected $fillable = [
        'name',
        'guard_name',
        'alt_name',
        'desc',
        'resource_cost',
    ];

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id', 'role_id');
    // }

    public function humanResources()
    {
        return $this->hasMany(HumanResource::class, 'role_id', 'id');
    }
}
