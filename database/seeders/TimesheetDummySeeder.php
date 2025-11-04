<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TimesheetDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timesheets = [
            // =========================================================================
            // Volume ID 1: WP 1.1 Analisis Kebutuhan Bisnis (Range: 2024-01-15 s.d. 2024-03-30)
            // =========================================================================
            [
                'user_id' => 1,
                'volume_id' => 1,
                'execution_date' => '2024-01-20',
                'activity' => 'Rapat kick-off internal dan alokasi tugas volume 1',
                'duration' => 1.0,
            ],
            [
                'user_id' => 2,
                'volume_id' => 1,
                'execution_date' => '2024-01-25',
                'activity' => 'Review dokumen Business Requirement (BRL) dari klien',
                'duration' => 1.5,
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-01-26',
                'activity' => 'Draft pertanyaan wawancara dengan stakeholder utama',
                'duration' => 2.0,
            ],
            [
                'user_id' => 4,
                'volume_id' => 1,
                'execution_date' => '2024-01-27',
                'activity' => 'Sinkronisasi data awal proyek di sistem manajemen',
                'duration' => 0.5,
            ],
            [
                'user_id' => 5,
                'volume_id' => 1,
                'execution_date' => '2024-01-28',
                'activity' => 'Penyiapan template dokumen Analisis Kebutuhan Bisnis (BRD)',
                'duration' => 1.0,
            ],
            [
                'user_id' => 3,
                'volume_id' => 1,
                'execution_date' => '2024-02-10',
                'activity' => 'Pelaksanaan Wawancara dengan VP Marketing',
                'duration' => 1.5,
            ],

            // =========================================================================
            // Volume ID 4: WP 2.2 Pengembangan Modul Inti Vol 1 (Range: 2024-08-01 s.d. 2024-11-20)
            // =========================================================================
            [
                'user_id' => 1,
                'volume_id' => 4,
                'execution_date' => '2024-08-05',
                'activity' => 'Pemantauan progress mingguan pengembangan API CRM',
                'duration' => 1.0,
            ],
            [
                'user_id' => 2,
                'volume_id' => 4,
                'execution_date' => '2024-08-10',
                'activity' => 'Review Design Skema Database Modul Pelanggan',
                'duration' => 1.0,
            ],
            [
                'user_id' => 3,
                'volume_id' => 4,
                'execution_date' => '2024-08-15',
                'activity' => 'Coding dan implementasi fungsi GET dan POST API',
                'duration' => 2.0,
            ],
            [
                'user_id' => 4,
                'volume_id' => 4,
                'execution_date' => '2024-08-16',
                'activity' => 'Penyiapan data dummy (mock data) untuk unit testing',
                'duration' => 1.5,
            ],
            [
                'user_id' => 5,
                'volume_id' => 4,
                'execution_date' => '2024-08-20',
                'activity' => 'Penulisan spesifikasi teknis API (Draft 1) untuk Modul CRM',
                'duration' => 1.0,
            ],
            [
                'user_id' => 3,
                'volume_id' => 4,
                'execution_date' => '2024-09-01',
                'activity' => 'Debugging pada endpoint PUT dan DELETE',
                'duration' => 1.5,
            ],
            [
                'user_id' => 2,
                'volume_id' => 4,
                'execution_date' => '2024-09-05',
                'activity' => 'Konsultasi keamanan arsitektur API',
                'duration' => 0.5,
            ],

            // =========================================================================
            // Volume ID 15: WP 6.1 Penyusunan Dokumentasi Pengguna Vol 2 (Range: 2025-01-05 s.d. 2025-04-10)
            // =========================================================================
            [
                'user_id' => 1,
                'volume_id' => 15,
                'execution_date' => '2025-01-10',
                'activity' => 'Perencanaan dan persetujuan jadwal produksi video tutorial',
                'duration' => 0.5,
            ],
            [
                'user_id' => 2,
                'volume_id' => 15,
                'execution_date' => '2025-01-15',
                'activity' => 'Review naskah video tutorial oleh Subject Matter Expert',
                'duration' => 1.0,
            ],
            [
                'user_id' => 3,
                'volume_id' => 15,
                'execution_date' => '2025-01-20',
                'activity' => 'Koordinasi dengan tim desain untuk aset visual video',
                'duration' => 1.5,
            ],
            [
                'user_id' => 4,
                'volume_id' => 15,
                'execution_date' => '2025-01-25',
                'activity' => 'Pencatatan dan verifikasi perubahan fitur untuk update video',
                'duration' => 1.0,
            ],
            [
                'user_id' => 5,
                'volume_id' => 15,
                'execution_date' => '2025-02-01',
                'activity' => 'Perekaman voice-over untuk video tutorial',
                'duration' => 2.0,
            ],
            [
                'user_id' => 5,
                'volume_id' => 15,
                'execution_date' => '2025-02-05',
                'activity' => 'Proses editing dan sinkronisasi audio-visual',
                'duration' => 1.5,
            ],
            [
                'user_id' => 4,
                'volume_id' => 15,
                'execution_date' => '2025-02-10',
                'activity' => 'Uji coba pemutaran video di berbagai platform',
                'duration' => 0.5,
            ]
        ];

        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
