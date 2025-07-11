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
            ['name' => 'Project Manager', 'alt_name' => 'Manajer Proyek', 'desc' => 'PM'],
            ['name' => 'Senior Consultant', 'alt_name' => 'Ahli Utama', 'desc' => 'SC'],
            ['name' => 'Associate Consultant', 'alt_name' => 'Ahli Madya', 'desc' => 'ASC'],
            ['name' => 'Junior Consultant', 'alt_name' => 'Ahli Muda', 'desc'=> 'JC'],
            ['name' => 'Technical Writer', 'alt_name' => null, 'desc' => 'TW'],
            ['name' => 'On-Site Consultant', 'alt_name' => null, 'desc' => null],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
