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
            // 3.1
            [
                'role_id' => 1,
                'wp_id' => 1,
                'jtk' => 1,
                'jhk' => 4,
            ],
            [
                'role_id' => 2,
                'wp_id' => 1,
                'jtk' => 1,
                'jhk' => 10,
            ],
            [
                'role_id' => 3,
                'wp_id' => 1,
                'jtk' => 1,
                'jhk' => 10,
            ],
            [
                'role_id' => 4,
                'wp_id' => 1,
                'jtk' => 1,
                'jhk' => 4,
            ],
            [
                'role_id' => 5,
                'wp_id' => 1,
                'jtk' => 1,
                'jhk' => 20,
            ],
            // 6.2
            [
                'role_id' => 1,
                'wp_id' => 2,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 2,
                'wp_id' => 2,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 3,
                'wp_id' => 2,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 4,
                'wp_id' => 2,
                'jtk' => 1,
                'jhk' => 20,
            ],
            [
                'role_id' => 5,
                'wp_id' => 2,
                'jtk' => 1,
                'jhk' => 20,
            ],
        ];

        foreach ($hresources as $hresource) {
            HumanResource::create($hresource);
        };
    }
}
