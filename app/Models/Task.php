<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    protected $primaryKey = 'task_id';

    protected $fillable = [
        'volume_id',
        'name',
        // 'completeness',
        'status',
        'order_index'
    ];

    // Default ordering by order_index
    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('order_index')->orderBy('task_id');
        });
    }

    public function subTask()
    {
        return $this->hasMany(SubTask::class, 'task_id', 'task_id');
    }
}
