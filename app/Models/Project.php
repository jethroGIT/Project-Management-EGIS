<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'name',
        'total_budget',
        'description'
    ];

    protected $casts = [
        'total_budget'=> 'decimal:2'
    ];

    /**
     * Helper method untuk get project budget by name
     */
    public static function getBudgetByName($projectName)
    {
        $project = static::where('name', $projectName)->first();
        return $project ? $project->total_budget : 0;
    }

    /**
     * Get formatted budget value untuk display
     */
    public function getFormattedBudget()
    {
        return 'Rp' . number_format($this->total_budget, 0, ',', '.');
    }
}
