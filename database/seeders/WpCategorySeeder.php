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
                'project_id' => 1,
                'categoryNumber' => '1',
                'name' => 'Management of Information Security Risk - Company Business Development'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '2',
                'name' => 'Management of Information Security Compliance - Business Regulations'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '3',
                'name' => 'Management of Human Security Risk Programs'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '4',
                'name' => 'Management of Information Security Risk - IT/OT'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '5',
                'name' => 'Management of Enterprise Security Architecture'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '6',
                'name' => 'Management of Information Security Management System (ISMS)'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '7',
                'name' => 'Management of Information Security Compliance'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '8',
                'name' => 'Management of Privacy and Protection of Personal Identifiable Information (PII)'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '9',
                'name' => 'Management of Security Initiative Technical Assessment & Engineering Design -  IT/ OT'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '10',
                'name' => 'Management of Information Security Governance'
            ],
            [
                'project_id' => 1,
                'categoryNumber' => '11',
                'name' => 'Information Security Advisory & Consultancy Services'
            ],
        ];
        foreach ($categories as $category) {
            WpCategory::create($category);
        }
    }
}
