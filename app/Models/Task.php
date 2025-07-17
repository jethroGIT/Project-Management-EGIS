<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    protected $primaryKey = 'task_id';

    protected $fillable = [
        'name',
        // 'completeness',
        'status',
    ];

    public function subTask()
    {
        return $this->hasMany(SubTask::class, 'task_id', 'task_id');
    }
}
