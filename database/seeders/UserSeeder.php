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
                'name' => 'Restia Moegiono',
                'email' => 'restia123@gmail.com',
                'password' => bcrypt('rest123!'),
                // 'role' => 'Senior Consultant',
                'desc' => 'Senior Consultant dengan pengalaman 8+ tahun',
            ],
            [
                'name' => 'Yudistira Dwi Wardhana',
                'email' => 'yudistira123@gmail.com',
                'password' => bcrypt('yudi123!'),
                // 'role' => 'Associate Consultant',
                'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
            ],
            [
                'name' => 'Annisa Yuniar',
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
            [
                'name' => 'Wahyu Winarno',
                'email' => 'wahyu123@gmail.com',
                'password' => bcrypt('wahy123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Nus Primata',
                'email' => 'nusprimata123@gmail.com',
                'password' => bcrypt('nusp123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Eko Yon Handri',
                'email' => 'ekoyon123@gmail.com',
                'password' => bcrypt('ekoy123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Indra',
                'email' => 'indra123@gmail.com',
                'password' => bcrypt('indr123!'),
                'role' => 'Associate Consultant',
            ],
            [
                'name' => 'Bayu Samudra',
                'email' => 'bayu123@gmail.com',
                'password' => bcrypt('bayu123!'),
                'role' => 'Junior Consultant',
            ],
            [
                'name' => 'Galuh Dhipa',
                'email' => 'galuhd123@gmail.com',
                'password' => bcrypt('galu123!'),
                'role' => 'Junior Consultant',
            ],
            [
                'name' => 'Decky',
                'email' => 'decky123@gmail.com',
                'password' => bcrypt('deck123!'),
                'role' => 'Technical Writer',
            ],
            [
                'name' => 'Wahyu Winarno',
                'email' => 'wahyu123@gmail.com',
                'password' => bcrypt('wahy123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Nus Primata',
                'email' => 'nusprimata123@gmail.com',
                'password' => bcrypt('nusp123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Eko Yon Handri',
                'email' => 'ekoyon123@gmail.com',
                'password' => bcrypt('ekoy123!'),
                'role' => 'Senior Consultant',
            ],
            [
                'name' => 'Indra',
                'email' => 'indra123@gmail.com',
                'password' => bcrypt('indr123!'),
                'role' => 'Associate Consultant',
            ],
            [
                'name' => 'Bayu Samudra',
                'email' => 'bayu123@gmail.com',
                'password' => bcrypt('bayu123!'),
                'role' => 'Junior Consultant',
            ],
            [
                'name' => 'Galuh Dhipa',
                'email' => 'galuhd123@gmail.com',
                'password' => bcrypt('galu123!'),
                'role' => 'Junior Consultant',
            ],
            [
                'name' => 'Decky',
                'email' => 'decky123@gmail.com',
                'password' => bcrypt('deck123!'),
                'role' => 'Technical Writer',
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
