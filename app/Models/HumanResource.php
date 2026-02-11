<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    protected $table = 'trs_humanResource';

    protected $primaryKey = 'hresource_id';

    protected $fillable = [
        'workPackage_id',
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
        return $this->belongsTo(WorkPackage::class, 'workPackage_id', 'workPackage_id');
    }
}
