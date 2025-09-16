<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Timesheet52Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2025
        $timesheets = [
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-03',
                'activity' => 'Kajian awal ESA dengan pendekatan SABSA',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-04',
                'activity' => 'Kajian awal ESA dengan pendekatan SABSA',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-05',
                'activity' => 'Kajian awal ESA dengan pendekatan SABSA',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-06',
                'activity' => 'Review Existing Arsitektur Keamanan (Identifikasi lapisan arsitektur dari Enterprises Architecture yang sudah dibuat sebelumnya)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-07',
                'activity' => 'Review Existing Arsitektur Keamanan (Identifikasi lapisan arsitektur dari Enterprises Architecture yang sudah dibuat sebelumnya)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-10',
                'activity' => 'Review Existing Arsitektur Keamanan (Identifikasi lapisan arsitektur dari Enterprises Architecture yang sudah dibuat sebelumnya)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-11',
                'activity' => 'Review Existing Arsitektur Keamanan (Identifikasi lapisan arsitektur dari Enterprises Architecture yang sudah dibuat sebelumnya)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-12',
                'activity' => 'Review Existing Arsitektur Keamanan (Identifikasi lapisan arsitektur dari Enterprises Architecture yang sudah dibuat sebelumnya)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-13',
                'activity' => 'Review Existing Arsitektur Keamanan (Perbandingan tools yang digunakan untuk merancang ESA)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-14',
                'activity' => 'Review Existing Arsitektur Keamanan (Perbandingan tools yang digunakan untuk merancang ESA)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-17',
                'activity' => 'Identifikasi Stakeholder dan Business Drivers (Review Security Profile untuk inputan kebutuhan ESA)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-18',
                'activity' => 'Identifikasi Stakeholder dan Business Drivers (Review Security Profile untuk inputan kebutuhan ESA)',
                'duration' => 1
            ],
                [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-19',
                'activity' => 'Identifikasi Stakeholder dan Business Drivers (Review Security Profile untuk inputan kebutuhan ESA)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-20',
                'activity' => 'Identifikasi Stakeholder dan Business Drivers (Penentuan mekanisme Perancangan ESA dan tools yang digunakan seperti EA Sparx, Archi, atau Excel)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-21',
                'activity' => 'Identifikasi Stakeholder dan Business Drivers (Penentuan mekanisme Perancangan ESA dan tools yang digunakan seperti EA Sparx, Archi, atau Excel)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-24',
                'activity' => 'Analisis kesenjangan existing and target ESA (Studi Literatur Benchmarking dokumen penyusunan ESA dari penelitian terkait)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-25',
                'activity' => 'Analisis kesenjangan existing and target ESA (Studi Literatur Benchmarking dokumen penyusunan ESA dari penelitian terkait)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-26',
                'activity' => 'Analisis kesenjangan existing and target ESA (Studi Literatur Benchmarking dokumen penyusunan ESA dari penelitian terkait)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-03-27',
                'activity' => 'Analisis kesenjangan existing and target ESA (Studi Literatur Benchmarking dokumen penyusunan ESA dari penelitian terkait)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-08',
                'activity' => 'Perancangan Contextual Security Architecture (Menyusun template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-09',
                'activity' => 'Perancangan Contextual Security Architecture (Menyusun template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-10',
                'activity' => 'Perancangan Contextual Security Architecture (Menyusun template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-11',
                'activity' => 'Perancangan Contextual Security Architecture (Menyusun template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-14',
                'activity' => 'Perancangan Conceptual Security Architecture (Menyusun template arsitektur konseptual/ Conceptual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-15',
                'activity' => 'Perancangan Conceptual Security Architecture (Menyusun template arsitektur konseptual/ Conceptual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-16',
                'activity' => 'Perancangan Conceptual Security Architecture (Menyusun template arsitektur konseptual/ Conceptual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-17',
                'activity' => 'Perancangan Contextual Security Architecture (Mengupdate template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-18',
                'activity' => 'Perancangan Contextual Security Architecture (Mengupdate template arsitektur kontekstual/ Contextual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-21',
                'activity' => 'Evaluasi dokumen ESA yang sudah dikembangkan dan pemetaan ke setiap lapisan arsitektur',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-22',
                'activity' => 'Perancangan Logical Security Architecture (Menyusun template arsitektur logical/ Logical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-23',
                'activity' => 'Perancangan Conceptual Security Architecture (Menyusun template arsitektur logical/ Logical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-24',
                'activity' => 'Perancangan Conceptual Security Architecture (Mengupdate template arsitekture konseptual/ Conceptual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-25',
                'activity' => 'Perancangan Conceptual Security Architecture (Mengupdate template arsitekture konseptual/ Conceptual Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-28',
                'activity' => 'Perancangan Physical Security Architecture (Menyusun template arsitekture fisik/ Physical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-04-29',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-29',
                'activity' => 'Perancangan Physical Security Architecture (Menyusun template arsitekture fisik/ Physical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-04-29',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-04-29',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-04-30',
                'activity' => 'Perancangan Logical Security Architecture (Mengupdate template arsitektur logical/ Logical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-04-30',
                'activity' => 'Mapping CIS - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-04-30',
                'activity' => 'Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-02',
                'activity' => 'Perancangan Logical Security Architecture (Mengupdate template arsitektur logical/ Logical Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-02',
                'activity' => 'Mapping CIS - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-02',
                'activity' => 'Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-05',
                'activity' => 'Perancangan Component Security Architecture (Menyusun template arsitekture Komponen/ Component Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-05',
                'activity' => 'Mapping CIS - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-05',
                'activity' => 'Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-06',
                'activity' => 'Perancangan Component Security Architecture (Menyusun template arsitekture Komponen/ Component Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-06',
                'activity' => 'Mapping CIS - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-06',
                'activity' => 'Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-07',
                'activity' => 'Perancangan Physical Security Architecture (Mengupdate template arsitektur fisik/ physical security architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-07',
                'activity' => 'Mapping CIS - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-07',
                'activity' => 'Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-05-08',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-08',
                'activity' => 'Perancangan Physical Security Architecture (Mengupdate template arsitektur fisik/ physical security architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-05-08',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-08',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-08',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-09',
                'activity' => 'Perancangan Physical Security Architecture (Mengupdate template arsitektur fisik/ physical security architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-14',
                'activity' => 'Menyusun template arsitekture operasional (Operational Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-15',
                'activity' => 'Perancangan Operational Security Architecture (Menyusun template arsitekture operasional/ Operational Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-05-15',
                'activity' => 'Exercise Security Profile Assessment',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-05-16',
                'activity' => 'Internal - Exercise Pengisian Security Posture (Meeting)',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-16',
                'activity' => 'Perancangan Component Security Architecture (Mengupdate template arsitekture komponen Component Security Architecture)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-05-16',
                'activity' => 'Internal - Exercise Pengisian Security Posture (Meeting)',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-19',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Membuat laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 4,'volume_id' => 3,'execution_date' => '2025-05-19',
                'activity' => 'Exercise Security Posture Worksheet - KP PHE',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-20',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Membuat laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 4,'volume_id' => 3,'execution_date' => '2025-05-20',
                'activity' => 'Exercise Security Posture Worksheet - KP PHE',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-21',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Membuat laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-21',
                'activity' => 'Revisi Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-22',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Membuat laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-22',
                'activity' => 'Revisi Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-23',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Membuat laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-23',
                'activity' => 'Revisi Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-26',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-05-26',
                'activity' => 'Revisi Mapping C2M2 - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-27',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-05-28',
                'activity' => 'Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-02',
                'activity' => 'Analisis kesenjangan existing and target ESA (Validasi terkait exisiting EA dengan target EA yang diharapkan dengan dengan tim EA)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-06-03',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-03',
                'activity' => 'Analisis kesenjangan existing and target ESA (Validasi terkait exisiting EA dengan target EA yang diharapkan dengan dengan tim EA)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-06-03',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-06-03',
                'activity' => 'Progress Meeting - Security Posture & ESA',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-06-03',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-04',
                'activity' => 'Evaluasi dan pemetaan ESA (Evaluasi dan Pemetaan ESA untuk mendukung penyusunan Contextual Layer)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-05',
                'activity' => 'Evaluasi dan pemetaan ESA (Evaluasi dan Pemetaan ESA untuk mendukung penyusunan Contextual Layer)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-10',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melanjutkan validasi terkait exisiting EA dengan target EA yang diharapkan dengan dengan tim EA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-11',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melanjutkan validasi terkait exisiting EA dengan target EA yang diharapkan dengan dengan tim EA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-06-12',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-12',
                'activity' => '- Evaluasi dan pemetaan ESA (Evaluasi dan Pemetaan ESA untuk mendukung penyusunan Logical Layer)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-06-12',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-06-12',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-06-12',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-13',
                'activity' => '- Evaluasi dan pemetaan ESA (Evaluasi dan Pemetaan ESA untuk mendukung penyusunan Logical Layer)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-16',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melakukan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-06-17',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-17',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melakukan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-06-17',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-06-17',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-06-17',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-18',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melakukan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-19',
                'activity' => '- Evaluasi dan pemetaan ESA (Memetakan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-20',
                'activity' => '- Evaluasi dan pemetaan ESA (Memetakan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-23',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melanjutkan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-24',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melanjutkan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-25',
                'activity' => '- Evaluasi dan pemetaan ESA (Mlanjutkan pemetaan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-06-26',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-26',
                'activity' => '- Evaluasi dan pemetaan ESA (Mlanjutkan pemetaan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-06-26',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-06-26',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-06-26',
                'activity' => 'Checkpoint Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-06-30',
                'activity' => '- Tindak Lanjut dari hasil Kick-Off Meeting dan Pendefinisian Ruang Lingkup
                - Analisis kesenjangan existing and target ESA (Melanjutkan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-01',
                'activity' => 'Analisis kesenjangan existing and target ESA (Melanjutkan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-07-01',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-01',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-07-02',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-02',
                'activity' => '- Analisis kesenjangan existing and target ESA (Melanjutkan analisis kesenjangan exisiting EA dengan target EA yang meliputi semua layer ESA)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-07-02',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-07-02',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-02',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-07-03',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-03',
                'activity' => '- Evaluasi dan pemetaan ESA (Melanjutkan pemetaan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-07-03',
                'activity' => 'Checkpoint Finalisasi Enterprise Security Architecture & Security Posture',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-04',
                'activity' => '- Evaluasi dan pemetaan ESA (Melanjutkan pemetaan ESA untuk semua layer secara detail dalam tabel)
                - Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-07',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-08',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-09',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-10',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-11',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-14',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-15',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture as-is)',
                'duration' => 1
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-16',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 1,'volume_id' => 3,'execution_date' => '2025-07-17',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-17',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Mengupdate laporan penyusunan ESA dengan memasukan semua layer arsitekture to-be)',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 3,'execution_date' => '2025-07-17',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 3,'execution_date' => '2025-07-17',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-17',
                'activity' => 'Progress Meeting - Security Posture & Enterprise Security Architecture ',
                'duration' => 0.5
            ],
            [
                'user_id' => 8,'volume_id' => 3,'execution_date' => '2025-07-18',
                'activity' => '- Perancangan semua layer Security Enterprise Architecture (Membuat contoh kasus kasus penerapan Enterprsise Security Architecture pada sistem SCADA)',
                'duration' => 1
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-18',
                'activity' => 'Melengkapi Expected Implementation State - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-22',
                'activity' => 'Melengkapi Expected Implementation State - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
            [
                'user_id' => 12,'volume_id' => 3,'execution_date' => '2025-07-23',
                'activity' => 'Melengkapi Expected Implementation State - Security Profile Assessment Instrument',
                'duration' => 0.5
            ],
        ];
        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
