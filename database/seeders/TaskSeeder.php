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
        $tasks = [
            //3.1 task 1-7
            [
                'volume_id' => 15,
                'name' => 'Analisis kebutuhan program security awareness',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Identifikasi stakeholder dan kebutuhannya terhadap program security awareness',
                'status' => 'closed', 
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Sumber daya yang dibutuhkan dalam program security awareness',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Penentuan cara penyampaian program security awareness',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Penetapan tingkat security awareness minimum',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Metode evaluasi pencapaian program security awareness',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 15,
                'name' => 'Penyusunan STK tentang program security awareness',
                'status' => 'closed',
                'completeness' => null,
            ],
            // 3.2 task 8-'10
            [
                'volume_id' => 16,
                'name' => 'Pemetaan kompetensi pada stakeholder',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 16,
                'name' => 'Analisis kebutuhan peningkatan kompetensi pada stakeholder',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 16,
                'name' => 'Roadmap pemenuhan kompetensi pada stakeholder',
                'status' => 'closed',
                'completeness' => null,
            ],
            // 5.2 task 11-13
            [
                'volume_id' => 32,
                'name' => 'Studi Framework Enterprise Security Architecture - Perencanaan dan Kick-Off',
                'status' => 'open',
                'completeness' => null,
            ],
            [
                'volume_id' => 32,
                'name' => 'Analisis Dan Penentuan Enterprise Security Framework PHE - Analisis Kebutuhan ESA',
                'status' => 'closed',
                'completeness' => null,
            ],
            [
                'volume_id' => 32,
                'name' => 'Penyusunan Enterprise Security Framework PHE',
                'status' => 'open',
                'completeness' => null,
            ],
            // 6.2 task 14-17
            [
                'volume_id' => 43,
                'name' => 'INISIASI/HASIL PENDEFINISIAN LINGKUP',
                'status' => 'open',
                'completeness' => null,
            ],
            [
                'volume_id' => 43,
                'name' => 'PERSIAPAN',
                'status' => 'open',
                'completeness' => null,
            ],
            [
                'volume_id' => 43,
                'name' => 'PELAKSANAAN',
                'status' => 'open',
                'completeness' => null,
            ],
            [
                'volume_id' => 43,
                'name' => 'PENINJAUAN',
                'status' => 'open',
                'completeness' => null,
            ],
            // 9.1 task 18-47
            ['volume_id' => 59,'name' => 'POKOK-POKOK PERJANJIAN','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'Serbaaneka informasi','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'Lampiran A: KETENTUAN – KETENTUAN UMUM','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'Lampiran A: KETENTUAN – KETENTUAN KHUSUS','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN B - URAIAN DAN LINGKUP PEKERJAAN','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN B.1 - DAFTAR DAN SPESIFIKASI TEKNIS BARANG DAN JASA','status' => 'closed','completeness' => 80.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN B.2 - SYARAT KONTRAKTOR PEKERJAAN DAN TENAGA KERJA','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN B.3 - SYARAT DAN KETENTUAN KHUSUS','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN 2 - KRITERIA EVALUASI TEKNIS','status' => 'open','completeness' => 80.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN B.4 - PERSYARATAN JAMINAN KEAMANAN INFORMASI DALAM
            PENYEDIAAN BARANG/JASA OLEH KONTRAKTOR KEPADA PERUSAHAAN','status' => 'closed','completeness' => 50.00,],
            ['volume_id' => 59,'name' => 'Lampiran B.5 - RoTE','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN C - KOMPENSASI DAN PEMBAYARAN
            (Rincian Harga Kontrak & Ketentuan)','status' => 'open','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN C1 Rincian Harga Kontrak dan Ketentuan','status' => 'open','completeness' => 100.00,],
            ['volume_id' => 59,'name' => '7. ctem_lampiran c2 - Harga Kontrak Dan Ketentuan Pembayaran','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'EXHIBIT C.3 - TINGKAT KOMPONEN DALAM NEGERI','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN D - JADWAL PELAKSANAAN PEKERJAAN','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN E - MANAJEMEN KINERJA KONTRAKTOR/Asuransi','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN E.1 - EVALUASI KINERJA PENYEDIA JASA - SPR (SERVICE PERFORMANCE REVIEW)','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN F - INSURANCE REQUIREMENT','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN G - FORMULIR-FORMULIR STANDAR','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'LAMPIRAN H - KETENTUAN KEBIJAKAN KESEHATAN, XKESELAMATAN
            KERJA DAN LINDUNGAN LINGKUNGAN (K3LL)','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'EXHIBIT E,F,G, - INSURANCE REQUIREMENT','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'Presentasi','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'BoQ','status' => 'closed','completeness' => 100.00,],
            ['volume_id' => 59,'name' => 'Dokumen Kajian','status' => 'open','completeness' => 35.00,],
            ['volume_id' => 59,'name' => 'HPS/OE Development','status' => 'open','completeness' => 70.00,],
            ['volume_id' => 59,'name' => 'Demo Principal','status' => 'open','completeness' => 72.00,],
            ['volume_id' => 59,'name' => 'Local Partner Contact','status' => 'open','completeness' => 60.00,],
            ['volume_id' => 59,'name' => 'Principal Docs','status' => 'open','completeness' => 52.00,],
            ['volume_id' => 59,'name' => 'Lampiran B.6','status' => 'open','completeness' => 30.00,],
        ];
        foreach ($tasks as $task) {
            Task::create($task);
        };
    }
}
