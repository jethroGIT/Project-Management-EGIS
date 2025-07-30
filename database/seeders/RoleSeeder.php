<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles =[
            [
                'name' => 'Project Manager', 
                'alt_name' => 
                'Manajer Proyek', 
                'desc' => 'PM',
                'resource_cost' => 2150000.00
            ],
            [
                'name' => 'Senior Consultant', 
                'alt_name' => 'Ahli Utama', 
                'desc' => 'SC',
                'resource_cost' => 2700000.00
            ],
            [
                'name' => 'Associate Consultant', 
                'alt_name' => 'Ahli Madya', 
                'desc' => 'ASC',
                'resource_cost' => 2175000.00
            ],
            [
                'name' => 'Junior Consultant', 
                'alt_name' => 'Ahli Muda', 
                'desc'=> 'JC',
                'resource_cost' => 1700000.00
            ],
            [
                'name' => 'Technical Writer', 
                'alt_name' => null, 
                'desc' => 'TW',
                'resource_cost' => 800000.00
            ],
            [
                'name' => 'On-Site Consultant', 
                'alt_name' => null, 
                'desc' => null,
                'resource_cost' => 0.00
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
