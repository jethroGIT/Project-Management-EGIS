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
                'guard_name' => 'web',
                'alt_name' => 'Manajer Proyek', 
                'desc' => 'PM',
                'resource_cost' => 2150000.00
            ],
            [
                'name' => 'Senior Consultant', 
                'guard_name' => 'web',
                'alt_name' => 'Ahli Utama', 
                'desc' => 'SC',
                'resource_cost' => 2700000.00
            ],
            [
                'name' => 'Associate Consultant', 
                'guard_name' => 'web',
                'alt_name' => 'Ahli Madya', 
                'desc' => 'ASC',
                'resource_cost' => 2175000.00
            ],
            [
                'name' => 'Junior Consultant', 
                'guard_name' => 'web',
                'alt_name' => 'Ahli Muda', 
                'desc'=> 'JC',
                'resource_cost' => 1700000.00
            ],
            [
                'name' => 'Technical Writer', 
                'guard_name' => 'web',
                'alt_name' => null, 
                'desc' => 'TW',
                'resource_cost' => 800000.00
            ],
            [
                'name' => 'On-Site Consultant', 
                'guard_name' => 'web',
                'alt_name' => null, 
                'desc' => null,
                'resource_cost' => 0.00
            ],
            [
                'name' => 'admin', 
                'guard_name' => 'web',
                'alt_name' => 'administrator', 
                'desc' => null
            ],
            [
                'name' => 'karyawan', 
                'guard_name' => 'web',
                'alt_name' => null, 
                'desc' => 'role umum untuk Project Manager, Senior Consultant, Associate Consultant, 
                            Junior Consultant, Technical Writer, dan On-Site Consultant'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
