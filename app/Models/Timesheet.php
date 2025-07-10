<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table = 'timesheet';

    protected $primaryKey = 'timesheet_id';

    protected $fillable = [
        'execution_date',
        'activity',
    ];
}
