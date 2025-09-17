<?php

namespace Database\Seeders;

use App\Models\SubTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subtask =[
            // 3.1
            [
                'task_id' => 1,
                'name' => 'Merumuskan maksud dan tujuan dari program security awareness, termasuk kepatuhan terhadap persyaratan standar keamanan. Diskusi dengan tim Infosec, GRC, dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 2,
                'name' => 'Identifikasi stakeholder internal dan eksternal, serta kebutuhannya terhadap program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 3,
                'name' => 'Menentukan sumber daya yang dibutuhkan dalam penyelengaraan program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 3,
                'name' => 'Penyelenggara (struktur organisasi, peran, tugas, kompetensi)',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 3,
                'name' => 'Timeline pelaksanaan',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 3,
                'name' => 'Pencanaan materi',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 4,
                'name' => 'Menentukan metode penyampaikan program security awareness untuk masing-masing stakeholder. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 5,
                'name' => 'Menentukan tingkat security awareness minimum yang menjadi metrik keberhasilan program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 6,
                'name' => 'Menentukan metode evaluasi pencapaian program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 7,
                'name' => 'Menyusun draft STK yang relevan mendukung pelaksanaan program security awareness (TKO atau TKI). Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            // 3.2
            [
                'task_id' => 8,
                'name' => 'Membuat pemetaan kompetensi (pendidikan formal, pelatihan, pengalaman) pada masing-masing stakeholder.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 8,
                'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 9,
                'name' => 'Membuat gap analysis dari kondisi eksisting dengan pemetaan kompetensi pada masing-masing stakeholder.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 9,
                'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 10,
                'name' => 'Membuat roadmap pemenuhan kompetensi pada masing-masing stakeholder.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 10,
                'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            // 5.2
            ['task_id' => 11,'name' => 'Kajian awal ESA dengan pendekatan SABSA','completeness' => 100.00],
            ['task_id' => 11,'name' => 'Initial Review Arsitektur Keamanan','completeness' => 100.00],
            ['task_id' => 11,'name' => 'Kick-Off Meeting dan Pendefinisian Ruang Lingkup','completeness' => 100.00],
            ['task_id' => 11,'name' => 'Training ESA Framework dengan SABSA','completeness' => 0.00],
            ['task_id' => 11,'name' => 'Awareness ESA Framework dengan SABSA','completeness' => 100.00],

            ['task_id' => 12,'name' => 'Identifikasi Stakeholder dan Bussines Drivers ','completeness' => 100.00],
            ['task_id' => 12,'name' => 'Review Existing Arsitektur Keamanan','completeness' => 100.00],
            ['task_id' => 12,'name' => 'Analisis kesenjangan existing and target ESA','completeness' => 100.00],
            ['task_id' => 12,'name' => 'Evaluasi dan pemetaan ESA','completeness' => 100.00],

            ['task_id' => 13,'name' => '- Perancangan Contextual Security Architecture','completeness' => 90.00],
            ['task_id' => 13,'name' => '- Perancangan Conceptual Security Architecture','completeness' => 90.00],
            ['task_id' => 13,'name' => '- Perancangan Logical Security Architecture','completeness' => 90.00],
            ['task_id' => 13,'name' => '- Perancangan Physical Security Architecture','completeness' => 90.00],
            ['task_id' => 13,'name' => '- Perancangan Component Security Architecture','completeness' => 90.00],
            ['task_id' => 13,'name' => '- Perancangan Operational Security Architecture','completeness' => 90.00],
            // 6.2
            ['task_id' => 16, 'name' => 'ISMS Manual ', 'completeness' => 90.00],
            ['task_id' => 16, 'name' => '  a. Internal and External Issue ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => '  b. Scope ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => '  c. Resources ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => '  d. Lampiran 2 - Vendor ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => 'ISMS Manual Appendix - IS Objective + Monitoring ', 'completeness' => 90.00],
            ['task_id' => 16, 'name' => 'ISMS Manual Appendix - IS Comunication + Monitoring ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => 'IS Risk Register ', 'completeness' => 90.00],
            ['task_id' => 16, 'name' => 'SOA ', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => 'IT Asset Register', 'completeness' => 80.00],
            ['task_id' => 16, 'name' => 'Regulation register', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => 'Capacity Plan', 'completeness' => 80.00],
            ['task_id' => 16, 'name' => 'IS Competency Matrix', 'completeness' => 95.00],
            ['task_id' => 16, 'name' => 'ISMS RASCI', 'completeness' => 100.00],
            ['task_id' => 16, 'name' => 'ISMS Charter ', 'completeness' => 100.00],

            ['task_id' => 21, 'name' => 'a. Workshop Check-Point Pemenuhan Evidence (Mercure)', 'completeness' => 100.00],
            ['task_id' => 21, 'name' => 'b. Workshop Persiapan Internal Audit', 'completeness' => 0.00],
            ['task_id' => 21, 'name' => 'c. Workshop Persiapan MR & External Audit', 'completeness' => 0.00],
            // 9.1
        ];

        foreach ($subtask as $sub) {
            SubTask::create($sub);
        };
    }
}
