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
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Diskusi online internal mengenai project EGIS',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-02-28',
                'activity' => 'Sharing knowledge Proposal Program Security Awareness',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-10',
                'activity' => 'Kunjungan onsite ke PT Divusi ',
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion) 09.00 - 10.00',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion) 09.00 - 10.00',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion) 09.00 - 10.00',
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion) 09.00 - 10.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-13',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Security (Initial Discussion) 09.00 - 10.00',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-17',
                'activity' => 'Penyusunan draft awal Proposal Security Awareness',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-18',
                'activity' => 'Penyusunan draft awal Proposal Security Awareness',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion) 09.00-11.00',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion) 09.00-11.00',
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Diskusi dengan PHE melalui Teams - EGIS - Human Firewall (IS Competency Matrix Initial Discussion) 09.00-11.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-20',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-24',
                'activity' => 'Menyusun Weekly Report WP 3.1 ',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-24',
                'activity' => 'Menyusun Weekly Report WP 3.1 ',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-25',
                'activity' => 'Menyusun bahan meeting berupa Proposal Program Security Awareness (Bab 1 dan Bab 2 bagian 1,2,3 )',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-25',
                'activity' => 'Menyusun bahan meeting berupa Proposal Program Security Awareness (Bab 1 dan Bab 2 bagian 1,2,3 )',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Diskusi dengan PHE melalui Teams - Human Security Competency Matrix Check Point 13.00 - 14.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-03-26',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-27',
                'activity' => 'Menyusun Proposal Program Security Awareness Bab 2 dan Bab 3 bagian 1',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-03-28',
                'activity' => 'Menyusun Proposal Program Security Awareness Bab 3 bagian 1',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-07',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-08',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-09',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-10',
                'activity' => 'Revisi matriks security awareness (penambahan kolom: media penyampaian, frekuensi, pelatihan dan sertifikasi)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Human Security Check Point [W2 April 2025] jam 08.30 - 09.30',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-11',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-14',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-14',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-14',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-15',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-15',
                'activity' => 'Revisi Matriks Security Awareness (penyesuaian dengan KKJ dan penambahan kolom: tingkat security awareness minimum, metode evaluasi)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025] jam 09.00 – 10.00',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025] jam 09.00 – 10.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-16',
                'activity' => 'Human Security Check Point [W3 April 2025] jam 09.00 – 10.00',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-17',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-18',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-21',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-21',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-21',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-22',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-04-22',
                'activity' => 'Revisi Matriks Security Awareness (metode evaluasi pencapaian program security awareness)',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Human Security Check Point [W4 April 2025] jam 08.00 – 09.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-04-23',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-24',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-28',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-29',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-04-30',
                'activity' => 'Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-02',
                'activity' => 'Human Security Check Point W1 Mei 2025 - STK Pendukung Program Security Awareness jam 14.00 – 15.00',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-05-02',
                'activity' => 'Human Security Check Point W1 Mei 2025 - STK Pendukung Program Security Awareness jam 14.00 – 15.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-02',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-05',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi (prosedur dan diagram alir)',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-05',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-06',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi (prosedur dan diagram alir)',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-06',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-08',
                'activity' => 'Human Security Check Point W1 Mei 2025 - TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning jam 09.00 – 10.00',
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-05-08',
                'activity' => 'Human Security Check Point W1 Mei 2025 - TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning jam 09.00 – 10.00',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-08',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-09',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-09',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-14',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-14',
                'activity' => 'Penambahan Timeline pada Proposal Kesadaran Keamanan Informasi dan revisi TKO sesuai dengan format PHE',
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Compile and review Deliverables ',
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025 dan Penyusunan Laporan Executive Summary WP 3.1',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-15',
                'activity' => 'Check point meeting',
            ],
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-05-16',
                'activity' => 'Compile and review Deliverables ',
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-05-16',
                'activity' => 'Compile and review Deliverables ',
            ],
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
