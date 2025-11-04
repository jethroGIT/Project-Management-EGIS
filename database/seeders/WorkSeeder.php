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
        // $works = [
        //     // 3.1 = 1
        //     [
        //         'user_id' => 1,
        //         'volume_id' => 15,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'user_id' => 2,
        //         'volume_id' => 15,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 3,
        //         'volume_id' => 15,
        //         'role_id' => 3,
        //     ],
        //     [
        //         'user_id' => 4,
        //         'volume_id' => 15,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 5,
        //         'volume_id' => 15,
        //         'role_id' => 5,
        //     ],
        //     // 3.2 =1
        //     [
        //         'user_id' => 1,
        //         'volume_id' => 16,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'user_id' => 2,
        //         'volume_id' => 16,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 3,
        //         'volume_id' => 16,
        //         'role_id' => 3,
        //     ],
        //     // [
        //     //     'user_id' => 4,
        //     //     'volume_id' => 16,
        //     //     'role_id' => 4,
        //     // ],
        //     [
        //         'user_id' => 11,
        //         'volume_id' => 16,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 5,
        //         'volume_id' => 16,
        //         'role_id' => 5,
        //     ],
        //     [
        //         'user_id' => 12,
        //         'volume_id' => 16,
        //         'role_id' => 5,
        //     ],
        //     // 5.2 = 1
        //     [
        //         'user_id' => 1,
        //         'volume_id' => 32,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'user_id' => 8,
        //         'volume_id' => 32,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 3,
        //         'volume_id' => 32,
        //         'role_id' => 3,
        //     ],
        //     [
        //         'user_id' => 4,
        //         'volume_id' => 32,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 5,
        //         'volume_id' => 32,
        //         'role_id' => 5,
        //     ],
        //     [
        //         'user_id' => 12,
        //         'volume_id' => 32,
        //         'role_id' => 5,
        //     ],
        //     // 6.2 = 2
        //     // belum ada data volume 1 (volume_id=4)
        //     [
        //         'user_id' => 1,
        //         'volume_id' => 43,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'user_id' => 3,
        //         'volume_id' => 43,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 6,
        //         'volume_id' => 43,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 13,
        //         'volume_id' => 43,
        //         'role_id' => 3,
        //     ],
        //     [
        //         'user_id' => 11,
        //         'volume_id' => 43,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 5,
        //         'volume_id' => 43,
        //         'role_id' => 5,
        //     ],
        //     [
        //         'user_id' => 12,
        //         'volume_id' => 43,
        //         'role_id' => 5,
        //     ],
        //     // 9.1 = 4
        //     [
        //         'user_id' => 1,
        //         'volume_id' => 59,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'user_id' => 3,
        //         'volume_id' => 59,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'user_id' => 4,
        //         'volume_id' => 59,
        //         'role_id' => 3,
        //     ],
        //     [
        //         'user_id' => 10,
        //         'volume_id' => 59,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 14,
        //         'volume_id' => 59,
        //         'role_id' => 4,
        //     ],
        //     [
        //         'user_id' => 11,
        //         'volume_id' => 59,
        //         'role_id' => 5,
        //     ],
        //     [
        //         'user_id' => 5,
        //         'volume_id' => 59,
        //         'role_id' => 5,
        //     ],
        // ];

        $works = [
            // User ID 1 (Project Manager) ditugaskan ke semua 23 Volume ID
            ['user_id' => 1, 'volume_id' => 1, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 2, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 3, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 4, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 5, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 6, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 7, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 8, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 9, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 10, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 11, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 12, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 13, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 14, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 15, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 16, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 17, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 18, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 19, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 20, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 21, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 22, 'role_id' => 1],
            ['user_id' => 1, 'volume_id' => 23, 'role_id' => 1],

            // User ID 2 (Senior Consultant) ditugaskan ke semua 23 Volume ID
            ['user_id' => 2, 'volume_id' => 1, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 2, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 3, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 4, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 5, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 6, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 7, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 8, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 9, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 10, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 11, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 12, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 13, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 14, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 15, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 16, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 17, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 18, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 19, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 20, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 21, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 22, 'role_id' => 2],
            ['user_id' => 2, 'volume_id' => 23, 'role_id' => 2],

            // User ID 3 (Associate Consultant) ditugaskan ke semua 23 Volume ID
            ['user_id' => 3, 'volume_id' => 1, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 2, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 3, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 4, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 5, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 6, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 7, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 8, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 9, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 10, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 11, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 12, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 13, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 14, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 15, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 16, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 17, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 18, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 19, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 20, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 21, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 22, 'role_id' => 3],
            ['user_id' => 3, 'volume_id' => 23, 'role_id' => 3],

            // User ID 4 (Junior Consultant) ditugaskan ke semua 23 Volume ID
            ['user_id' => 4, 'volume_id' => 1, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 2, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 3, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 4, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 5, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 6, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 7, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 8, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 9, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 10, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 11, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 12, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 13, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 14, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 15, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 16, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 17, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 18, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 19, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 20, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 21, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 22, 'role_id' => 4],
            ['user_id' => 4, 'volume_id' => 23, 'role_id' => 4],

            // User ID 5 (Technical Writer) ditugaskan ke semua 23 Volume ID
            ['user_id' => 5, 'volume_id' => 1, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 2, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 3, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 4, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 5, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 6, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 7, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 8, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 9, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 10, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 11, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 12, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 13, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 14, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 15, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 16, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 17, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 18, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 19, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 20, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 21, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 22, 'role_id' => 5],
            ['user_id' => 5, 'volume_id' => 23, 'role_id' => 5],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}
