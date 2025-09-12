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
            [
                'wp_id' => 1,
                'volume_number' => 1,
                'execution_year' => 2024,
                'wo_id' => null,
                // 3
                // 'completeness' => 100.00,
                'start_date' => '2024-03-01',
                'end_date' => '2024-11-10',
            ],
            [
                'wp_id' => 2,
                'volume_number' => 1,
                'execution_year' => 2024,
                'wo_id' => 1,
                // 1
                // 'completeness' => 23.44,
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-10',
            ],
            [
                'wp_id' => 2,
                'volume_number' => 2,
                'execution_year' => 2025,
                'wo_id' => null,
                // 2
                // 'completeness' => 23.44,
                'start_date' => '2025-07-01',
                'end_date' => '2025-12-10',
            ],
        ];

        foreach ($workpackagevolumes as $workpackagevolume) {
            WorkPackageVolume::create($workpackagevolume);
        };
    }
}

