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
        // $hresources =[
        //     // 1.1
        //     ['role_id' => 1,'wp_id' => 1,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 2,'wp_id' => 1,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 1,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 1,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 5,'wp_id' => 1,'jtk' => 2,'jhk' => 10],
        //     // 1.2
        //     ['role_id' => 1,'wp_id' => 2,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 2,'wp_id' => 2,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 2,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 2,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 5,'wp_id' => 2,'jtk' => 2,'jhk' => 10],
            
        //     // 2.1
        //     ['role_id' => 1,'wp_id' => 3,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 2,'wp_id' => 3,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 3,'wp_id' => 3,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 4,'wp_id' => 3,'jtk' => 1,'jhk' => 8],
        //     ['role_id' => 5,'wp_id' => 3,'jtk' => 2,'jhk' => 8],
        //     // 2.2
        //     ['role_id' => 1,'wp_id' => 4,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 2,'wp_id' => 4,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 4,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 4,'wp_id' => 4,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 5,'wp_id' => 4,'jtk' => 2,'jhk' => 20],
        //     // 2.3
        //     ['role_id' => 1,'wp_id' => 5,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 2,'wp_id' => 5,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 3,'wp_id' => 5,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 5,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 5,'wp_id' => 5,'jtk' => 1,'jhk' => 10],
        //     // 2.4
        //     ['role_id' => 1,'wp_id' => 6,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 2,'wp_id' => 6,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 3,'wp_id' => 6,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 6,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 6,'jtk' => 2,'jhk' => 4],
        //     // 2.5
        //     ['role_id' => 1,'wp_id' => 7,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 7,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 7,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 7,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 7,'jtk' => 2,'jhk' => 6],

        //     // 3.1 = 8
        //     ['role_id' => 1,'wp_id' => 8,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 8,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 8,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 8,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 8,'jtk' => 1,'jhk' => 20],
        //     // 3.2 = 9
        //     ['role_id' => 1,'wp_id' => 9,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 2,'wp_id' => 9,'jtk' => 1,'jhk' => 15],
        //     ['role_id' => 3,'wp_id' => 9,'jtk' => 1,'jhk' => 15],
        //     ['role_id' => 4,'wp_id' => 9,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 9,'jtk' => 1,'jhk' => 30], // aktual JTK-nya 2
        //     // 3.3
        //     ['role_id' => 1,'wp_id' => 10,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 10,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 3,'wp_id' => 10,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 10,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 10,'jtk' => 1,'jhk' => 8],
        //     // 3.4
        //     ['role_id' => 1,'wp_id' => 11,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 11,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 11,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 11,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 11,'jtk' => 2,'jhk' => 4],
        //     // 3.5
        //     ['role_id' => 1,'wp_id' => 12,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 12,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 12,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 4,'wp_id' => 12,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 12,'jtk' => 2,'jhk' => 6],

        //     // 4.1
        //     ['role_id' => 1,'wp_id' => 13,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 2,'wp_id' => 13,'jtk' => 1,'jhk' => 25],
        //     ['role_id' => 3,'wp_id' => 13,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 4,'wp_id' => 13,'jtk' => 1,'jhk' => 25],
        //     ['role_id' => 5,'wp_id' => 13,'jtk' => 1,'jhk' => 12],
        //     // 4.2
        //     ['role_id' => 1,'wp_id' => 14,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 2,'wp_id' => 14,'jtk' => 1,'jhk' => 5],
        //     ['role_id' => 3,'wp_id' => 14,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 14,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 5,'wp_id' => 14,'jtk' => 1,'jhk' => 10],
        //     // 4.3
        //     ['role_id' => 1,'wp_id' => 15,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 2,'wp_id' => 15,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 3,'wp_id' => 15,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 15,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 15,'jtk' => 2,'jhk' => 4],
        //     // 4.4
        //     ['role_id' => 1,'wp_id' => 16,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 16,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 16,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 16,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 16,'jtk' => 2,'jhk' => 6],
            
        //     // 5.1
        //     ['role_id' => 1,'wp_id' => 17,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 2,'wp_id' => 17,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 17,'jtk' => 1,'jhk' => 16],
        //     ['role_id' => 4,'wp_id' => 17,'jtk' => 1,'jhk' => 16],
        //     ['role_id' => 5,'wp_id' => 17,'jtk' => 1,'jhk' => 10],
        //     // 5.2 = 18
        //     ['role_id' => 1,'wp_id' => 18,'jtk' => 1,'jhk' => 17],
        //     ['role_id' => 2,'wp_id' => 18,'jtk' => 1,'jhk' => 17],
        //     ['role_id' => 3,'wp_id' => 18,'jtk' => 1,'jhk' => 34],
        //     ['role_id' => 4,'wp_id' => 18,'jtk' => 1,'jhk' => 17],
        //     ['role_id' => 5,'wp_id' => 18,'jtk' => 2,'jhk' => 17],
        //     // 5.3
        //     ['role_id' => 1,'wp_id' => 19,'jtk' => 1,'jhk' => 8],
        //     ['role_id' => 2,'wp_id' => 19,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 3,'wp_id' => 19,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 4,'wp_id' => 19,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 5,'wp_id' => 19,'jtk' => 1,'jhk' => 10],
        //     // 5.4
        //     ['role_id' => 1,'wp_id' => 20,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 2,'wp_id' => 20,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 3,'wp_id' => 20,'jtk' => 1,'jhk' => 24],
        //     ['role_id' => 4,'wp_id' => 20,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 5,'wp_id' => 20,'jtk' => 2,'jhk' => 12],
        //     // 5.5
        //     ['role_id' => 1,'wp_id' => 21,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 21,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 21,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 21,'jtk' => 1,'jhk' => 16],
        //     ['role_id' => 5,'wp_id' => 21,'jtk' => 1,'jhk' => 8],
        //     // 5.6
        //     ['role_id' => 1,'wp_id' => 22,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 2,'wp_id' => 22,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 3,'wp_id' => 22,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 22,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 22,'jtk' => 2,'jhk' => 4],
        //     // 5.7
        //     ['role_id' => 1,'wp_id' => 23,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 23,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 23,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 23,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 23,'jtk' => 2,'jhk' => 6],

        //     // 6.1
        //     ['role_id' => 1,'wp_id' => 24,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 2,'wp_id' => 24,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 3,'wp_id' => 24,'jtk' => 1,'jhk' => 40],
        //     ['role_id' => 4,'wp_id' => 24,'jtk' => 1,'jhk' => 40],
        //     ['role_id' => 5,'wp_id' => 24,'jtk' => 1,'jhk' => 40],
        //     // 6.2 = 25
        //     ['role_id' => 1,'wp_id' => 25,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 2,'wp_id' => 25,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 3,'wp_id' => 25,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 4,'wp_id' => 25,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 5,'wp_id' => 25,'jtk' => 1,'jhk' => 20],

        //     // 7.1
        //     ['role_id' => 1,'wp_id' => 26,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 2,'wp_id' => 26,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 3,'wp_id' => 26,'jtk' => 1,'jhk' => 40],
        //     ['role_id' => 4,'wp_id' => 26,'jtk' => 1,'jhk' => 40],
        //     ['role_id' => 5,'wp_id' => 26,'jtk' => 1,'jhk' => 40],
        //     // 7.2
        //     ['role_id' => 1,'wp_id' => 27,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 2,'wp_id' => 27,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 3,'wp_id' => 27,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 4,'wp_id' => 27,'jtk' => 1,'jhk' => 20],
        //     ['role_id' => 5,'wp_id' => 27,'jtk' => 1,'jhk' => 20],

        //     // 8.1
        //     ['role_id' => 1,'wp_id' => 28,'jtk' => 1,'jhk' => 10],
        //     ['role_id' => 2,'wp_id' => 28,'jtk' => 1,'jhk' => 15],
        //     ['role_id' => 3,'wp_id' => 28,'jtk' => 1,'jhk' => 15],
        //     ['role_id' => 4,'wp_id' => 28,'jtk' => 1,'jhk' => 15],
        //     ['role_id' => 5,'wp_id' => 28,'jtk' => 2,'jhk' => 15],
        //     // 8.2
        //     ['role_id' => 1,'wp_id' => 29,'jtk' => 1,'jhk' => 8],
        //     ['role_id' => 2,'wp_id' => 29,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 3,'wp_id' => 29,'jtk' => 1,'jhk' => 24],
        //     ['role_id' => 4,'wp_id' => 29,'jtk' => 1,'jhk' => 32],
        //     ['role_id' => 5,'wp_id' => 29,'jtk' => 2,'jhk' => 32],
        //     // 8.3
        //     ['role_id' => 1,'wp_id' => 30,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 30,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 30,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 30,'jtk' => 1,'jhk' => 12],
        //     ['role_id' => 5,'wp_id' => 30,'jtk' => 1,'jhk' => 8],
        //     // 8.4
        //     ['role_id' => 1,'wp_id' => 31,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 2,'wp_id' => 31,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 3,'wp_id' => 31,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 31,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 31,'jtk' => 2,'jhk' => 4],
        //     // 8.5
        //     ['role_id' => 1,'wp_id' => 32,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 32,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 32,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 32,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 32,'jtk' => 2,'jhk' => 6],

        //     // 9.1 = 33
        //     ['role_id' => 1,'wp_id' => 33,'jtk' => 1,'jhk' => 26],
        //     ['role_id' => 2,'wp_id' => 33,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 3,'wp_id' => 33,'jtk' => 1,'jhk' => 30],
        //     ['role_id' => 4,'wp_id' => 33,'jtk' => 2,'jhk' => 40],
        //     ['role_id' => 5,'wp_id' => 33,'jtk' => 2,'jhk' => 40],
        //     // 9.2
        //     ['role_id' => 1,'wp_id' => 34,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 34,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 34,'jtk' => 1,'jhk' => 8],
        //     ['role_id' => 4,'wp_id' => 34,'jtk' => 1,'jhk' => 16],
        //     ['role_id' => 5,'wp_id' => 34,'jtk' => 1,'jhk' => 8],
        //     // 9.3
        //     ['role_id' => 1,'wp_id' => 35,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 2,'wp_id' => 35,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 3,'wp_id' => 35,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 35,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 35,'jtk' => 2,'jhk' => 4],
        //     // 9.4
        //     ['role_id' => 1,'wp_id' => 36,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 2,'wp_id' => 36,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 3,'wp_id' => 36,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 4,'wp_id' => 36,'jtk' => 1,'jhk' => 6],
        //     ['role_id' => 5,'wp_id' => 36,'jtk' => 2,'jhk' => 6],

        //     // 10.1
        //     ['role_id' => 1,'wp_id' => 37,'jtk' => 1,'jhk' => 1],
        //     ['role_id' => 2,'wp_id' => 37,'jtk' => 1,'jhk' => 1],
        //     ['role_id' => 3,'wp_id' => 37,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 37,'jtk' => 1,'jhk' => 4],
        //     ['role_id' => 5,'wp_id' => 37,'jtk' => 1,'jhk' => 8],
        //     // 10.2
        //     ['role_id' => 1,'wp_id' => 38,'jtk' => 1,'jhk' => 1],
        //     ['role_id' => 2,'wp_id' => 38,'jtk' => 1,'jhk' => 1],
        //     ['role_id' => 3,'wp_id' => 38,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 4,'wp_id' => 38,'jtk' => 1,'jhk' => 2],
        //     ['role_id' => 5,'wp_id' => 38,'jtk' => 1,'jhk' => 6],
        // ];

        $hresources = [
            // =========================================================================
            // WP ID 1: Perencanaan (Duration: 25 Hari)
            // Total JHK: 3 + 4 + 7 + 4 + 5 = 23 (<= 25)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 1, 'jtk' => 1, 'jhk' => 3], // Project Manager
            ['role_id' => 2, 'wp_id' => 1, 'jtk' => 1, 'jhk' => 4], // Senior Consultant
            ['role_id' => 3, 'wp_id' => 1, 'jtk' => 1, 'jhk' => 7], // Associate Consultant
            ['role_id' => 4, 'wp_id' => 1, 'jtk' => 1, 'jhk' => 4], // Junior Consultant
            ['role_id' => 5, 'wp_id' => 1, 'jtk' => 1, 'jhk' => 5], // Technical Writer

            // =========================================================================
            // WP ID 2: Perencanaan (Duration: 12 Hari)
            // Total JHK: 2 + 3 + 3 + 2 + 1 = 11 (<= 12)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 2, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 2, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 3, 'wp_id' => 2, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 4, 'wp_id' => 2, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 5, 'wp_id' => 2, 'jtk' => 1, 'jhk' => 1],

            // =========================================================================
            // WP ID 3: Desain & Pengembangan (Duration: 30 Hari)
            // Total JHK: 3 + 6 + 10 + 4 + 5 = 28 (<= 30)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 3, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 2, 'wp_id' => 3, 'jtk' => 1, 'jhk' => 6],
            ['role_id' => 3, 'wp_id' => 3, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 4, 'wp_id' => 3, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 5, 'wp_id' => 3, 'jtk' => 1, 'jhk' => 5],

            // =========================================================================
            // WP ID 4: Pengembangan Modul Inti (Duration: 85 Hari)
            // Total JHK: 10 + 15 + 30 + 15 + 10 = 80 (<= 85)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 4, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 2, 'wp_id' => 4, 'jtk' => 1, 'jhk' => 15],
            ['role_id' => 3, 'wp_id' => 4, 'jtk' => 1, 'jhk' => 30],
            ['role_id' => 4, 'wp_id' => 4, 'jtk' => 1, 'jhk' => 15],
            ['role_id' => 5, 'wp_id' => 4, 'jtk' => 1, 'jhk' => 10],

            // =========================================================================
            // WP ID 5: Pengujian Kualitas (Duration: 20 Hari)
            // Total JHK: 3 + 5 + 6 + 4 + 1 = 19 (<= 20)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 5, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 2, 'wp_id' => 5, 'jtk' => 1, 'jhk' => 5],
            ['role_id' => 3, 'wp_id' => 5, 'jtk' => 1, 'jhk' => 6],
            ['role_id' => 4, 'wp_id' => 5, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 5, 'wp_id' => 5, 'jtk' => 1, 'jhk' => 1],

            // =========================================================================
            // WP ID 6: Pemasaran & Promosi (Duration: 15 Hari)
            // Total JHK: 2 + 4 + 4 + 3 + 1 = 14 (<= 15)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 6, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 6, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 3, 'wp_id' => 6, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 4, 'wp_id' => 6, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 5, 'wp_id' => 6, 'jtk' => 1, 'jhk' => 1],

            // =========================================================================
            // WP ID 7: Pemasaran & Promosi (Duration: 40 Hari)
            // Total JHK: 5 + 8 + 12 + 10 + 4 = 39 (<= 40)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 7, 'jtk' => 1, 'jhk' => 5],
            ['role_id' => 2, 'wp_id' => 7, 'jtk' => 1, 'jhk' => 8],
            ['role_id' => 3, 'wp_id' => 7, 'jtk' => 1, 'jhk' => 12],
            ['role_id' => 4, 'wp_id' => 7, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 5, 'wp_id' => 7, 'jtk' => 1, 'jhk' => 4],

            // =========================================================================
            // WP ID 8: Keuangan (Duration: 10 Hari)
            // Total JHK: 2 + 3 + 2 + 2 + 0 = 9 (<= 10)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 8, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 8, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 3, 'wp_id' => 8, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 4, 'wp_id' => 8, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 5, 'wp_id' => 8, 'jtk' => 1, 'jhk' => 0], // Technical Writer mungkin tidak terlibat di Keuangan

            // =========================================================================
            // WP ID 9: Dukungan Teknis (Duration: 25 Hari)
            // Total JHK: 2 + 4 + 6 + 4 + 8 = 24 (<= 25)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 9, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 9, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 3, 'wp_id' => 9, 'jtk' => 1, 'jhk' => 6],
            ['role_id' => 4, 'wp_id' => 9, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 5, 'wp_id' => 9, 'jtk' => 1, 'jhk' => 8],

            // =========================================================================
            // WP ID 10: Dukungan Teknis (Duration: 18 Hari)
            // Total JHK: 2 + 5 + 7 + 3 + 0 = 17 (<= 18)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 10, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 10, 'jtk' => 1, 'jhk' => 5],
            ['role_id' => 3, 'wp_id' => 10, 'jtk' => 1, 'jhk' => 7],
            ['role_id' => 4, 'wp_id' => 10, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 5, 'wp_id' => 10, 'jtk' => 1, 'jhk' => 0],

            // =========================================================================
            // WP ID 11: Administrasi (Duration: 60 Hari)
            // Total JHK: 8 + 10 + 15 + 10 + 5 = 48 (<= 60)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 11, 'jtk' => 1, 'jhk' => 8],
            ['role_id' => 2, 'wp_id' => 11, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 3, 'wp_id' => 11, 'jtk' => 1, 'jhk' => 15],
            ['role_id' => 4, 'wp_id' => 11, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 5, 'wp_id' => 11, 'jtk' => 1, 'jhk' => 5],

            // =========================================================================
            // WP ID 12: Riset & Analisis (Duration: 35 Hari)
            // Total JHK: 3 + 8 + 10 + 6 + 6 = 33 (<= 35)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 12, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 2, 'wp_id' => 12, 'jtk' => 1, 'jhk' => 8],
            ['role_id' => 3, 'wp_id' => 12, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 4, 'wp_id' => 12, 'jtk' => 1, 'jhk' => 6],
            ['role_id' => 5, 'wp_id' => 12, 'jtk' => 1, 'jhk' => 6],

            // =========================================================================
            // WP ID 13: Pelatihan & SDM (Duration: 14 Hari)
            // Total JHK: 2 + 3 + 4 + 3 + 1 = 13 (<= 14)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 13, 'jtk' => 1, 'jhk' => 2],
            ['role_id' => 2, 'wp_id' => 13, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 3, 'wp_id' => 13, 'jtk' => 1, 'jhk' => 4],
            ['role_id' => 4, 'wp_id' => 13, 'jtk' => 1, 'jhk' => 3],
            ['role_id' => 5, 'wp_id' => 13, 'jtk' => 1, 'jhk' => 1],

            // =========================================================================
            // WP ID 14: Operasi Lapangan (Duration: 50 Hari)
            // Total JHK: 5 + 10 + 15 + 10 + 5 = 45 (<= 50)
            // =========================================================================
            ['role_id' => 1, 'wp_id' => 14, 'jtk' => 1, 'jhk' => 5],
            ['role_id' => 2, 'wp_id' => 14, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 3, 'wp_id' => 14, 'jtk' => 1, 'jhk' => 15],
            ['role_id' => 4, 'wp_id' => 14, 'jtk' => 1, 'jhk' => 10],
            ['role_id' => 5, 'wp_id' => 14, 'jtk' => 1, 'jhk' => 5],
        ];
        foreach ($hresources as $hresource) {
            HumanResource::create($hresource);
        };
    }
}
