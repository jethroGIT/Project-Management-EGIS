<?php

namespace Database\Seeders;

use App\Models\WpCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WpCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Management of Human Security Risk Programs'
            ],
            [
                'name' => 'Management of Information Security Management System (ISMS)'
            ],
        ];

        foreach ($categories as $category) {
            WpCategory::create($category);
        }
    }
}
