<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'mst_projects';
    protected $primaryKey = 'project_id';

    protected $fillable = [
        'name',
        'totalBudget',
        'description',
    ];

    protected $casts = [
        'totalBudget' => 'decimal:2',
    ];

    /**
     * Helper method untuk get project budget by name
     */
    public static function getBudgetByName($projectName)
    {
        $project = static::where('name', $projectName)->first();
        return $project ? $project->totalBudget : 0;
    }

    /**
     * Get formatted budget value untuk display
     */
    public function getFormattedBudget()
    {
        return 'Rp' . number_format($this->totalBudget, 0, ',', '.');
    }
}
