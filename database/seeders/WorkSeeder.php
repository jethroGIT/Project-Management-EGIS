<?php

namespace Database\Seeders;

use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $works = [
            // 3.1 = 1
            [
                'user_id' => 1,
                'volume_id' => 1,
                'role_id' => 1,
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'role_id' => 2,
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'role_id' => 3,
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'role_id' => 4,
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'role_id' => 5,
            ],
            // 3.2 =1
            [
                'user_id' => 1,
                'volume_id' => 2,
                'role_id' => 1,
            ],
            [
                'user_id' => 2,
                'volume_id' => 2,
                'role_id' => 2,
            ],
            [
                'user_id' => 3,
                'volume_id' => 2,
                'role_id' => 3,
            ],
            // [
            //     'user_id' => 4,
            //     'volume_id' => 2,
            //     'role_id' => 4,
            // ],
            [
                'user_id' => 11,
                'volume_id' => 2,
                'role_id' => 4,
            ],
            [
                'user_id' => 5,
                'volume_id' => 2,
                'role_id' => 5,
            ],
            [
                'user_id' => 12,
                'volume_id' => 2,
                'role_id' => 5,
            ],
            // 5.2 = 1
            [
                'user_id' => 1,
                'volume_id' => 3,
                'role_id' => 1,
            ],
            [
                'user_id' => 8,
                'volume_id' => 3,
                'role_id' => 2,
            ],
            [
                'user_id' => 3,
                'volume_id' => 3,
                'role_id' => 3,
            ],
            [
                'user_id' => 4,
                'volume_id' => 3,
                'role_id' => 4,
            ],
            [
                'user_id' => 5,
                'volume_id' => 3,
                'role_id' => 5,
            ],
            [
                'user_id' => 12,
                'volume_id' => 3,
                'role_id' => 5,
            ],
            // 6.2 = 2
            // belum ada data volume 1 (volume_id=4)
            [
                'user_id' => 1,
                'volume_id' => 5,
                'role_id' => 1,
            ],
            [
                'user_id' => 3,
                'volume_id' => 5,
                'role_id' => 2,
            ],
            [
                'user_id' => 6,
                'volume_id' => 5,
                'role_id' => 2,
            ],
            [
                'user_id' => 13,
                'volume_id' => 5,
                'role_id' => 3,
            ],
            [
                'user_id' => 11,
                'volume_id' => 5,
                'role_id' => 4,
            ],
            [
                'user_id' => 5,
                'volume_id' => 5,
                'role_id' => 5,
            ],
            [
                'user_id' => 12,
                'volume_id' => 5,
                'role_id' => 5,
            ],
            // 9.1 = 4
            [
                'user_id' => 1,
                'volume_id' => 6,
                'role_id' => 1,
            ],
            [
                'user_id' => 3,
                'volume_id' => 6,
                'role_id' => 2,
            ],
            [
                'user_id' => 4,
                'volume_id' => 6,
                'role_id' => 3,
            ],
            [
                'user_id' => 10,
                'volume_id' => 6,
                'role_id' => 4,
            ],
            [
                'user_id' => 14,
                'volume_id' => 6,
                'role_id' => 4,
            ],
            [
                'user_id' => 11,
                'volume_id' => 6,
                'role_id' => 5,
            ],
            [
                'user_id' => 5,
                'volume_id' => 6,
                'role_id' => 5,
            ],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}
