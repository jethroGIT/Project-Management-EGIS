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
        $users =[
            [
                'role_id' => 1,
                'name' => 'Oki Jamhur',
                'email' => 'oki123@gmail.com',
                'password' => bcrypt('oki123!'),
            ],
            [
                'role_id' => 2,
                'name' => 'Restia',
                'email' => 'restia123@gmail.com',
                'password' => bcrypt('res123!'),
            ],
            [
                'role_id' => 3,
                'name' => 'Yudis',
                'email' => 'yudis123@gmail.com',
                'password' => bcrypt('yud123!'),
            ],
            [
                'role_id' => 4,
                'name' => 'Annisa Y',
                'email' => 'annisay123@gmail.com',
                'password' => bcrypt('any123!'),
            ],
            [
                'role_id' => 5,
                'name' => 'Vanika',
                'email' => 'vanika123@gmail.com',
                'password' => bcrypt('van123!'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        };
    }
}
