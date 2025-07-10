<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'name',
        'alt_name',
        'desc',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'role_id', 'role_id');
    }
}
