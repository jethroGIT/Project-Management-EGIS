<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'desc',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class, 'user_id', 'user_id');
    }

    public function work()
    {
        return $this->hasMany(Work::class, 'user_id', 'user_id');
    }

    /**
     * Helper method untuk mendapatkan role utama
     */
    public function getPrimaryRoleAttribute()
    {
        $roles = $this->getRoleNames();

        if ($roles->contains('admin')) {
            return 'admin';
        }

        $primaryRole = $roles->filter(function ($roleName) {
            return !in_array($roleName, ['karyawan', 'admin']);
        })->first();

        return $primaryRole ?? 'karyawan';
    }

    /**
     * Helper method untuk mendapatkan role Id
     */
    public function getPrimaryRoleIdAttribute()
    {
        $primaryRoleName = $this->primary_role;
        return $this->roles()->where('name', $primaryRoleName)->first()?->role_id;
    }
}
