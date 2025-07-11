<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';

    protected $primaryKey = 'resource_id';

    protected $fillable = [
        'jtk',
        'jhk',
    ];
}
