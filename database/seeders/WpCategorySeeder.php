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
        // $categories = [
        //     [
        //         'project_id' => 1,
        //         'category_number' => '1',
        //         'name' => 'Management of Information Security Risk - Company Business Development'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '2',
        //         'name' => 'Management of Information Security Compliance - Business Regulations'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '3',
        //         'name' => 'Management of Human Security Risk Programs'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '4',
        //         'name' => 'Management of Information Security Risk - IT/OT'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '5',
        //         'name' => 'Management of Enterprise Security Architecture'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '6',
        //         'name' => 'Management of Information Security Management System (ISMS)'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '7',
        //         'name' => 'Management of Information Security Compliance'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '8',
        //         'name' => 'Management of Privacy and Protection of Personal Identifiable Information (PII)'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '9',
        //         'name' => 'Management of Security Initiative Technical Assessment & Engineering Design -  IT/ OT'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '10',
        //         'name' => 'Management of Information Security Governance'
        //     ],
        //     [
        //         'project_id' => 1,
        //         'category_number' => '11',
        //         'name' => 'Information Security Advisory & Consultancy Services'
        //     ],
        // ];

        $categories = [
            [
                'project_id' => 1,
                'category_number' => '1',
                'name' => 'Perencanaan'
            ],
            [
                'project_id' => 1,
                'category_number' => '2',
                'name' => 'Desain & Pengembangan'
            ],
            [
                'project_id' => 1,
                'category_number' => '3',
                'name' => 'Pengujian Kualitas'
            ],
            [
                'project_id' => 1,
                'category_number' => '4',
                'name' => 'Pemasaran & Promosi'
            ],
            [
                'project_id' => 1,
                'category_number' => '5',
                'name' => 'Keuangan'
            ],
            [
                'project_id' => 1,
                'category_number' => '6',
                'name' => 'Dukungan Teknis'
            ],
            [
                'project_id' => 1,
                'category_number' => '7',
                'name' => 'Administrasi'
            ],
            [
                'project_id' => 1,
                'category_number' => '8',
                'name' => 'Riset & Analisis'
            ],
            [
                'project_id' => 1,
                'category_number' => '9',
                'name' => 'Pelatihan & SDM'
            ],
            [
                'project_id' => 1,
                'category_number' => '10',
                'name' => 'Operasi Lapangan'
            ]
        ];

        foreach ($categories as $category) {
            WpCategory::create($category);
        }
    }
}
