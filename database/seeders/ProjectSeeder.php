<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Project EGIS',
                'totalBudget' => 12704350000, // Rp 12.704.350.000
                'description' => 'Proyek EGIS (Enterprise Governance Information Security)'
            ]
        ];
        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
