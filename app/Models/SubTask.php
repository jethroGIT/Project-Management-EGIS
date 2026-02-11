<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    protected $table = 'trs_subTask';

    protected $primaryKey = 'subTask_id';

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'name',
        'completeness',
        'trs_subTaskcol',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }
}
