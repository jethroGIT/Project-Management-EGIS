<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timesheet32Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2025
        $timesheets = [
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-05',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],		
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-05',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-06',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-06',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-07',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-07',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-08',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-08',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-09',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-09',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-14',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-14',
                'activity' => 'Mapping pemetaan kompetensi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-05-15',
                'activity' => 'Human Security Check Point W2 Mei 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-16',
                'activity' => 'Menyusun Matriks Roadmap Pemenuhan Kompetensi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-16',
                'activity' => 'Menyusun: - Matriks Pemenuhan Kompetensi dan',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-05-16',
                'activity' => 'Revisi Daftar Distribusi menjadi Daftar Hadir Notulen Rapat',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-19',
                'activity' => 'Menyusun Matriks Roadmap Pemenuhan Kompetensi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-19',
                'activity' => '- Matriks Unmapped Role NICE Framework',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-20',
                'activity' => 'Menyusun Matriks Unmapped Role NICE Framework',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-21',
                'activity' => 'Menyusun Matriks Unmapped Role NICE Framework',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 16,'execution_date' => '2025-05-22',
                'activity' => '- Human Security Capabilities Development Check Point W3 Mei 2025 (Roadmap Kompetensi) dan 
                - Menyusun  dan pitch deck presentasi Pekerjaan WP 3.1 ',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-22',
                'activity' => '- Human Security Capabilities Development Check Point W3 Mei 2025 (Roadmap Kompetensi) dan 
                - Menyusun  dan pitch deck presentasi Pekerjaan WP 3.1 ',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-22',
                'activity' => '- Human Security Capabilities Development Check Point W3 Mei 2025 (Roadmap Kompetensi)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-05-22',
                'activity' => 'Human Security Capabilities Development Check Point W3 Mei 2025 (Roadmap Kompetensi)',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-23',
                'activity' => 'Menyusun Matriks Pemetaan Kompetensi (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-23',
                'activity' => 'Menyusun:- Matriks Pemetaan Kompetensi (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-05-23',
                'activity' => 'Membuat Notulen Rapat Checkpoint',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-26',
                'activity' => 'Menyusun Matriks Unmapped Role NICE Framework (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-26',
                'activity' => '- Matriks Unmapped Role NICE Framework (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-27',
                'activity' => 'Menyusun Matriks Roadmap Pemenuhan Kompetensi (update)',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-27',
                'activity' => '- Matriks Unmapped Role NICE Framework (update)',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-05-28',
                'activity' => 'Human Security Capabilities Development Check Point W4 Mei 2025 - Roadmap Kompetensi II',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-05-28',
                'activity' => 'Human Security Capabilities Development Check Point W4 Mei 2025 - Roadmap Kompetensi II',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-05-28',
                'activity' => 'Human Security Capabilities Development Check Point W4 Mei 2025 - Roadmap Kompetensi II',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-05-28',
                'activity' => 'Human Security Capabilities Development Check Point W4 Mei 2025 - Roadmap Kompetensi II dan Membuat Notulen Rapat Checkpoint',
                'duration' => 1.0
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-02',
                'activity' => 'Menyusun Matriks Roadmap Pemenuhan Kompetensi (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-03',
                'activity' => 'Menyusun Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 (draft awal)',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-04',
                'activity' => 'Menyusun Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 (draft awal)',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 16,'execution_date' => '2025-06-05',
                'activity' => 'Human Security Capabilities Development Check Point W1 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-05',
                'activity' => 'Human Security Capabilities Development Check Point W1 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-06-05',
                'activity' => 'Human Security Capabilities Development Check Point W1 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-06-05',
                'activity' => 'Human Security Capabilities Development Check Point W1 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-05',
                'activity' => 'Human Security Capabilities Development Check Point W1 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-10',
                'activity' => 'Menyusun Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-10',
                'activity' => 'Membuat Notulen Rapat Checkpoint',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-10',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-11',
                'activity' => 'Menyusun Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-11',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-12',
                'activity' => 'Menyusun Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 (update)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-12',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 16,'execution_date' => '2025-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-13',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-16',
                'activity' => 'Human Security Check Point W3 Juni 2025 - Roadmap Kompetensi Mapped to ISO 27021 & Run Through TKO',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-17',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-17',
                'activity' => 'Membuat Notulen Rapat Checkpoint',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-18',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-19',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-20',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-20',
                'activity' => 'Diskusi Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi & Development Program Planning',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-23',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-24',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-25',
                'activity' => 'Human Security Check Point W4 Juni 2025 - Diskusi Lanjutan Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-06-25',
                'activity' => 'Human Security Check Point W4 Juni 2025 - Diskusi Lanjutan Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-25',
                'activity' => 'Human Security Check Point W4 Juni 2025 - Diskusi Lanjutan Penyusunan TKO Pelaksanaan Program Kesadaran Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-26',
                'activity' => 'Update Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-06-26',
                'activity' => 'Membuat Notulen Rapat Checkpoint',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-26',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-06-30',
                'activity' => 'Update Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-06-30',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-01',
                'activity' => 'Update Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-01',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-02',
                'activity' => 'Update Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-02',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-03',
                'activity' => '[Check Point W1 Juli] Human Security Risk - Matriks Pemetaan ISO 27001, NICE, ISO27021',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 16,'execution_date' => '2025-07-03',
                'activity' => '[Check Point W1 Juli] Human Security Risk - Matriks Pemetaan ISO 27001, NICE, ISO27021',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-07-03',
                'activity' => '[Check Point W1 Juli] Human Security Risk - Matriks Pemetaan ISO 27001, NICE, ISO27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-03',
                'activity' => '[Check Point W1 Juli] Human Security Risk - Matriks Pemetaan ISO 27001, NICE, ISO27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-04',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-07-04',
                'activity' => 'Membuat Notulen Rapat Checkpoint',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-07',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi ',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-07-07',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-07',
                'activity' => 'Mapping Matriks Pemetaan NICE Framework-ISO 27021',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-08',
                'activity' => 'Update Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-09',
                'activity' => 'Menyampaikan TKO Pelaksanaan Program Kesadaran Keamanan Informasi dan Matriks Pemetaan ISO 27001-NICE Framework-ISO 27021 melalui email',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-10',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-07-10',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-10',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-11',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 16,'execution_date' => '2025-07-11',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 16,'execution_date' => '2025-07-11',
                'activity' => 'Menyusun Laporan Executive Summary WP 3.2',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-14',
                'activity' => 'Menyusun deck presentasi WP 3.2',
                'duration' => 0.5
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-15',
                'activity' => 'Menyusun deck presentasi WP 3.2',
                'duration' => 1
            ],
            [
                'user_id' => 2,'volume_id' => 16,'execution_date' => '2025-07-21',
                'activity' => 'Revisi TKO Pelaksanaan Program Kesadaran Keamanan Informasi dan menyampaikan via email',
                'duration' => 1
            ],
        ];
        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}