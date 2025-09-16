<?php

namespace Database\Seeders;

use App\Models\HumanResource;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HumanResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hresources =[
            // 3.1 = 8
            [
                'role_id' => 1,
                'wp_id' => 8,
                'jtk' => 1,
                'jhk' => 4,
            ],
            [
                'role_id' => 2,
                'wp_id' => 8,
                'jtk' => 1,
                'jhk' => 10,
            ],
            [
                'role_id' => 3,
                'wp_id' => 8,
                'jtk' => 1,
                'jhk' => 10,
            ],
            [
                'role_id' => 4,
                'wp_id' => 8,
                'jtk' => 1,
                'jhk' => 4,
            ],
            [
                'role_id' => 5,
                'wp_id' => 8,
                'jtk' => 1,
                'jhk' => 20,
            ],
            // 3.2 = 9
            [
                'role_id' => 1,
                'wp_id' => 9,
                'jtk' => 1,
                'jhk' => 6,
            ],
            [
                'role_id' => 2,
                'wp_id' => 9,
                'jtk' => 1,
                'jhk' => 15,
            ],
            [
                'role_id' => 3,
                'wp_id' => 9,
                'jtk' => 1,
                'jhk' => 15,
            ],
            [
                'role_id' => 4,
                'wp_id' => 9,
                'jtk' => 1,
                'jhk' => 4,
            ],
            [
                'role_id' => 5,
                'wp_id' => 9,
                'jtk' => 1, // aktualnya 2
                'jhk' => 30,
            ],
            // 5.2 = 18
            [
                'role_id' => 1,
                'wp_id' => 18,
                'jtk' => 1,
                'jhk' => 17,
            ],
            [
                'role_id' => 2,
                'wp_id' => 18,
                'jtk' => 1,
                'jhk' => 17,
            ],
            [
                'role_id' => 3,
                'wp_id' => 18,
                'jtk' => 1,
                'jhk' => 34,
            ],
            [
                'role_id' => 4,
                'wp_id' => 18,
                'jtk' => 1,
                'jhk' => 17,
            ],
            [
                'role_id' => 5,
                'wp_id' => 18,
                'jtk' => 2,
                'jhk' => 17,
            ],  
            // 6.2 = 25
            [
                'role_id' => 1,
                'wp_id' => 25,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 2,
                'wp_id' => 25,
                'jtk' => 1, //aktualnya 2
                'jhk' => 20,
            ],
            [
                'role_id' => 3,
                'wp_id' => 25,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 4,
                'wp_id' => 25,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 5,
                'wp_id' => 25,
                'jtk' => 1, //aktualnya 2
                'jhk' => 20,
            ],
            // 9.1 = 33
            [
                'role_id' => 1,
                'wp_id' => 33,
                'jtk' => 1,
                'jhk' => 26,
            ],
            [
                'role_id' => 2,
                'wp_id' => 33,
                'jtk' => 1,
                'jhk' => 30,
            ],
            [
                'role_id' => 3,
                'wp_id' => 33,
                'jtk' => 1,
                'jhk' => 30,
            ],
            [
                'role_id' => 4,
                'wp_id' => 33,
                'jtk' => 2,
                'jhk' => 40,
            ],
            [
                'role_id' => 5,
                'wp_id' => 33,
                'jtk' => 2,
                'jhk' => 40,
            ],
        ];

        foreach ($hresources as $hresource) {
            HumanResource::create($hresource);
        };
    }
}
