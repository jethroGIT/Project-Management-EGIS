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
            // 1
            [
                'name' => 'Oki Jamhur',
                'email' => 'oki123@gmail.com',
                'password' => bcrypt('okij123!'),
                'role' => 'Project Manager',
                'desc' => 'Project Manager dengan pengalaman 10+ tahun',
            ],
            // 2
            [
                'name' => 'Restia Moegiono',
                'email' => 'restia123@gmail.com',
                'password' => bcrypt('rest123!'),
                'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 8+ tahun',
            ],
            // 3
            [
                'name' => 'Yudistira Dwi Wardhana',
                'email' => 'yudistira123@gmail.com',
                'password' => bcrypt('yudi123!'),
                'role' => ['Associate Consultant', 'Senior Consultant'],
                'desc' => 'Consultant dengan pengalaman 5+ tahun',
            ],
            // 4
            [
                'name' => 'Annisa Yuniar',
                'email' => 'annisay123@gmail.com',
                'password' => bcrypt('anny123!'),
                'role' => 'Junior Consultant',
                'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
            ],
            // 5
            [
                'name' => 'Vanika I',
                'email' => 'vanika123@gmail.com',
                'password' => bcrypt('vani123!'),
                'role' => 'Technical Writer',
                'desc' => 'Technical Writer dengan background teknis',
            ],
            // 6
            [
                'name' => 'Wahyu Winarno',
                'email' => 'wahyu123@gmail.com',
                'password' => bcrypt('wahy123!'),
                'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 10+ tahun',
            ],
            // 7
            [
                'name' => 'Nus Primata Nugraheni',
                'email' => 'nusprimata123@gmail.com',
                'password' => bcrypt('nusp123!'),
                'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 12+ tahun',
            ],
            // 8
            [
                'name' => 'Eko Yon Handri',
                'email' => 'ekoyon123@gmail.com',
                'password' => bcrypt('ekoy123!'),
                'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 15+ tahun',
            ],
            // 9
            [
                'name' => 'Indra',
                'email' => 'indra123@gmail.com',
                'password' => bcrypt('indr123!'),
                'role' => 'Associate Consultant',
                'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
            ],
            // 10
            [
                'name' => 'Bayu Samudra',
                'email' => 'bayu123@gmail.com',
                'password' => bcrypt('bayu123!'),
                'role' => 'Junior Consultant',
                'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
            ],
            // 11
            [
                'name' => 'Galuh Dhipa',
                'email' => 'galuhd123@gmail.com',
                'password' => bcrypt('galu123!'),
                'role' => 'Junior Consultant',
                'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
            ],
            // 12
            [
                'name' => 'Decky',
                'email' => 'decky123@gmail.com',
                'password' => bcrypt('deck123!'),
                'role' => 'Technical Writer',
                'desc' => 'Technical Writer dengan background teknis',
            ],
            // 13
            [
                'name' => 'Issa',
                'email' => 'issa123@gmail.com',
                'password' => bcrypt('issa123!'),
                'role' => 'Associate Consultant',
                'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
            ],
            // 14
            [
                'name' => 'Ariya',
                'email' => 'ariya123@gmail.com',
                'password' => bcrypt('ariya123!'),
                'role' => 'Junior Consultant',
                'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
            ],
        ];
        foreach ($workers as $worker) {
            $role = $worker['role'];
            unset($worker['role']);
            $user = User::create($worker);
            $user->assignRole(array_merge(['karyawan'], (array) $role));
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
