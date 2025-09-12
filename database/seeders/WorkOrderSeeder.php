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
                'wo_number' => 1
            ],
            // [
            //     'wo_number' => 7
            // ],
            // [
            //     'wo_number' => 8
            // ],
            // [
            //     'wo_number' => 12
            // ],
        ];

        foreach ($workOrders as $workOrder) {
            WorkOrder::create($workOrder);
        }
    }
}
