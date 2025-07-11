<?php

namespace Database\Seeders;

use App\Models\WorkPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workpackages = [
            [
                'wp_number' => '3.1',
                'name' => 'Human Security Risk Awareness Program Planning',
                'volume_qty' => 1,
                'duration' => 22,
                'actual_scope_contract' => '"Human firewall design program (awareness) - IS competency matrix"',
                'deliverable' => 'Laporan perencanaan pengembangan awareness keamanan informasi,
                                    yang memuat:
                                    1. Metode pembangunan awareness
                                    2. Materi sosialisasi security awareness
                                    3. Materi pengujian berkala untuk topik security awareness
                                    4. Materi pelatihan dasar cyber hygiene, serta penggunaan tools pendukung
                                    cyber hygiene yang dimiliki PERUSAHAAN
                                    5. Dokumentasi workshop pengembangan awareness keamanan informasi
                                    (apabila dilaksanakan), termasuk di dalamnya materi workshop dan daftar
                                    hadir',
                'completeness' => 100.00,
            ],
            [
                'wp_number' => '6.2',
                'name' => 'Revisit Advisory & Consultancy - Information Security Management System (ISMS)',
                'volume_qty' => 2,
                'duration' => 100,
                'actual_scope_contract' => 'Project ISO 27001 : 2022',
                'deliverable' => '1. Hasil Analisis dan pendefinisian lingkup 
                                    2. Desain penyesuaian proses 
                                    3. Hasil desain proses 
                                    4. Laporan pendampingan Audit ',
                'completeness' => 23.44,
            ],
        ];

        foreach ($workpackages as $workpackage) {
            WorkPackage::create($workpackage);
        };
    }
}
