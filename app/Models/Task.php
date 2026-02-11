<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'mst_task';

    protected $primaryKey = 'task_id';

    protected $fillable = [
        'volume_id',
        'name',
        'completeness',
        'status',
    ];

    public function subTask()
    {
        return $this->hasMany(SubTask::class, 'task_id', 'task_id');
    }
}
