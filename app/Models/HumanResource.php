<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResource extends Model
{
    protected $table = 'human_resource';

    protected $primaryKey = 'hresource_id';

    protected $fillable = [
        'jtk',
        'jhk',
    ];
}
