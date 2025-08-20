<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            //3.1
            [
                'volume_id' => 1,
                'name' => 'Analisis kebutuhan program security awareness',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Identifikasi stakeholder dan kebutuhannya terhadap program security awareness',
                'status' => 'closed',                
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Sumber daya yang dibutuhkan dalam program security awareness',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Penentuan cara penyampaian program security awareness',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Penetapan tingkat security awareness minimum',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Metode evaluasi pencapaian program security awareness',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Penyusunan STK tentang program security awareness',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            // 6.2
            [
                'volume_id' => 2,
                'name' => 'Initial/Hasil pendefinisian lingkup',
                'status' => 'closed',
                // 'completeness' => 100.00,
            ],
            [
                'volume_id' => 2,
                'name' => 'ISMS Core Records Review',
                'status' => 'open',
                // 'completeness' => 31.25,
            ],
            [
                'volume_id' => 2,
                'name' => 'Review penerapan & analisis kebutuhan penyesuaian STK/ISMS Policies Review/Penyusunan STK terkait-relevan',
                'status' => 'open',
                // 'completeness' => 0.00,
            ],
            [
                'volume_id' => 2,
                'name' => 'Audit Preparation/Pendampingan uji coba implementasi',
                'status' => 'open',
                // 'completeness' => 0.00,
            ],
            [
                'volume_id' => 2,
                'name' => 'Audit Execution/Pendampingan audit (Internal/External)',
                'status' => 'open',
                // 'completeness' => 0.00,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        };
    }
}
