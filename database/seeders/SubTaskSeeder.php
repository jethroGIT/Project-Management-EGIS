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
            //3.1
            [
                'task_id' => 1,
                'name' => 'Merumuskan maksud dan tujuan dari program security awareness, termasuk kepatuhan terhadap persyaratan standar keamanan. Diskusi dengan tim Infosec, GRC, dan CSAA di PHE.',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 2,
                'name' => 'Identifikasi stakeholder iinternal dan eksternal, serta kebutuhannya terhadap program security awareness. Diskusi dengan tim Infosec, GRC dan CSAA di PHE.',
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
            //6.2
            [
                'task_id' => 8,
                'name' => 'ISMS Awareness Survey',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 8,
                'name' => 'Training ISO 27001: Refreshment, Lead Implementator, Lead Auditor',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 8,
                'name' => 'Review & Revisit SPRINT SMKI Tahun 2025',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 8,
                'name' => 'Kick-Off Meeting',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 8,
                'name' => 'Awareness ISO 27001 for new-comers & new scope',
                'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'ISMS Manual (Scope, IS Objective, IS Communication)', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'IS Risk Register', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'SoA', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'IT Asset Register', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'Regulation Register', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'Capacity Plan', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'IS Competency Matrix', 'completeness' => 100.00,
            ],
            [
                'task_id' => 9, 'name' => 'ISMS RASCI', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Review all ISMS Policies', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Revisit IS Risk Policies', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Revisit PII Related Policy', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Revisit NDA Related Policy', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Revisit Asset Management Policy', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Revisit Incident Handling Procedure', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Design Configuration Management Procedure', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Design Measurement, Monitoring, Evaluation of ISMS Procedure', 'completeness' => 100.00,
            ],
            [
                'task_id' => 10, 'name' => 'Design Secure SDLC Procedures', 'completeness' => 100.00,
            ],
            [
                'task_id' => 11, 'name' => 'Review 2024 Internal & External Audit PTP Findings Progress', 'completeness' => 100.00,
            ],
            [
                'task_id' => 11, 'name' => 'Evidence Preparation', 'completeness' => 100.00,
            ],
            [
                'task_id' => 11, 'name' => 'Evidence Submission Monitoring', 'completeness' => 100.00,
            ],
            [
                'task_id' => 11, 'name' => 'Evidence checkpoint workshop', 'completeness' => 100.00,
            ],
            [
                'task_id' => 11, 'name' => 'Audit Preparation Workshops', 'completeness' => 100.00,
            ],
            [
                'task_id' => 12, 'name' => 'Assisting Internal Audit', 'completeness' => 100.00,
            ],
            [
                'task_id' => 12, 'name' => 'MR & External Audit Workshop Preparation', 'completeness' => 100.00,
            ],
            [
                'task_id' => 12, 'name' => 'Assisting management review', 'completeness' => 100.00,
            ],
            [
                'task_id' => 12, 'name' => 'Workshop Persiapan External Audit', 'completeness' => 100.00,
            ],
            [
                'task_id' => 12, 'name' => 'Assisting External Surveillance Audit', 'completeness' => 100.00,
            ],
        ];

        foreach ($subtask as $sub) {
            SubTask::create($sub);
        };
    }
}
