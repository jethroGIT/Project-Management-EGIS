<?php

namespace Database\Seeders;

use App\Models\WorkPackageVolume;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkPackageVolumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workpackagevolumes = [
            // 3.1 = 1
            // 1
            [
                'wp_id' => 8,
                'volume_number' => 1,
                'execution_year' => 2025,
                'wo_id' => 8,
                'start_date' => '2025-02-10',
                'end_date' => '2025-07-21',
            ],
            // 3.2 = 1
            // 2
            [
                'wp_id' => 9,
                'volume_number' => 1,
                'execution_year' => 2025,
                'wo_id' => 9,
                'start_date' => '2025-05-05',
                'end_date' => '2025-07-21',
            ],
            // 5.2 = 1
            // 3
            [
                'wp_id' => 18,
                'volume_number' => 1,
                'execution_year' => 2025,
                'wo_id' => 10,
                'start_date' => '2024-03-03',
                'end_date' => '2024-07-23',
            ],
            // 6.2 = 2
            // 4
            [
                'wp_id' => 25,
                'volume_number' => 1,
                'execution_year' => 2024,
                'wo_id' => 1,
                'start_date' => null,
                'end_date' => null,
            ],
            // 5
            [
                'wp_id' => 25,
                'volume_number' => 2,
                'execution_year' => 2025,
                'wo_id' => 7,
                'start_date' => '2025-03-04',
                'end_date' => '2025-08-20',
            ],
            // 9.1 = 4
            // 6
            [
                'wp_id' => 33,
                'volume_number' => 1,
                'execution_year' => 2025,
                'wo_id' => 11,
                'start_date' => '2025-03-04',
                'end_date' => '2025-08-13',
            ],
            // 7
            [
                'wp_id' => 33,
                'volume_number' => 2,
                'execution_year' => 2025,
                'wo_id' => 14,
                'start_date' => null,
                'end_date' => null,
            ],
            // 8
            [
                'wp_id' => 33,
                'volume_number' => 3,
                'execution_year' => null,
                'wo_id' => null,
                'start_date' => null,
                'end_date' => null,
            ],
            // 9
            [
                'wp_id' => 33,
                'volume_number' => 4,
                'execution_year' => null,
                'wo_id' => null,
                'start_date' => null,
                'end_date' => null,
            ],
        ];

        foreach ($workpackagevolumes as $workpackagevolume) {
            WorkPackageVolume::create($workpackagevolume);
        };
    }
}

