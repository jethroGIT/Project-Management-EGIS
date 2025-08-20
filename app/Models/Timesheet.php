<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $table = 'timesheet';

    protected $primaryKey = 'timesheet_id';

    protected $fillable = [
        'user_id',
        'volume_id',
        'execution_date',
        'activity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function volume()
    {
        return $this->belongsTo(WorkPackageVolume::class, 'volume_id', 'volume_id');
    }

}
