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
            // 1.1
            [
                'wp_id' => 1,'volume_number' => 1,
                'execution_year' => 2024,'wo_id' => null,
                'start_date' =>'2024-01-13','end_date' => '2024-06-21',
                // 'execution_year' => null,'wo_id' => null,
                // 'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 1,'volume_number' => 2,
                'execution_year' => 2025,'wo_id' => null,
                'start_date' => '2025-01-01','end_date' => '2025-12-31',
                // 'execution_year' => null,'wo_id' => null,
                // 'start_date' => null,'end_date' => null,
            ],
            // 1.2
            [
                'wp_id' => 2,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 2,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 2.1
            [
                'wp_id' => 3,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 3,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 2.2
            [
                'wp_id' => 4,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 4,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 2.3
            [
                'wp_id' => 5,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 5,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 2.4
            [
                'wp_id' => 6,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 6,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 2.5
            [
                'wp_id' => 7,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 7,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 3.1 = 1
            [
                'wp_id' => 8,'volume_number' => 1,
                'execution_year' => 2025,'wo_id' => 8,
                'start_date' => '2025-03-03','end_date' => '2025-05-30',
                // 'start_date' => '2025-02-10','end_date' => '2025-07-21',
            ],
            // 3.2 = 1
            [
                'wp_id' => 9,'volume_number' => 1,
                'execution_year' => 2025,'wo_id' => 9,
                'start_date' => '2025-03-03','end_date' => '2025-07-25',
                // 'start_date' => '2025-05-05','end_date' => '2025-07-21',
            ],
            // 3.3
            [
                'wp_id' => 10,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 3.4
            [
                'wp_id' => 11,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 3.5
            [
                'wp_id' => 12,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 12,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 4.1
            [
                'wp_id' => 13,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 4.2
            [
                'wp_id' => 14,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 14,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 14,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 4.3
            [
                'wp_id' => 15,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 15,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 15,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 4.4
            [
                'wp_id' => 16,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 16,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 16,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 5.1
            [
                'wp_id' => 17,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 5.2 = 1
            [
                'wp_id' => 18,'volume_number' => 1,
                'execution_year' => 2025,'wo_id' => 10,
                'start_date' => '2025-03-03','end_date' => '2025-12-19',
                // 'start_date' => '2024-03-03','end_date' => '2024-07-23',
            ],
            // 5.3
            [
                'wp_id' => 19,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 5.4
            [
                'wp_id' => 20,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 5.5
            [
                'wp_id' => 21,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 21,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 5.6
            [
                'wp_id' => 22,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 22,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 5.7
            [
                'wp_id' => 23,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 23,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 6.1
            [
                'wp_id' => 24,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 6.2 = 2
            [
                'wp_id' => 25,'volume_number' => 1,
                'execution_year' => 2024,'wo_id' => 1,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 25,'volume_number' => 2,
                'execution_year' => 2025,'wo_id' => 7,
                'start_date' => '2025-03-03','end_date' => '2025-11-28',
                // 'start_date' => '2025-03-04','end_date' => '2025-10-15',
            ],

            // 7.1
            [
                'wp_id' => 26,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 26,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 26,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 7.2
            [
                'wp_id' => 27,'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 27,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 27,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 27,'volume_number' => 4,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 27,'volume_number' => 5,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 8.1
            [
                'wp_id' => 28, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 8.2
            [
                'wp_id' => 29, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 8.3
            [
                'wp_id' => 30, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 8.4
            [
                'wp_id' => 31, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 8.5
            [
                'wp_id' => 32, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 32, 'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 32, 'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 9.1 = 4
            [
                'wp_id' => 33,'volume_number' => 1,
                'execution_year' => 2025,'wo_id' => 11,
                'start_date' => '2025-03-03','end_date' => '2025-12-19',
                // 'start_date' => '2025-03-04','end_date' => '2025-11-01',
            ],
            [
                'wp_id' => 33,'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 33,'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 33,'volume_number' => 4,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 9.2
            [
                'wp_id' => 34, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 34, 'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 34, 'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 9.3
            [
                'wp_id' => 35, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 35, 'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 35, 'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            // 9.4
            [
                'wp_id' => 36, 'volume_number' => 1,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 36, 'volume_number' => 2,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],
            [
                'wp_id' => 36, 'volume_number' => 3,
                'execution_year' => null,'wo_id' => null,
                'start_date' => null,'end_date' => null,
            ],

            // 10.1
            ['wp_id' => 37, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 2,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 3,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 4,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 5,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 6,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 7,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 8,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 9,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 37, 'volume_number' => 10,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 11,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 12,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 13,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 14,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 15,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 16,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 17,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 18,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 19,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 20,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 21,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 22,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 23,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 24,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 25,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 26,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 27,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 28,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 29,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 30,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 31,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 32,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 33,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 34,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 35,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 37, 'volume_number' => 36,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            // 10.2
            ['wp_id' => 38, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 2,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 3,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 4,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 5,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 6,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 7,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 8,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 9,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 38, 'volume_number' => 10,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 11,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 12,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 13,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 14,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 15,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 16,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 17,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 38, 'volume_number' => 18,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],

            // 11.1
            ['wp_id' => 39, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            // 11.2
            ['wp_id' => 40, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 2,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 3,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 4,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 5,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 6,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 7,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 8,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 9,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 40, 'volume_number' => 10,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 40, 'volume_number' => 11,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 40, 'volume_number' => 12,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            // 11.3
            ['wp_id' => 41, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 2,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 3,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 4,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 5,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 6,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 7,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 8,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 9,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 41, 'volume_number' => 10,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 11,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 12,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 13,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 14,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 15,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 16,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 17,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 18,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 19,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 20,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 21,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 22,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 23,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 24,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 25,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 26,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 27,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 28,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 29,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 30,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 31,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 32,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 33,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 34,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 35,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 36,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 41,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 38,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 39,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 41, 'volume_number' => 40,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            // 11.4
            ['wp_id' => 42, 'volume_number' => 1,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 2,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 3,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 4,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 5,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 6,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 7,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 8,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 9,'execution_year' => null,'wo_id' => null,'start_date' => null,'end_date' => null],
            ['wp_id' => 42, 'volume_number' => 10,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 11,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 12,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 13,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 14,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 15,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 16,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 17,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 18,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 19,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 20,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 21,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 22,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 23,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 24,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 25,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 26,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 27,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 28,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 29,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
            ['wp_id' => 42, 'volume_number' => 30,'execution_year'=>null,'wo_id'=>null,'start_date'=>null,'end_date'=>null],
        ];

        foreach ($workpackagevolumes as $workpackagevolume) {
            WorkPackageVolume::create($workpackagevolume);
        };
    }
}

