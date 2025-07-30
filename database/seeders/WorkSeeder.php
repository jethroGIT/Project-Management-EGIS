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
            [
                'user_id' => 1,
                'volume_id' => 1,
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
            ],
            // Tambahan
            [
                'user_id' => 3,
                'volume_id' => 3,
            ],
        ];

        foreach ($works as $work) {
            Work::create($work);
        }
    }
}
