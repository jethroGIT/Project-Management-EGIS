<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timesheets = [
            [
                'user_id' => 1,
                'volume_id' => 1,
                // 'sub_task_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-10',
                'activity' => 'Kunjungan onsite ke PT Divusi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion)',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-17',
                'activity' => 'Penyusunan draft awal Proposal Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-18',
                'activity' => 'Penyusunan draft awal Proposal Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-24',
                'activity' => 'Menyusun Weekly Report WP 3.1',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-24',
                'activity' => 'Menyusun Weekly Report WP 3.1',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-25',
                'activity' => 'Menyusun bahan meeting berupa Proposal Program Security Awareness (Bab 1 dan Bab 2 bagian 1,2,3 )',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-25',
                'activity' => 'Menyusun bahan meeting berupa Proposal Program Security Awareness (Bab 1 dan Bab 2 bagian 1,2,3 )',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Diskusi dengan PHE melalui Teams - Human Security Competency Matrix Check Point',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Diskusi dengan PHE melalui Teams - Human Security Competency Matrix Check Point',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Diskusi dengan PHE melalui Teams - Human Security Competency Matrix Check Point',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-27',
                'activity' => 'Menyusun Proposal Program Security Awareness Bab 2 dan Bab 3 bagian 1',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-28',
                'activity' => 'Menyusun Proposal Program Security Awareness Bab 3 bagian 1',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-07',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-08',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-09',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-10',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Human Security Check Point [W2 April 2025] jam 08.30 - 09.30',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Human Security Check Point [W2 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Human Security Check Point [W2 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Human Security Check Point [W2 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-14',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-14',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-15',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-17',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-18',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-21',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-21',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-22',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Human Security Check Point [W4 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Human Security Check Point [W4 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Human Security Check Point [W4 April 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-24',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-28',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-29',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-30',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-02',
                'activity' => 'Human Security Check Point W1 Mei 2025 - STK Pendukung Program Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-02',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-05',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi (prosedur dan diagram alir)',
                'duration' => 1.0
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-05',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-06',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi (prosedur dan diagram alir)',
                'duration' => 1.0
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-06',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-08',
                'activity' => 'Human Security Check Point W1 Mei 2025 - TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-08',
                'activity' => 'Check point meeting & Menyusun Notulen Rapat',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-09',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-09',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-14',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
                'duration' => 1.0
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-14',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
                'duration' => 1.0
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Compile and review Deliverables ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025 dan Penyusunan Laporan Executive Summary WP 3.1',
                'duration' => 1.0
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Check point meeting',
                'duration' => 1.0
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-05-16',
                'activity' => 'Compile and review Deliverables ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-16',
                'activity' => 'Human Security Check Point W2 Mei 2025 dan Penyusunan Laporan Executive Summary WP 3.1',
                'duration' => 1.0
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-16',
                'activity' => 'Compile and review Deliverables ',
                'duration' => 0.5
            ],
            // tambahan data lainnya sesuai kebutuhan
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-22',
                'activity' => '- Human Security Capabilities Development Check Point W3 Mei 2025 (Roadmap Kompetensi) dan - Menyusun  dan pitch deck presentasi Pekerjaan WP 3.1 ',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-17',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-18',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-19',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-20',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-23',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-24',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-06-25',
                'activity' => 'Human Security Check Point W4 Juni 2025 - Diskusi Lanjutan Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-07-04',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-07-07',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-07-09',
                'activity' => 'Menyampaikan TKO Pelaksanaan Program Kesadaran Keamanan Informasi dan Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 melalui email',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-07-21',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi dan menyampaikan via email',
                'duration' => 1.0
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
