<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workers =[
            [
                'name' => 'Oki Jamhur',
                'email' => 'oki123@gmail.com',
                'password' => bcrypt('okij123!'),
                // 'role' => 'Project Manager',
                'desc' => 'Project Manager dengan pengalaman 10+ tahun',
            ],
            [
                'name' => 'Restia',
                'email' => 'restia123@gmail.com',
                'password' => bcrypt('rest123!'),
                // 'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 8+ tahun',
            ],
            [
                'name' => 'Yudis',
                'email' => 'yudis123@gmail.com',
                'password' => bcrypt('yudi123!'),
                // 'role' => 'Associate Consultant',
                'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
            ],
            [
                'name' => 'Annisa Y',
                'email' => 'annisay123@gmail.com',
                'password' => bcrypt('anny123!'),
                // 'role' => 'Junior Consultant',
                'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
            ],
            [
                'name' => 'Vanika',
                'email' => 'vanika123@gmail.com',
                'password' => bcrypt('vani123!'),
                // 'role' => 'Technical Writer',
                'desc' => 'Technical Writer dengan background teknis',
            ],
        ];

        foreach ($workers as $worker) {
            // $role = $worker['role'];
            // unset($worker['role']);
            $worker = User::create($worker);
            // $worker->assignRole(['karyawan',$role]);
            $worker->assignRole('karyawan');
        };

        $admin= User::create([
            'name' => 'Aiman',
            'email' => 'aiman123@gmail.com',
            'password' => bcrypt('aima123!'),
            'desc' => 'Administrasi',
        ]);
        $admin->assignRole('admin');
    }
}
