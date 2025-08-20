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
                'password' => bcrypt('oki123!'),
                'role' => 'Project Manager',
            ],
            [
                'name' => 'Restia',
                'email' => 'restia123@gmail.com',
                'password' => bcrypt('res123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Yudis',
                'email' => 'yudis123@gmail.com',
                'password' => bcrypt('yud123!'),
                'role' => 'Associate Consultant',
            ],
            [
                'name' => 'Annisa Y',
                'email' => 'annisay123@gmail.com',
                'password' => bcrypt('any123!'),
                'role' => 'Junior Consultant',
            ],
            [
                'name' => 'Vanika',
                'email' => 'vanika123@gmail.com',
                'password' => bcrypt('van123!'),
                'role' => 'Technical Writer',
            ],
        ];

        foreach ($workers as $worker) {
            $role = $worker['role'];
            unset($worker['role']);
            $worker = User::create($worker);
            $worker->assignRole(['karyawan',$role]);
        };

        $admin= User::create([
            'name' => 'Aiman',
            'email' => 'aiman@gmail.com',
            'password' => bcrypt('aim123!'),
        ]);
        $admin->assignRole('admin');
    }
}
