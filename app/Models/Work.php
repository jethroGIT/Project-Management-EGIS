<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $table = 'work';

    protected $primaryKey = 'work_id';

    protected $fillable = [
        // 'mandays_realization',
        'resource_cost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
