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
                'workPackage_id' => 1,'volumeNumber' => 1,
                'executionYear' => 2024,'workOrder_id' => 1,
                'startDate' =>'2024-01-13','endDate' => '2024-06-21',
                // 'executionYear' => 2025,'workOrder_id' => 1,
                // 'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 1,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
                // 'executionYear' => 2025,'workOrder_id' => 1,
                // 'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 1.2
            [
                'workPackage_id' => 2,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 2,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 2.1
            [
                'workPackage_id' => 3,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 3,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 2.2
            [
                'workPackage_id' => 4,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 4,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 2.3
            [
                'workPackage_id' => 5,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 5,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 2.4
            [
                'workPackage_id' => 6,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 6,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 2.5
            [
                'workPackage_id' => 7,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 7,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 3.1 = 1
            [
                'workPackage_id' => 8,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 8,
                'startDate' => '2025-03-03','endDate' => '2025-05-30',
                // 'startDate' => '2025-02-10','endDate' => '2025-07-21',
            ],
            // 3.2 = 1
            [
                'workPackage_id' => 9,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 9,
                'startDate' => '2025-03-03','endDate' => '2025-07-25',
                // 'startDate' => '2025-05-05','endDate' => '2025-07-21',
            ],
            // 3.3
            [
                'workPackage_id' => 10,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 3.4
            [
                'workPackage_id' => 11,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 3.5
            [
                'workPackage_id' => 12,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 12,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 4.1
            [
                'workPackage_id' => 13,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 4.2
            [
                'workPackage_id' => 14,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 14,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 14,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 4.3
            [
                'workPackage_id' => 15,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 15,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 15,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 4.4
            [
                'workPackage_id' => 16,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 16,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 16,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 5.1
            [
                'workPackage_id' => 17,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 5.2 = 1
            [
                'workPackage_id' => 18,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 10,
                'startDate' => '2025-03-03','endDate' => '2025-12-19',
                // 'startDate' => '2024-03-03','endDate' => '2024-07-23',
            ],
            // 5.3
            [
                'workPackage_id' => 19,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 5.4
            [
                'workPackage_id' => 20,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 5.5
            [
                'workPackage_id' => 21,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 21,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 5.6
            [
                'workPackage_id' => 22,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 22,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 5.7
            [
                'workPackage_id' => 23,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 23,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 6.1
            [
                'workPackage_id' => 24,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 6.2 = 2
            [
                'workPackage_id' => 25,'volumeNumber' => 1,
                'executionYear' => 2024,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 25,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 7,
                'startDate' => '2025-03-03','endDate' => '2025-11-28',
                // 'startDate' => '2025-03-04','endDate' => '2025-10-15',
            ],

            // 7.1
            [
                'workPackage_id' => 26,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 26,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 26,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 7.2
            [
                'workPackage_id' => 27,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 27,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 27,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 27,'volumeNumber' => 4,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 27,'volumeNumber' => 5,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 8.1
            [
                'workPackage_id' => 28, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 8.2
            [
                'workPackage_id' => 29, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 8.3
            [
                'workPackage_id' => 30, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 8.4
            [
                'workPackage_id' => 31, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 8.5
            [
                'workPackage_id' => 32, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 32, 'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 32, 'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 9.1 = 4
            [
                'workPackage_id' => 33,'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 11,
                'startDate' => '2025-03-03','endDate' => '2025-12-19',
                // 'startDate' => '2025-03-04','endDate' => '2025-11-01',
            ],
            [
                'workPackage_id' => 33,'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 33,'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 33,'volumeNumber' => 4,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 9.2
            [
                'workPackage_id' => 34, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 34, 'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 34, 'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 9.3
            [
                'workPackage_id' => 35, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 35, 'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 35, 'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            // 9.4
            [
                'workPackage_id' => 36, 'volumeNumber' => 1,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 36, 'volumeNumber' => 2,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],
            [
                'workPackage_id' => 36, 'volumeNumber' => 3,
                'executionYear' => 2025,'workOrder_id' => 1,
                'startDate' => '2025-01-01','endDate' => '2025-12-31',
            ],

            // 10.1
            ['workPackage_id' => 37, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 2,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 3,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 4,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 5,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 6,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 7,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 8,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 9,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 10,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 11,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 12,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 13,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 14,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 15,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 16,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 17,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 18,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 19,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 20,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 21,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 22,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 23,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 24,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 25,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 26,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 27,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 28,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 29,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 30,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 31,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 32,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 33,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 34,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 35,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 37, 'volumeNumber' => 36,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            // 10.2
            ['workPackage_id' => 38, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 2,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 3,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 4,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 5,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 6,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 7,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 8,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 9,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 10,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 11,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 12,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 13,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 14,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 15,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 16,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 17,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 38, 'volumeNumber' => 18,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],

            // 11.1
            ['workPackage_id' => 39, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            // 11.2
            ['workPackage_id' => 40, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 2,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 3,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 4,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 5,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 6,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 7,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 8,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 9,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 10,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 11,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 40, 'volumeNumber' => 12,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            // 11.3
            ['workPackage_id' => 41, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 2,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 3,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 4,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 5,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 6,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 7,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 8,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 9,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 10,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 11,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 12,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 13,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 14,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 15,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 16,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 17,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 18,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 19,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 20,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 21,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 22,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 23,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 24,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 25,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 26,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 27,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 28,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 29,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 30,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 31,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 32,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 33,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 34,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 35,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 36,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 41,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 38,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 39,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 41, 'volumeNumber' => 40,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            // 11.4
            ['workPackage_id' => 42, 'volumeNumber' => 1,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 2,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 3,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 4,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 5,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 6,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 7,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 8,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 9,'executionYear' => 2025,'workOrder_id' => 1,'startDate' => '2025-01-01','endDate' => '2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 10,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 11,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 12,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 13,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 14,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 15,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 16,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 17,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 18,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 19,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 20,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 21,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 22,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 23,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 24,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 25,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 26,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 27,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 28,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 29,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
            ['workPackage_id' => 42, 'volumeNumber' => 30,'executionYear'=>2025,'workOrder_id'=>1,'startDate'=>'2025-01-01','endDate'=>'2025-12-31'],
        ];
        foreach ($workpackagevolumes as $workpackagevolume) {
            WorkPackageVolume::create($workpackagevolume);
        };
    }
}

