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
        // $tasks = [
        //     //3.1 task 1-7
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Analisis kebutuhan program security awareness',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Identifikasi stakeholder dan kebutuhannya terhadap program security awareness',
        //         'status' => 'closed', 
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Sumber daya yang dibutuhkan dalam program security awareness',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Penentuan cara penyampaian program security awareness',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Penetapan tingkat security awareness minimum',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Metode evaluasi pencapaian program security awareness',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 15,
        //         'name' => 'Penyusunan STK tentang program security awareness',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     // 3.2 task 8-'10
        //     [
        //         'volume_id' => 16,
        //         'name' => 'Pemetaan kompetensi pada stakeholder',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 16,
        //         'name' => 'Analisis kebutuhan peningkatan kompetensi pada stakeholder',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 16,
        //         'name' => 'Roadmap pemenuhan kompetensi pada stakeholder',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     // 5.2 task 11-13
        //     [
        //         'volume_id' => 32,
        //         'name' => 'Studi Framework Enterprise Security Architecture - Perencanaan dan Kick-Off',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 32,
        //         'name' => 'Analisis Dan Penentuan Enterprise Security Framework PHE - Analisis Kebutuhan ESA',
        //         'status' => 'closed',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 32,
        //         'name' => 'Penyusunan Enterprise Security Framework PHE',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     // 6.2 task 14-17
        //     [
        //         'volume_id' => 43,
        //         'name' => 'INISIASI/HASIL PENDEFINISIAN LINGKUP',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 43,
        //         'name' => 'PERSIAPAN',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 43,
        //         'name' => 'PELAKSANAAN',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     [
        //         'volume_id' => 43,
        //         'name' => 'PENINJAUAN',
        //         'status' => 'open',
        //         'completeness' => null,
        //     ],
        //     // 9.1 task 18-47
        //     ['volume_id' => 59,'name' => 'POKOK-POKOK PERJANJIAN','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'Serbaaneka informasi','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'Lampiran A: KETENTUAN – KETENTUAN UMUM','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'Lampiran A: KETENTUAN – KETENTUAN KHUSUS','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN B - URAIAN DAN LINGKUP PEKERJAAN','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN B.1 - DAFTAR DAN SPESIFIKASI TEKNIS BARANG DAN JASA','status' => 'closed','completeness' => 80.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN B.2 - SYARAT KONTRAKTOR PEKERJAAN DAN TENAGA KERJA','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN B.3 - SYARAT DAN KETENTUAN KHUSUS','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN 2 - KRITERIA EVALUASI TEKNIS','status' => 'open','completeness' => 80.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN B.4 - PERSYARATAN JAMINAN KEAMANAN INFORMASI DALAM
        //     PENYEDIAAN BARANG/JASA OLEH KONTRAKTOR KEPADA PERUSAHAAN','status' => 'closed','completeness' => 50.00,],
        //     ['volume_id' => 59,'name' => 'Lampiran B.5 - RoTE','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN C - KOMPENSASI DAN PEMBAYARAN
        //     (Rincian Harga Kontrak & Ketentuan)','status' => 'open','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN C1 Rincian Harga Kontrak dan Ketentuan','status' => 'open','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => '7. ctem_lampiran c2 - Harga Kontrak Dan Ketentuan Pembayaran','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'EXHIBIT C.3 - TINGKAT KOMPONEN DALAM NEGERI','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN D - JADWAL PELAKSANAAN PEKERJAAN','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN E - MANAJEMEN KINERJA KONTRAKTOR/Asuransi','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN E.1 - EVALUASI KINERJA PENYEDIA JASA - SPR (SERVICE PERFORMANCE REVIEW)','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN F - INSURANCE REQUIREMENT','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN G - FORMULIR-FORMULIR STANDAR','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'LAMPIRAN H - KETENTUAN KEBIJAKAN KESEHATAN, XKESELAMATAN
        //     KERJA DAN LINDUNGAN LINGKUNGAN (K3LL)','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'EXHIBIT E,F,G, - INSURANCE REQUIREMENT','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'Presentasi','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'BoQ','status' => 'closed','completeness' => 100.00,],
        //     ['volume_id' => 59,'name' => 'Dokumen Kajian','status' => 'open','completeness' => 35.00,],
        //     ['volume_id' => 59,'name' => 'HPS/OE Development','status' => 'open','completeness' => 70.00,],
        //     ['volume_id' => 59,'name' => 'Demo Principal','status' => 'open','completeness' => 72.00,],
        //     ['volume_id' => 59,'name' => 'Local Partner Contact','status' => 'open','completeness' => 60.00,],
        //     ['volume_id' => 59,'name' => 'Principal Docs','status' => 'open','completeness' => 52.00,],
        //     ['volume_id' => 59,'name' => 'Lampiran B.6','status' => 'open','completeness' => 30.00,],
        // ];

        $tasks = [
            // Volume ID 1 (WP 1.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 1,
                'name' => 'Wawancara Tahap Awal dengan Divisi Marketing',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Wawancara Tahap Awal dengan Divisi Operasional',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 1,
                'name' => 'Kompilasi dan Validasi Data Kebutuhan Awal',
                'status' => 'open',
                'completeness' => 85.00,
            ],

            // Volume ID 2 (WP 1.2 Volume 1) - 4 Tasks (2 dengan Sub Task)
            [
                'volume_id' => 2,
                'name' => 'Identifikasi Semua Aktivitas & Ketergantungan',
                'status' => 'closed',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 2,
                'name' => 'Penentuan Durasi dan Estimasi Sumber Daya',
                'status' => 'open',
                'completeness' => 60.00,
            ],
            [
                'volume_id' => 2,
                'name' => 'Penyusunan Struktur WBS (Work Breakdown Structure) Draft 1',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 2,
                'name' => 'Review dan Finalisasi Project Charter',
                'status' => 'open',
                'completeness' => 30.00,
            ],

            // Volume ID 3 (WP 2.1 Volume 1) - 2 Tasks
            [
                'volume_id' => 3,
                'name' => 'Perancangan Struktur Database PostgreSQL',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 3,
                'name' => 'Finalisasi Desain Arsitektur Microservices',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 4 (WP 2.2 Volume 1) - 4 Tasks (1 dengan Sub Task)
            [
                'volume_id' => 4,
                'name' => 'Setup Lingkungan Pengembangan (Development Environment)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 4,
                'name' => 'Pengembangan Endpoint (CRUD) Modul Pelanggan',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 4,
                'name' => 'Implementasi Mekanisme Autentikasi',
                'status' => 'open',
                'completeness' => 45.00,
            ],
            [
                'volume_id' => 4,
                'name' => 'Unit Testing Modul Pelanggan',
                'status' => 'open',
                'completeness' => 0.00,
            ],

            // Volume ID 5 (WP 2.2 Volume 2) - 3 Tasks
            [
                'volume_id' => 5,
                'name' => 'Perancangan Antarmuka Pengguna (UI/UX) Inventory',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 5,
                'name' => 'Coding Frontend Daftar Stok Barang',
                'status' => 'open',
                'completeness' => 65.00,
            ],
            [
                'volume_id' => 5,
                'name' => 'Integrasi API dengan Halaman Transaksi',
                'status' => 'open',
                'completeness' => 20.00,
            ],

            // Volume ID 6 (WP 2.2 Volume 3) - 2 Tasks
            [
                'volume_id' => 6,
                'name' => 'Analisis dan Pemilihan Mitra Pembayaran (Gateway)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 6,
                'name' => 'Implementasi Library Integrasi Pembayaran',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 7 (WP 3.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 7,
                'name' => 'Pembuatan Kasus Uji (Test Cases) untuk Modul CRM',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 7,
                'name' => 'Pembuatan Data Uji (Test Data)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 7,
                'name' => 'Review Kasus Uji oleh Tim Pengembangan',
                'status' => 'open',
                'completeness' => 90.00,
            ],

            // Volume ID 8 (WP 3.1 Volume 2) - 4 Tasks (2 dengan Sub Task)
            [
                'volume_id' => 8,
                'name' => 'Persiapan Lingkungan UAT dan Data Master',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 8,
                'name' => 'Eksekusi Sesi UAT oleh Pengguna (Minggu 1)',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 8,
                'name' => 'Kompilasi dan Triage Laporan Bug dari UAT',
                'status' => 'open',
                'completeness' => 40.00,
            ],
            [
                'volume_id' => 8,
                'name' => 'Verifikasi Perbaikan Bug Utama',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            
            // Volume ID 9 (WP 4.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 9,
                'name' => 'Perumusan Konsep Konten (Messaging)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 9,
                'name' => 'Desain Grafis untuk 10 Konten Media Sosial',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 9,
                'name' => 'Review dan Feedback Desain Grafis',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 10 (WP 4.1 Volume 2) - 2 Tasks
            [
                'volume_id' => 10,
                'name' => 'Pembuatan Storyboard Video Promosi',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 10,
                'name' => 'Pengambilan dan Editing Footage Video (Drafting)',
                'status' => 'open',
                'completeness' => 75.00,
            ],

            // Volume ID 11 (WP 4.1 Volume 3) - 2 Tasks
            [
                'volume_id' => 11,
                'name' => 'Peninjauan Legalitas Materi Iklan',
                'status' => 'open',
                'completeness' => 90.00,
            ],
            [
                'volume_id' => 11,
                'name' => 'Pengajuan Persetujuan Akhir Manajemen',
                'status' => 'open',
                'completeness' => 60.00,
            ],

            // Volume ID 12 (WP 4.2 Volume 1) - 2 Tasks
            [
                'volume_id' => 12,
                'name' => 'Setup Akun Iklan dan Targeting Audiens',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 12,
                'name' => 'Monitoring dan Optimasi Kampanye Minggu 1-4',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 13 (WP 5.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 13,
                'name' => 'Pengumpulan Data Biaya SDM dan Perangkat Keras',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 13,
                'name' => 'Perhitungan Biaya Tak Terduga (Contingency)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 13,
                'name' => 'Penyusunan Draf Anggaran Akhir',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 14 (WP 6.1 Volume 1) - 3 Tasks (1 dengan Sub Task)
            [
                'volume_id' => 14,
                'name' => 'Penulisan Draf Manual Pengguna (Fungsi Dasar)',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 14,
                'name' => 'Penulisan Draf Manual Pengguna (Fungsi Lanjutan)',
                'status' => 'open',
                'completeness' => 40.00,
            ],
            [
                'volume_id' => 14,
                'name' => 'Pengumpulan Tangkapan Layar Aplikasi',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 15 (WP 6.1 Volume 2) - 2 Tasks
            [
                'volume_id' => 15,
                'name' => 'Pembuatan Naskah dan Rekaman Suara Video Tutorial',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 15,
                'name' => 'Editing dan Render Video Tutorial Akhir',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 16 (WP 6.2 Volume 1) - 3 Tasks
            [
                'volume_id' => 16,
                'name' => 'Pemilihan Spesifikasi Layanan Cloud (VM/Storage)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 16,
                'name' => 'Konfigurasi Jaringan dan Keamanan Dasar',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 16,
                'name' => 'Deployment Aplikasi Tahap Awal',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 17 (WP 7.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 17,
                'name' => 'Pengumpulan dan Verifikasi Dokumen Legalitas Awal',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 17,
                'name' => 'Pengajuan Dokumen Izin ke Dinas Terkait',
                'status' => 'open',
                'completeness' => 70.00,
            ],
            [
                'volume_id' => 17,
                'name' => 'Follow Up dan Pemeriksaan Lapangan (Jika Ada)',
                'status' => 'open',
                'completeness' => 50.00,
            ],

            // Volume ID 18 (WP 8.1 Volume 1) - 2 Tasks
            [
                'volume_id' => 18,
                'name' => 'Perancangan Kuesioner Survei Versi Final',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 18,
                'name' => 'Penentuan Metodologi Sampling Pengguna',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 19 (WP 8.1 Volume 2) - 3 Tasks (2 dengan Sub Task)
            [
                'volume_id' => 19,
                'name' => 'Setup Platform Survei Online',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 19,
                'name' => 'Pengiriman Email Kuesioner ke Responden Target',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],
            [
                'volume_id' => 19,
                'name' => 'Follow up Responden dan Reminder',
                'status' => 'open',
                'completeness' => null, // Ada Sub Task
            ],

            // Volume ID 20 (WP 8.1 Volume 3) - 2 Tasks
            [
                'volume_id' => 20,
                'name' => 'Pembersihan dan Validasi Data Survei',
                'status' => 'open',
                'completeness' => 0.00,
            ],
            [
                'volume_id' => 20,
                'name' => 'Penyusunan Laporan Hasil Analisis (Draft)',
                'status' => 'open',
                'completeness' => 0.00,
            ],

            // Volume ID 21 (WP 9.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 21,
                'name' => 'Persiapan Materi Presentasi Pelatihan',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 21,
                'name' => 'Setup Akun dan Sesi di Platform Daring (Zoom/Meet)',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 21,
                'name' => 'Pengiriman Undangan dan Materi Pra-Pelatihan',
                'status' => 'closed',
                'completeness' => 100.00,
            ],

            // Volume ID 22 (WP 9.1 Volume 2) - 2 Tasks
            [
                'volume_id' => 22,
                'name' => 'Pelaksanaan Sesi Pelatihan Hari ke-1',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 22,
                'name' => 'Pelaksanaan Sesi Pelatihan Hari ke-2',
                'status' => 'open',
                'completeness' => 60.00,
            ],

            // Volume ID 23 (WP 10.1 Volume 1) - 3 Tasks
            [
                'volume_id' => 23,
                'name' => 'Koordinasi Jadwal dan Logistik Pengiriman ke Lokasi 1',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 23,
                'name' => 'Instalasi Server Utama di Lokasi 1',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
            [
                'volume_id' => 23,
                'name' => 'Verifikasi Koneksi dan Uji Coba Jaringan di Lokasi 1',
                'status' => 'closed',
                'completeness' => 100.00,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        };
    }
}
