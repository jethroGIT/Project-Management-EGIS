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
        // $subtask =[
        //     // 3.1
        //     [
        //         'task_id' => 1,
        //         'name' => 'Merumuskan maksud dan tujuan dari program security awareness, termasuk kepatuhan terhadap persyaratan standar keamanan. Diskusi dengan tim Infosec, GRC, dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 2,
        //         'name' => 'Identifikasi stakeholder internal dan eksternal, serta kebutuhannya terhadap program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 3,
        //         'name' => 'Menentukan sumber daya yang dibutuhkan dalam penyelengaraan program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 3,
        //         'name' => 'Penyelenggara (struktur organisasi, peran, tugas, kompetensi)',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 3,
        //         'name' => 'Timeline pelaksanaan',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 3,
        //         'name' => 'Pencanaan materi',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 4,
        //         'name' => 'Menentukan metode penyampaikan program security awareness untuk masing-masing stakeholder. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 5,
        //         'name' => 'Menentukan tingkat security awareness minimum yang menjadi metrik keberhasilan program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 6,
        //         'name' => 'Menentukan metode evaluasi pencapaian program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 7,
        //         'name' => 'Menyusun draft STK yang relevan mendukung pelaksanaan program security awareness (TKO atau TKI). Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     // 3.2
        //     [
        //         'task_id' => 8,
        //         'name' => 'Membuat pemetaan kompetensi (pendidikan formal, pelatihan, pengalaman) pada masing-masing stakeholder.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 8,
        //         'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 9,
        //         'name' => 'Membuat gap analysis dari kondisi eksisting dengan pemetaan kompetensi pada masing-masing stakeholder.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 9,
        //         'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 10,
        //         'name' => 'Membuat roadmap pemenuhan kompetensi pada masing-masing stakeholder.',
        //         'completeness' => 100.00,
        //     ],
        //     [
        //         'task_id' => 10,
        //         'name' => 'Diskusi dengan tim HR, GRC dan CSAA di PHE.',
        //         'completeness' => 100.00,
        //     ],
        //     // 5.2
        //     ['task_id' => 11,'name' => 'Kajian awal ESA dengan pendekatan SABSA','completeness' => 100.00],
        //     ['task_id' => 11,'name' => 'Initial Review Arsitektur Keamanan','completeness' => 100.00],
        //     ['task_id' => 11,'name' => 'Kick-Off Meeting dan Pendefinisian Ruang Lingkup','completeness' => 100.00],
        //     ['task_id' => 11,'name' => 'Training ESA Framework dengan SABSA','completeness' => 0.00],
        //     ['task_id' => 11,'name' => 'Awareness ESA Framework dengan SABSA','completeness' => 100.00],

        //     ['task_id' => 12,'name' => 'Identifikasi Stakeholder dan Bussines Drivers ','completeness' => 100.00],
        //     ['task_id' => 12,'name' => 'Review Existing Arsitektur Keamanan','completeness' => 100.00],
        //     ['task_id' => 12,'name' => 'Analisis kesenjangan existing and target ESA','completeness' => 100.00],
        //     ['task_id' => 12,'name' => 'Evaluasi dan pemetaan ESA','completeness' => 100.00],

        //     ['task_id' => 13,'name' => '- Perancangan Contextual Security Architecture','completeness' => 90.00],
        //     ['task_id' => 13,'name' => '- Perancangan Conceptual Security Architecture','completeness' => 90.00],
        //     ['task_id' => 13,'name' => '- Perancangan Logical Security Architecture','completeness' => 90.00],
        //     ['task_id' => 13,'name' => '- Perancangan Physical Security Architecture','completeness' => 90.00],
        //     ['task_id' => 13,'name' => '- Perancangan Component Security Architecture','completeness' => 90.00],
        //     ['task_id' => 13,'name' => '- Perancangan Operational Security Architecture','completeness' => 90.00],
        //     // 6.2
        //     ['task_id' => 14, 'name' => 'Kick Off Meeting Pendampingan Surveillance 2025', 'completeness' => 100.00],
        //     ['task_id' => 14, 'name' => 'Review dan Revisi SPRINT SMKI 2025', 'completeness' => 100.00],

        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     ISMS Manual ', 'completeness' => 90.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     a. Internal and External Issue ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     b. Scope ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     c. Resources ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     d. Lampiran 2 - Vendor ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     ISMS Manual Appendix - IS Objective + Monitoring ', 'completeness' => 90.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     ISMS Manual Appendix - IS Comunication + Monitoring ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     IS Risk Register ', 'completeness' => 90.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     SOA ', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     IT Asset Register', 'completeness' => 80.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     Regulation register', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     Capacity Plan', 'completeness' => 80.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     IS Competency Matrix', 'completeness' => 95.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     ISMS RASCI', 'completeness' => 100.00],
        //     ['task_id' => 14, 'name' => 'Review Core Records ISMS untuk tahun 2025:
        //     ISMS Charter ', 'completeness' => 100.00],
        //     ['task_id' => 14, 'name' => 'Review STK terkait ISMS untuk tahun 2025:
        //     a. Memastikan seluruh Pedoman SMKI masih relevan
        //     b. Membangun STK untuk Configuration Management
        //     c. Membangun STK untuk Monitoring, evaluation (MEAP) ISMS
        //     d. Revisit TKO Incident Handling
        //     e. Revisit STK terkait Asset Management', 'completeness' => 70.00],

        //     ['task_id' => 15, 'name' => 'Review Internal & External Audit 2024 PTP Progress', 'completeness' => 100.00],
        //     ['task_id' => 15, 'name' => 'Workshop Persiapan Pemenuhan Evidence', 'completeness' => 100.00],
        //     ['task_id' => 15, 'name' => 'Monitoring Pemenuhan Evidence', 'completeness' => 25.00],
        //     ['task_id' => 15, 'name' => 'Workshop Check-Point & Preparation Surveillance Audit:a. Workshop Check-Point Pemenuhan Evidence (Mercure)', 'completeness' => 100.00],
        //     ['task_id' => 15, 'name' => 'Workshop Check-Point & Preparation Surveillance Audit:b. Workshop Persiapan Internal Audit', 'completeness' => 0.00],
        //     ['task_id' => 15, 'name' => 'Workshop Check-Point & Preparation Surveillance Audit:c. Workshop Persiapan MR & External Audit', 'completeness' => 0.00],

        //     ['task_id' => 16, 'name' => 'Pendampingan Internal Audit', 'completeness' => 0.00],
        //     ['task_id' => 16, 'name' => 'Pendampingan Management Review', 'completeness' => 50.00],
        //     ['task_id' => 16, 'name' => 'Pendampingan External Surveillance Audit', 'completeness' => 0.00],

        //     ['task_id' => 17, 'name' => 'Progress Monitoring (Weekly report)', 'completeness' => 50.00],
        //     ['task_id' => 17, 'name' => 'Pelaporan Akhir', 'completeness' => 0.00],
        //     // 9.1
        // ];

        $subtask = [
            // Task ID 4 (Volume ID 2)
            ['task_id' => 4, 'name' => 'Daftar Semua Output Proyek', 'completeness' => 100.00],
            ['task_id' => 4, 'name' => 'Pemetaan Input-Output', 'completeness' => 100.00],

            // Task ID 6 (Volume ID 2)
            ['task_id' => 6, 'name' => 'Pembagian Level 1 WBS', 'completeness' => 80.00],
            ['task_id' => 6, 'name' => 'Pembagian Level 2 WBS', 'completeness' => 60.00],

            // Task ID 11 (Volume ID 4)
            ['task_id' => 11, 'name' => 'Coding Endpoint GET & POST', 'completeness' => 80.00],
            ['task_id' => 11, 'name' => 'Coding Endpoint PUT & DELETE', 'completeness' => 30.00],

            // Task ID 27 (Volume ID 8)
            ['task_id' => 27, 'name' => 'Pelaksanaan Sesi UAT Online', 'completeness' => 80.00],
            ['task_id' => 27, 'name' => 'Dokumentasi Feedback Langsung', 'completeness' => 90.00],

            // Task ID 29 (Volume ID 8)
            ['task_id' => 29, 'name' => 'Review Kode Perbaikan Bug', 'completeness' => 100.00],
            ['task_id' => 29, 'name' => 'Pengujian Regresi Bug Perbaikan', 'completeness' => 50.00],

            // Task ID 47 (Volume ID 14)
            ['task_id' => 47, 'name' => 'Penulisan Bab Login dan Dashboard', 'completeness' => 90.00],
            ['task_id' => 47, 'name' => 'Penulisan Bab Pengelolaan Profil', 'completeness' => 60.00],

            // Task ID 59 (Volume ID 19)
            ['task_id' => 59, 'name' => 'Verifikasi List Email Responden', 'completeness' => 100.00],
            ['task_id' => 59, 'name' => 'Pengiriman Batch 1 Survei', 'completeness' => 100.00],

            // Task ID 60 (Volume ID 19)
            ['task_id' => 60, 'name' => 'Pengiriman Email Reminder 1', 'completeness' => 70.00],
            ['task_id' => 60, 'name' => 'Panggilan Telepon ke Responden Kunci', 'completeness' => 40.00],
        ];

        foreach ($subtask as $sub) {
            SubTask::create($sub);
        };
    }
}
