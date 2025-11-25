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
            [
                'wo_number' => 2
            ],
            [
                'wo_number' => 3
            ],
            [
                'wo_number' => 4
            ],
            [
                'wo_number' => 5
            ],
            [
                'wo_number' => 6
            ],
            [
                'wo_number' => 7
            ],
            [
                'wo_number' => 8
            ],
            [
                'wo_number' => 9
            ],
            [
                'wo_number' => 10
            ],
            [
                'wo_number' => 11
            ],
            [
                'wo_number' => 12
            ],
            [
                'wo_number' => 13
            ],
            [
                'wo_number' => 14
            ],
            [
                'wo_number' => 15
            ],
            [
                'wo_number' => 16
            ],
            [
                'wo_number' => 17
            ],
        ];
        foreach ($workOrders as $workOrder) {
            WorkOrder::create($workOrder);
        }
    }
}
