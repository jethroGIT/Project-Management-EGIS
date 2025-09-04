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
                'category_number' => '1',
                'name' => 'Management of Information Security Risk - Company Business Development'
            ],
            [
                'category_number' => '2',
                'name' => 'Management of Information Security Compliance - Business Regulations'
            ],
            [
                'category_number' => '3',
                'name' => 'Management of Human Security Risk Programs'
            ],
            [
                'category_number' => '4',
                'name' => 'Management of Information Security Risk - IT/OT'
            ],
            [
                'category_number' => '5',
                'name' => 'Management of Enterprise Security Architecture'
            ],
            [
                'category_number' => '6',
                'name' => 'Management of Information Security Management System (ISMS)'
            ],
            [
                'category_number' => '7',
                'name' => 'Management of Information Security Compliance'
            ],
            [
                'category_number' => '8',
                'name' => 'Management of Privacy and Protection of Personal Identifiable Information (PII)'
            ],
            [
                'category_number' => '9',
                'name' => 'Management of Security Initiative Technical Assessment & Engineering Design -  IT/ OT'
            ],
            [
                'category_number' => '10',
                'name' => 'Management of Information Security Governance'
            ],
            [
                'category_number' => '11',
                'name' => 'Information Security Advisory & Consultancy Services'
            ],
        ];

        foreach ($categories as $category) {
            WpCategory::create($category);
        }
    }
}
