<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WpCategory extends Model
{
    protected $table = 'trs_category';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'project_id',
        'categoryNumber',
        'name',
    ];

    public function workPackage()
    {
        return $this->hasMany(WorkPackage::class, 'category_id', 'category_id');
    }
}
