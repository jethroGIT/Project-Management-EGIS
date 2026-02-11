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
                'altName' => 'Manajer Proyek', 
                'desc' => 'PM',
                'resourceCost' => 2150000.00
            ],
            [
                'name' => 'Senior Consultant', 
                'guard_name' => 'web',
                'altName' => 'Ahli Utama', 
                'desc' => 'SC',
                'resourceCost' => 2700000.00
            ],
            [
                'name' => 'Associate Consultant', 
                'guard_name' => 'web',
                'altName' => 'Ahli Madya', 
                'desc' => 'ASC',
                'resourceCost' => 2175000.00
            ],
            [
                'name' => 'Junior Consultant', 
                'guard_name' => 'web',
                'altName' => 'Ahli Muda', 
                'desc'=> 'JC',
                'resourceCost' => 1700000.00
            ],
            [
                'name' => 'Technical Writer', 
                'guard_name' => 'web',
                'altName' => '', 
                'desc' => 'TW',
                'resourceCost' => 800000.00
            ],
            [
                'name' => 'On-Site Consultant', 
                'guard_name' => 'web',
                'altName' => '', 
                'desc' => '',
                'resourceCost' => 0.00
            ],
            [
                'name' => 'admin', 
                'guard_name' => 'web',
                'altName' => 'administrator', 
                'desc' => ''
            ],
            [
                'name' => 'karyawan', 
                'guard_name' => 'web',
                'altName' => '', 
                'desc' => 'role umum untuk Project Manager, Senior Consultant, Associate Consultant, 
                            Junior Consultant, Technical Writer, dan On-Site Consultant'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
