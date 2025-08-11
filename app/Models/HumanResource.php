<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    protected $table = 'human_resource';

    protected $primaryKey = 'hresource_id';

    protected $fillable = [
        'wp_id',
        'role_id',
        'jtk',
        'jhk',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function workPackage()
    {
        return $this->belongsTo(WorkPackage::class, 'wp_id', 'wp_id');
    }
}
