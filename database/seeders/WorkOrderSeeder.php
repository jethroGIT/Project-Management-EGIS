<?php

namespace Database\Seeders;

use App\Models\WorkOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workOrders = [
            [
                'workNumber_id' => 1
            ],
            [
                'workNumber_id' => 2
            ],
            [
                'workNumber_id' => 3
            ],
            [
                'workNumber_id' => 4
            ],
            [
                'workNumber_id' => 5
            ],
            [
                'workNumber_id' => 6
            ],
            [
                'workNumber_id' => 7
            ],
            [
                'workNumber_id' => 8
            ],
            [
                'workNumber_id' => 9
            ],
            [
                'workNumber_id' => 10
            ],
            [
                'workNumber_id' => 11
            ],
            [
                'workNumber_id' => 12
            ],
            [
                'workNumber_id' => 13
            ],
            [
                'workNumber_id' => 14
            ],
            [
                'workNumber_id' => 15
            ],
            [
                'workNumber_id' => 16
            ],
            [
                'workNumber_id' => 17
            ],
        ];
        foreach ($workOrders as $workOrder) {
            WorkOrder::create($workOrder);
        }
    }
}
