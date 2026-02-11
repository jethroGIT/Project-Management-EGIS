<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $table = 'mst_permissions';

    protected $primaryKey = 'permission_id';

    protected $fillable = [
        'name',
        'guard_name',
    ];
}
