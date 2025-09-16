<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timesheet62Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timesheets = [
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-4',
                'activity' => 'Drafting Materi Kick-Off Surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-5',
                'activity' => 'Drafting MLE Surveillance 2',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-6',
                'activity' => 'Drafting MLE Surveillance 2 Drafting materi kick-off meeting',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-6',
                'activity' => 'Updating ISO Surveillance Deck (Kick-Off)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-03-6',
                'activity' => 'Updating ISO Surveillance Deck (Kick-Off)',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-03-7',
                'activity' => 'koordinasi internal initial ISO',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-03-7',
                'activity' => 'koordinasi internal initial ISO',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-7',
                'activity' => 'Half-day, drafting MLE surveillance 2, finishing initial materi kick off koordinasi internal initial ISO - review materi kick-off with MY',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-03-7',
                'activity' => 'Updating MLE Surveillance 2',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-03-7',
                'activity' => 'Diskusi Internal Initial ISO Updating MLE Surveillance 2',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-03-10',
                'activity' => 'Updating MLE Surveillance 2',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-03-10',
                'activity' => 'Updating MLE Surveillance 2',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO Surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO Surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO surveillance Updating ISO Surveillance Deck (Kick-Off)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-03-13',
                'activity' => 'Initial meeting ISO surveillance',
                'duration' => 0.5
                ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-14',
                'activity' => 'updating iso survelliance deck (kick-off) persiapan MLE (inisial) untuk ISO surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-14',
                'activity' => 'updating iso survelliance deck (kick-off) persiapan MLE (inisial) untuk ISO surveillance',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-03-14',
                'activity' => 'Updating MLE Surveillance 2',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-21',
                'activity' => 'Initial checking on ISO Core Records (identifiy)',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-21',
                'activity' => 'Initial checking on ISO Core Records (identifiy)',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-24',
                'activity' => 'ISMS Manual - Initial Revisit',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-24',
                'activity' => 'ISMS Manual - Initial Revisit',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-03-25',
                'activity' => 'Identifikasi STK IT Busol, terkait plan untuk develop STK DevSecOps',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-03-25',
                'activity' => 'Identifikasi STK IT Busol, terkait plan untuk develop STK DevSecOps',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-8',
                'activity' => 'Review, initial revisit draft awal SoA 2025',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-9',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-04-9',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-9',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-9',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-10',
                'activity' => 'Initial drafting materi MR Q2 2025 Meeting dengan Equinne STK DevSecOps (diskusi awal)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-10',
                'activity' => 'Cek Regulatory Register Review Capacity Plan Meeting dengan Equinne STK DevSecOps (diskusi awal)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-10',
                'activity' => 'Meeting dengan Equinne STK DevSecOps (diskusi awal)',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-14',
                'activity' => 'drafting materi MR Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-14',
                'activity' => 'Mengolah data survey awareness',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-14',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-15',
                'activity' => 'drafting materi MR Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-15',
                'activity' => 'Mengolah data survey awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-15',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-16',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-16',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-16',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-17',
                'activity' => 'drafting materi MR Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-17',
                'activity' => 'Mengolah data survey awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-17',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-22',
                'activity' => 'Cek bahan kebutuhan MR',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-22',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-23',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-24',
                'activity' => 'Pembuatan Draft Broadcast Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-04-29',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-04-29',
                'activity' => 'Checkpoint Meeting ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-04-30',
                'activity' => 'Meeting Project Update ISO Tools & RKS ISO',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-2',
                'activity' => 'Identifikasi monitoring rutin untuk IS Objective, IS Communication, dan IS RTP Monitoring',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-5',
                'activity' => 'Identifikasi monitoring rutin untuk IS Objective, IS Communication, dan IS RTP Monitoring',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-6',
                'activity' => 'Membuat Draft Broadcat Security Awareness',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-05-7',
                'activity' => 'Checkpoint ISO 27001:2022 [W1 Mei 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-05-7',
                'activity' => 'Checkpoint ISO 27001:2022 [W1 Mei 2025] Update dokumen Regalutory Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-7',
                'activity' => 'Checkpoint ISO 27001:2022 [W1 Mei 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-05-8',
                'activity' => 'Updating materi MR Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-05-9',
                'activity' => 'Checkpoint ISO 27001:2022 [W1 Mei 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-05-14',
                'activity' => 'Finalisasi materi MR Q2 2025 Inisiasi gathering evidence on CSAA, DCCI (aktivitas rutin dari IS Objective dan RTP Eksisting)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-05-15',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-15',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-05-16',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-16',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-19',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-05-20',
                'activity' => 'Meeting dengan IT Busol, inisial pembangunan STK DevSecOps',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-05-20',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-2',
                'activity' => 'Identifikasi dokumentasi Devsecops ISO 27001',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-3',
                'activity' => 'Meeting STK DevSecOps',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-3',
                'activity' => 'Meeting STK DevSecOps',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-4',
                'activity' => 'Progress Meeting - ISO/IEC 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-4',
                'activity' => 'Progress Meeting - ISO/IEC 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-4',
                'activity' => 'Progress Meeting - ISO/IEC 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-5',
                'activity' => 'Mencari dan melengkapi peraturan terkait cyber security',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-10',
                'activity' => 'Management Review Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-10',
                'activity' => 'Management Review Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-10',
                'activity' => 'Management Review Q2 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-11',
                'activity' => 'Identifikasi referensi awal untuk:
                - prosedur/pedoman MEAP ISMS 
                - prosedur dokumentasi informasi (terkait OFI IA 2024)
                Updating Draft Materi Kick-Off Surveillance',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-12',
                'activity' => 'Checkpoint ISO 27001:2022 [W2 Juni 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-12',
                'activity' => '- Checkpoint ISO 27001:2022 [W2 Juni 2025]
                - Revisit ISMS Manual
                - Update MLE',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-12',
                'activity' => 'Checkpoint ISO 27001:2022 [W2 Juni 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-13',
                'activity' => '- Update Regulatory Compliance
                - Update MLE',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-16',
                'activity' => 'Checkpoint ISO 27001:2022 [W3 Juni 2025]',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-16',
                'activity' => '- Updating Capacity Plan sesuai scope 2025
                - Checkpoint ISO 27001:2022 [W3 Juni 2025]
                Update MLE',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-16',
                'activity' => '- Checkpoint ISO 27001:2022 [W3 Juni 2025]
                - Membuat Draft Broadcast',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-17',
                'activity' => '- Membuat Draft Broadcast ',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-18',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-18',
                'activity' => '- Checkpoint ISO 27001:2022
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-18',
                'activity' => '- Checkpoint ISO 27001:2022
                - Update MLE',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-06-19',
                'activity' => 'Kick Off Meeting',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-06-19',
                'activity' => 'Kick Off Meeting',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-19',
                'activity' => 'Kick Off Meeting',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-19',
                'activity' => '- Kick Off Meeting
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-19',
                'activity' => '- Kick Off Meeting
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-06-20',
                'activity' => 'Awareness ISO 27001',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-06-20',
                'activity' => 'Awareness ISO 27001',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-20',
                'activity' => 'Awareness ISO 27001',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-20',
                'activity' => '- Awareness ISO 27001
                - Mengubah MLE Excel menjadi Planner
                - drafting laporan pelaksanaan awareness 27001 tahun 2025',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-20',
                'activity' => '- Awareness ISO 27001
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-23',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-23',
                'activity' => '- Checkpoint ISO 27001:2022
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-23',
                'activity' => '- Checkpoint ISO 27001:2022
                - Mengubah MLE Excel menjadi Planner',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-24',
                'activity' => 'Updating Planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-24',
                'activity' => 'Revisi Draft Broadcast',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => 'Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => 'Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 ',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => 'Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => 'Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => '- Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 
                - Updating Planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-25',
                'activity' => 'Meeting Identifikasi dan Penjelasan Kebutuhan Persyaratan Lingkup Baru Implementasi ISO/IEC 27001:2022 Y2025 
                - Updating Planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-26',
                'activity' => 'Revisi Draft Broadcast',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-06-30',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-06-30',
                'activity' => '- Checkpoint ISO 27001:2022
                - updating planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-06-30',
                'activity' => '- Checkpoint ISO 27001:2022
                - updating planner',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-1',
                'activity' => '- updating planner 
                - copy evidence update if needed',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-1',
                'activity' => '- updating planner
                - copy evidence update if needed',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-07-2',
                'activity' => 'Sosialisasi MLE (All Non IT OPS)',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-2',
                'activity' => '- Sosialisasi MLE (All Non IT OPS)
                - Update SOA',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-2',
                'activity' => '- Sosialisasi MLE (All Non IT OPS)
                - updating planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-2',
                'activity' => 'Sosialisasi MLE (All Non IT OPS)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-3',
                'activity' => '- updating planner 
                - copy evidence update if needed',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-3',
                'activity' => '- updating planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-07-4',
                'activity' => 'Sosialisasi MLE (All IT OPS)',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-4',
                'activity' => 'Sosialisasi MLE (All IT OPS)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-4',
                'activity' => 'Sosialisasi MLE (All IT OPS)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-4',
                'activity' => 'Sosialisasi MLE (All IT OPS)',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-7',
                'activity' => 'Checkpoint ISO 27001:2022 ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-7',
                'activity' => '- Checkpoint ISO 27001:2022 
                - updating planner based on permintaan PHE pada rapat tanggal 4 Juli (ref: MoM)
                - updating planner, request penambahan pic G&P',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-7',
                'activity' => 'Checkpoint ISO 27001:2022 
                - updating planner based on permintaan PHE pada rapat tanggal 4 Juli (ref: MoM)',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-8',
                'activity' => 'Update planner.
                Review records di planner',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-8',
                'activity' => 'updating planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-8',
                'activity' => 'Slide Konsep Untuk TKO Pengelolaan Informasi Terdokumentasi
                Konsep Untuk TKO Pengelolaan Informasi Terdokumentasi',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-9',
                'activity' => 'updating planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-07-10',
                'activity' => 'Three Ways Discussion ISO 27001:2022 New Scope Implementation - Secure Application Services',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-07-10',
                'activity' => 'Three Ways Discussion ISO 27001:2022 New Scope Implementation - Secure Application Services',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-10',
                'activity' => 'Three Ways Discussion ISO 27001:2022 New Scope Implementation - Secure Application Services',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-10',
                'activity' => '- Three Ways Discussion ISO 27001:2022 New Scope Implementation - Secure Application Services
                - updating planner request penambahan pic EUS tanggal 10 Juli 2025
                - update lembar pengesahan based on isms manual
                - update capacity plan',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-10',
                'activity' => '- Three Ways Discussion ISO 27001:2022 New Scope Implementation - Secure Application Services
                - rechecking planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => 'Checkpoint Penyusunan STK',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => 'Checkpoint Penyusunan STK',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => 'Checkpoint Penyusunan STK',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => '- Checkpoint Penyusunan STK
                - updating planner',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => 'Checkpoint Penyusunan STK',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-11',
                'activity' => 'Checkpoint Konsep Untuk TKO Pengelolaan Informasi Terdokumentasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-14',
                'activity' => '- [DRAFT Awal] TKO Pengelolaan Informasi Terdokumentasi_v.0.1
                - Konsep Untuk TKO Evaluasi & Pengukuran Kinerja ISMS
                - Reviu B10-012_PHE53000_2023-S9 Rev.0 TKO Pengelolaan Risiko Keamanan Informasi v.4b',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => '- Checkpoint ISO 27001:2022
                - update rundown workshop (list STK)
                - update planner add dama personil',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-15',
                'activity' => 'Konsep Untuk Pedoman Rewards & Punishment Keamanan Informasi',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-16',
                'activity' => 'Inisial review draft TKO DevSecOps (yang dibangun oleh Equinne, Divusi sbg konsultan Egis memberi masukan/ make sure bahwa TKO align dengan ISO 27001)',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-16',
                'activity' => '[DRAFT Awal] TKO Evaluasi & Pengukuran Kinerja ISMS_v.0.1',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-17',
                'activity' => '- drafting materi workshop
                - update planner ubah label IA jadi IT BR',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-17',
                'activity' => '[DRAFT Awal] Pedoman Rewards & Punishment Keamanan Informasi_v.0.1',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-18',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-18',
                'activity' => '- Checkpoint ISO 27001:2022
                - updating materi workshop',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-07-18',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-21',
                'activity' => 'Reviu A10-009_PHE53000_2022-S9 Rev.1 Pedoman Pengelolaan Keamanan Informasi',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-22',
                'activity' => 'Reviu A10-022_PHE53000_2023-S9 Rev.0 Pedoman Pengendalian KI Aspek Organisasi - A5 upd',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-23',
                'activity' => 'Reviu A10-023_PHE53000_2023-S9 Rev.0 Pedoman Pengendalian KI Aspek Personil - A6',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-24',
                'activity' => 'Reviu A10-024_PHE53000_2023-S9 Rev.0 Pedoman Pengendalian KI Aspek Fisik - A7',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-07-28',
                'activity' => 'Perbaikan A10-022_PHE53000_2023-S9 Rev.0 Pedoman Pengendalian KI Aspek Organisasi - A5 upd (Privasi & PDP)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-29',
                'activity' => 'Formatting IS Objectives',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-07-30',
                'activity' => 'Finalisasi ISMS Manual (Melengkapi metriks KPI ISMS Efficacy)',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-30',
                'activity' => 'Formatting IS Objectives',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-07-31',
                'activity' => 'Updating Planner (add new member dama based on request 31 Juli 2025)',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-4',
                'activity' => 'Rekap Compliance SDLC',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-5',
                'activity' => 'Finalisasi ISMS Manual (perapihan, Konfirmasi metriks KPI ISMS Efficacy)
                Lanjutan perapihan RR ISMS',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-5',
                'activity' => 'Rekap Compliance SDLC',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-6',
                'activity' => 'Cekpoin ISO
                Lanjutan finalisasi Risk Register',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-6',
                'activity' => '- Checkpoint ISO 27001:2022
                - Updating SoA berdasarkan kesepakatan pada Workshop Mercure',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-6',
                'activity' => 'Checkpoint ISO 27001:2022',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-7',
                'activity' => 'Finalisasi IS RR + RTP',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-7',
                'activity' => 'Perapihan IS Risk Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-7',
                'activity' => 'Perapihan IS Risk Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-8',
                'activity' => 'Finalisasi Draft TKO Insiden KI, TKO Configuration Management ',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-08-8',
                'activity' => 'Konsep Untuk Pedoman Pertukaran Informasi dalam Proses Merger & Akuisisi',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-08-10',
                'activity' => '[DRAFT Awal] Pedoman Pertukaran Informasi dalam Proses Merger & Akuisisi',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 5,'execution_date' => '2025-08-11',
                'activity' => 'Diskusi Internal, Finalisasi Core Records:
                - KPI Efficacy ISMS
                - Risk Register
                - IS Objectives',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-11',
                'activity' => 'Diskusi Internal + Perapihan Finalisasi Core Records:
                - KPI Efficacy ISMS
                - Risk Register
                - IS Objectives',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-11',
                'activity' => 'Perapihan RTP di Risk Register based on hasil diskusi internal',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-12',
                'activity' => 'Finalisasi & Percepatan Penyelesaian Dokumentasi ISO, offline meeting di PHE',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-08-12',
                'activity' => 'Finalisasi & Percepatan Penyelesaian Dokumentasi ISO, offline meeting di PHE',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-12',
                'activity' => 'Finalisasi & Percepatan Penyelesaian Dokumentasi ISO, offline meeting di PHE',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-08-12',
                'activity' => 'FGD Pembahasan STK ISO/IEC 27001:2022 (onsite) ',
                'duration' => 1
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-13',
                'activity' => 'Physical Assessment ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 5,'execution_date' => '2025-08-13',
                'activity' => 'Physical Assessment ISO 27001:2022',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-13',
                'activity' => '- Perapihan TKI Pengelolaan Otentikasi Aman Perangkat Keamanan Cyber Security
                - Penyesuaian annex RR RTP',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-14',
                'activity' => 'Update SoA, Update RR, Update (tbd) IS Objectives hasil diskusi 12 Agustus
                Update Regulatory Register, pengisian singkat risiko dan sanksi',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-14',
                'activity' => '- Penyesuaian annex RR dan RTP
                - Update Regulatory Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-14',
                'activity' => 'Perapihan annex RR RTP
                Update Regulatory Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 13,'volume_id' => 5,'execution_date' => '2025-08-15',
                'activity' => 'Lanjutan Update (final up to PHE) IS Objectives hasil diskusi 12 Agustus
                Update Regulatory Register, pengisian singkat risiko dan sanksi, update minor ISMS Manual',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 5,'execution_date' => '2025-08-15',
                'activity' => '- Penyesuaian Annex RR dan RTP dengan SoA',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 5,'execution_date' => '2025-08-15',
                'activity' => 'Update Regulatory Register',
                'duration' => 0.5
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-08-15',
                'activity' => 'Pembahasan STK Secure Development Lifecycle (DevSecOps) - IT Busol & IBM (Online)',
                'duration' => 1
            ],
            [
                'user_id' => 6,'volume_id' => 5,'execution_date' => '2025-08-20',
                'activity' => '[DRAFT Awal] Perbaikan Pedoman Pertukaran Informasi dalam Proses Merger & Akuisisi',
                'duration' => 1
            ],
        ];
        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
