<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $table = 'sub_task';

    protected $primaryKey = 'sub_task_id';

    protected $fillable = [
        'task_id',
        'name',
        'completeness',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
}
