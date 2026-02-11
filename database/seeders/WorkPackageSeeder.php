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
                'category_id' => 1,
                'workPack_number' => '1.1',
                'name' => 'Merger & Acquisition (M&A) - Information Security Due Dilligence',
                'volumeQTY' => 2,
                'duration' => 46,
                'actualScope' => '',
                'deliverable' => 'Laporan assessment pre-M&A, yang memuat aspek assessment mengenai
                                    1. Culture, yang meliputi aspek:
                                    ▪ Program Security Awareness dan pelaksanaannya
                                    ▪ Staffing untuk IT Security
                                    ▪ Budget IT Security Budget
                                    ▪ Komitmen dukungan eksekutif
                                    2. Technical Self-Awareness yang meliputi aspek:
                                    ▪ Mekanisme Inventory Control (Hardware/Software)
                                    ▪ Pemetaan data
                                    ▪ Diagram dan peta jaringan
                                    ▪ Dokumentasi aset IT
                                    ▪ Ketersediaan log/ keberadaan SIEM
                                    3. Incident Response readiness yang mencakup:
                                    ▪ Incident Response Plans
                                    ▪ Incident Response Table-tops/ Practice
                                    ▪ Ransomware Preparedness
                                    ▪ Incident Response Staffing and/or IR Retainer
                                    ▪ Cyber Insurance
                                    4. Technical Security yang mencakup:
                                    ▪ Firewalls, IDS/IPS
                                    ▪ Kebijakan enkripsi
                                    ▪ Patching and Vulnerability Management
                                    ▪ Kebijakan akses admin lokal
                                    5. Disaster Recovery readiness yang mencakup:
                                    ▪ Enkripsi backup
                                    ▪ Backup Process and Testing
                                    ▪ DR Site, Plan, Testing
                                    6. SDLC/ Product Security, yang mencakup
                                    ▪ Kebijakan mengenai Secure SDLC
                                    ▪ Software Security Testing
                                    ▪ Software Acquisition and Vendor Management Process
                                    7. Dokumen rekomendasi yang memuat analisis hasil assessment (proses
                                    assessment dan hasilnya), serta rekomendasi remediasi terhadap hasil
                                    assessment',
            ],
            [
                'category_id' => 1,
                'workPack_number' => '1.2',
                'name' => 'Merger & Acquisition (M&A) - In-Depth/ Combination Assessment',
                'volumeQTY' => 2,
                'duration' => 46,
                'actualScope' => '',
                'deliverable' => '1. Laporan assessment kombinasi yang meliputi pelaporan dari kegiatan:
                                    a. Validated vulnerability assessment
                                    b. Social engineering
                                    c. Penetration testing
                                    d. In-depth compromise assessment

                                    2. Dokumen rekomendasi yang memuat analisis hasil assessment (proses
                                    assessment dan hasilnya), serta rekomendasi remediasi terhadap hasil
                                    assessment',
            ],
            [
                'category_id' => 2,
                'workPack_number' => '2.1',
                'name' => 'Control/Framework Assessment',
                'volumeQTY' => 2,
                'duration' => 31,
                'actualScope' => '',
                'deliverable' => 'Laporan assessment, yang memuat:
                                    1. Laporan studi regulasi.
                                    2. Proses dan analisis kontrol regulasi dan penentuan control yang akan
                                    diterapkan
                                    3. Hasil assessment current condition terkait control yang ditetapkan',
            ],
            [
                'category_id' => 2,
                'workPack_number' => '2.2',
                'name' => 'Change Management Plan',
                'volumeQTY' => 2,
                'duration' => 80,
                'actualScope' => '',
                'deliverable' => 'Laporan change management plan, yang memuat:
                                    1. Hasil analisis gap
                                    2. Desain penyesuaian proses beserta STK yang menjadi acuan proses
                                    terkait
                                    3. Desain pemenuhan kebutuhan organisasi SDM yang sesuai
                                    4. Desain pemenuhan kebutuhan teknologi apabila diperlukan
                                    5. Pentahapan untuk pelaksanaan setiap desain pada poin a-c
                                    6. Hasil desain proses dan penyesuaian (penambahan, pengurangan, revisi)
                                    STK terkait
                                    7. Dokumentasi Pelatihan SDM untuk keahlian terkait
                                    8. Dokumentasi Pendampingan dan pengawasan implementasi teknologi
                                    9. Dokumentasi workshop, termasuk di dalamnya materi workshop dan daftar
                                    hadir untuk:
                                    a. Workshop draft compliance design
                                    b. Workshop finalisasi compliance design',
            ],
            [
                'category_id' => 2,
                'workPack_number' => '2.3',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 2,
                'duration' => 50,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan rencana, serta keterangan penyesuaian apabila
                                    terdapat perbedaan terhadap rencana',
            ],
            [
                'category_id' => 2,
                'workPack_number' => '2.4',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 2,
                'duration' => 14,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi rencana, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya',
            ],
            [
                'category_id' => 2,
                'workPack_number' => '2.5',
                'name' => 'Revisit',
                'volumeQTY' => 2,
                'duration' => 26,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, yang memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian beserta dokumen teknis hasil penyesuaian
                                    sebagai lampiran',
            ],
            [
                'category_id' => 3,
                'workPack_number' => '3.1',
                'name' => 'Human Security Risk Awareness Program Planning',
                'volumeQTY' => 1,
                'duration' => 22,
                'actualScope' => '"Human firewall design program (awareness) - IS competency matrix"',
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
            ],
            [
                'category_id' => 3,
                'workPack_number' => '3.2',
                'name' => 'Human Security Capabilities Development Program Planning',
                'volumeQTY' => 1,
                'duration' => 33,
                'actualScope' => '"Human firewall implementation program (pelatihan/certification) - IS competency matrix"',
                'deliverable' => 'Laporan perencanaan pengembangan SDM keamanan informasi, yang
                                    memuat:
                                    1. Resume studi framework
                                    2. Proses dan hasil analisis kebutuhan pengembangan SDM
                                    3. Desain pengembangan SDM, yang mencakup kebutuhan jumlah untuk
                                    setiap kelompok keahlian dan perencanaan program pendidikan/ pelatihan
                                    yang diperlukan
                                    4. Analisis prioritas dan penyusunan tahapan pengembangan SDM
                                    keamanan informasi
                                    5. Dokumentasi workshop pengembangan SDM keamanan informasi (apabila
                                    dilaksanakan), termasuk di dalamnya materi workshop dan daftar hadir',
            ],
            [
                'category_id' => 3,
                'workPack_number' => '3.3',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 1,
                'duration' => 44,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan reancana serta keterangan penyesuaian apabila
                                    terdapat perbedaan terhadap rencana',
            ],
            [
                'category_id' => 3,
                'workPack_number' => '3.4',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 1,
                'duration' => 11,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi rencana, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya',
            ],
            [
                'category_id' => 3,
                'workPack_number' => '3.5',
                'name' => 'Revisit',
                'volumeQTY' => 2,
                'duration' => 22,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, yang memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian desain beserta dokumen teknis hasil
                                    penyesuaian sebagai lampiran',
            ],
            [
                'category_id' => 4,
                'workPack_number' => '4.1',
                'name' => 'Risk identification, analysis, treatment, socialization',
                'volumeQTY' => 1,
                'duration' => 86,
                'actualScope' => '',
                'deliverable' => 'Laporan risk identification, assessment/analysis, treatment/mitigation,
                                    sosialisasi, yang memuat:
                                    1. Hasil Identifikasi risiko, meliputi:
                                    a. Identifikasi aset
                                    b. Identifikasi kerentanan
                                    c. Identifikasi ancaman
                                    d. Identifikasi control
                                    2. Hasil assessment/ penilaian risiko
                                    3. Hasil perencanaan treatment risiko, yaitu penentuan kontrol yang dapat
                                    mengatasi risiko, mencakup
                                    a. Remediasi, yaitu penentuan kontrol yang dapat mengatasi risiko
                                    b. Mitigasi, yaitu pengendalian terhadap nilai risiko atau dampak risiko
                                    c. Transfer, yaitu pengalihan risiko kepada pihak lain
                                    d. Acceptance/ penerimaan, yaitu menerima risiko karena nilai risiko yang
                                    rendah
                                    e. Avoidance/ penghindaran, yaitu menghilangkan kemungkinan risiko
                                    dengan melakukan suatu tindakan tertentu
                                    4. Dokumentasi sosialisasi manajemen risiko
                                    5. Dokumentasi workshop, termasuk di dalamnya materi workshop dan daftar
                                    hadir, yang mencakup:
                                    a. Workshop hasil assessment/ penilaian risiko
                                    b. Workshop hasil penyusunan treatment risiko',
            ],
            [
                'category_id' => 4,
                'workPack_number' => '4.2',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 3,
                'duration' => 40,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan desain manajemen risiko, serta keterangan
                                    penyesuaian apabila terdapat perbedaan terhadap rencana
                                    3. Kesesuaian hasil implementasi terhadap mitigasi dampak yang diharapkan',
            ],
            [
                'category_id' => 4,
                'workPack_number' => '4.3',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 3,
                'duration' => 14,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi rencana, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya',
            ],
            [
                'category_id' => 4,
                'workPack_number' => '4.4',
                'name' => 'Revisit',
                'volumeQTY' => 3,
                'duration' => 26,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, yang memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian beserta dokumen teknis hasil penyesuaian
                                    sebagai lampiran',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.1',
                'name' => 'Enterprise Security Posture Assessment ',
                'volumeQTY' => 1,
                'duration' => 62,
                'actualScope' => 'ESA',
                'deliverable' => '6.5.1.Laporan hasil assessment security posture PERUSAHAAN, yang memuat:
                                    1. Gambaran umum current practices information/ cyber security di
                                    PERUSAHAAN
                                    2. Existing process – people – technology untuk information/ cyber security
                                    3. Hasil analisa informasi yang diperoleh dari hasil assessmen untuk
                                    memperoleh kesimpulan mengenai existing security posture
                                    PERUSAHAAN
                                    4. Hasil identifikasi kebutuhan awal pengembangan arsitektur keamanan
                                    informasi PERUSAHAAN
                                    5. Dokumentasi workshop (apabila dilaksanakan), termasuk di dalamnya
                                    materi workshop dan daftar hadir',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.2',
                'name' => 'Penyusunan Enterprise Security Architecture',
                'volumeQTY' => 1,
                'duration' => 102,
                'actualScope' => '',
                'deliverable' => 'Laporan hasil penyusunan Enterprise Security Architecture, yang memuat:
                                    1. Resume studi framework
                                    2. Hasil analisis kebutuhan dan analisis referensi framework
                                    3. Tujuan dan strategi information/ cyber security PERUSAHAAN
                                    4. Kebutuhan proses dan bagaimana penyelenggaraannya dalam pencapaian
                                    tujuan
                                    5. Kebutuhan organisasi dan SDM
                                    6. Kebutuhan teknologi yang digambarkan dalam arsitektur teknologi untuk
                                    information/ cyber security PERUSAHAAN
                                    7. Struktur tata kelola yang diperlukan serta strategi manajemen perubahan
                                    8. Dokumentasi workshop (apabila dilaksanakan), termasuk di dalamnya materi
                                    workshop dan daftar hadir',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.3',
                'name' => 'Penyusunan Roadmap & Implementation Plan',
                'volumeQTY' => 1,
                'duration' => 48,
                'actualScope' => '',
                'deliverable' => 'Laporan Roadmap & Desain Implementasi, yang memuat:
                                    1. Hasil analisis gap kondisi arsitektur ideal terhadap existing security posture
                                    2. Hasil identifikasi program/ inisiatif information/ cyber security baik strategis,
                                    taktikal, operasional untuk mencapai arsitektur ideal
                                    3. Pioritas program/ inisiatif dan pemetaan roadmap
                                    4. Strategi implementasi program/ inisiatif
                                    5. Dokumentasi workshop (apabila dilaksanakan), termasuk di dalamnya materi
                                    workshop dan daftar hadir',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.4',
                'name' => 'Penyusunan governance framework enterprise security architecture, roadmap, implementation plan/strategy (people - process - technology)',
                'volumeQTY' => 1,
                'duration' => 72,
                'actualScope' => '',
                'deliverable' => 'Laporan kerangka tata kelola penerapan enterprise security architecture,
                                    roadmap, dan strategi implementasi
                                    1. Organisasi penanggung jawab pelaksana
                                    2. Daftar kebutuhan STK sebagai acuan pelaksanaan
                                    3. Dokumentasi workshop (apabila dilaksanakan), termasuk di dalamnya materi
                                    workshop dan daftar hadir',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.5',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 2,
                'duration' => 38,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan arsitektur, roadmap, dan kerangka tata kelola, serta
                                    keterangan penyesuaian apabila terdapat perbedaan terhadap rencana',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.6',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 2,
                'duration' => 14,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi rencana, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya',
            ],
            [
                'category_id' => 5,
                'workPack_number' => '5.7',
                'name' => 'Revisit',
                'volumeQTY' => 2,
                'duration' => 26,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, yang memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian beserta dokumen teknis hasil penyesuaian
                                    sebagai lampiran',
            ],
            [
                'category_id' => 6,
                'workPack_number' => '6.1',
                'name' => 'Initial Advisory & Consultancy - Information Security Management System (ISMS)',
                'volumeQTY' => 1,
                'duration' => 180,
                'actualScope' => '',
                'deliverable' => '1. Laporan Perencanaan & Persiapan Pre-Audit
                                    a. Laporan studi standar/ best practice yang menjadi acuan.
                                    b. Laporan Assessment yang mencakup:
                                    • Hasil analisis dan pendefinisian lingkup yang akan diterapkan serta
                                    kebutuhan untuk pemenuhannya
                                    • Framework dan assessment current condition terkait lingkup yang
                                    ditetapkan
                                    • Analisis gap
                                    2. Laporan perencanaan manajemen perubahan, yang mencakup:
                                    a. Hasil analisis gap
                                    b. Desain penyesuaian proses
                                    c. Desain pemenuhan kebutuhan organisasi SDM yang sesuai
                                    d. Desain pemenuhan kebutuhan teknologi apabila diperlukan
                                    e. Desain implementasi
                                    f. Tahapan pelaksanaan rencana
                                    3. Laporan penerapan desain manajemen perubahan, yang memuat:
                                    a. Hasil desain proses
                                    b. Laporan pelatihan SDM untuk keahlian terkait
                                    c. Laporan pelaksanaan pendampingan dan pengawasan implementasi
                                    teknologi
                                    d. Laporan pendampingan implementasi (untuk pelaksanaan proses,
                                    penggunaan teknologi)
                                    4. Dokumentasi workshop compliance design (apabila dilaksanakan), termasuk
                                    di dalamnya materi workshop dan daftar hadir
                                    5. Laporan Pendampingan Audit (Internal/ External), yang mendokumentasikan
                                    proses:
                                    a. Pendampingan penyusunan audit plan
                                    b. Pendampingan audit dokumen
                                    c. Pendampingan audit implementasi
                                    d. Pendampingan management review
                                    e. Pendampingan pelaksanaan corrective action',
            ],
            [
                'category_id' => 6,
                'workPack_number' => '6.2',
                'name' => 'Revisit Advisory & Consultancy - Information Security Management System (ISMS)',
                'volumeQTY' => 2,
                'duration' => 100,
                'actualScope' => 'Project ISO 27001 : 2022',
                'deliverable' => '1. Hasil Analisis dan pendefinisian lingkup 
                                    2. Desain penyesuaian proses 
                                    3. Hasil desain proses 
                                    4. Laporan pendampingan Audit ',
            ],
            [
                'category_id' => 7,
                'workPack_number' => '7.1',
                'name' => 'Initial Advisory & Consultancy - Information Security Compliance Assessment',
                'volumeQTY' => 3,
                'duration' => 180,
                'actualScope' => '',
                'deliverable' => 'Laporan Initial Advisory & Consultancy - Information Security
                                    Compliance, yang mencakup:
                                    1. Laporan Perencanaan & Persiapan Pre-Assessment
                                    a. Laporan studi standar/ hukum/ best practice/ regulasi external/ regulasi
                                    internal yang menjadi acuan.
                                    b. Laporan Assessment yang mencakup:
                                    • Hasil analisis dan pendefinisian lingkup yang akan diterapkan serta
                                    kebutuhan untuk pemenuhannya
                                    • Framework dan assessment current condition terkait lingkup yang
                                    ditetapkan
                                    • Analisis gap
                                    2. Laporan perencanaan manajemen perubahan, yang mencakup:
                                    a. Hasil analisis gap
                                    b. Desain penyesuaian proses
                                    c. Desain pemenuhan kebutuhan organisasi SDM yang sesuai
                                    d. Desain pemenuhan kebutuhan teknologi apabila diperlukan
                                    e. Desain implementasi
                                    f. Tahapan pelaksanaan rencana
                                    3. Laporan penerapan desain manajemen perubahan, yang memuat:
                                    a. Hasil desain proses
                                    b. Laporan pelatihan SDM untuk keahlian terkait
                                    c. Laporan pelaksanaan pendampingan dan pengawasan implementasi
                                    teknologi
                                    d. Laporan pendampingan implementasi (untuk pelaksanaan proses,
                                    penggunaan teknologi)
                                    4. Dokumentasi workshop compliance design (apabila dilaksanakan),
                                    termasuk di dalamnya materi workshop dan daftar hadir
                                    5. Laporan Pendampingan Assessment (Internal/ External), yang
                                    mendokumentasikan proses:
                                    a. Pendampingan penyusunan audit plan
                                    b. Pendampingan assessment dokumen
                                    c. Pendampingan assessment implementasi
                                    d. Pendampingan management review
                                    e. Pendampingan pelaksanaan corrective action',
            ],
            [
                'category_id' => 7,
                'workPack_number' => '7.2',
                'name' => 'Revisit Advisory & Consultancy - Information Security Compliance Assessment',
                'volumeQTY' => 5,
                'duration' => 100,
                'actualScope' => '',
                'deliverable' => '1. Hasil analisis dan pendefinisian lingkup yang akan diterapkan serta
                                    kebutuhan untuk pemenuhannya
                                    2. Desain penyesuaian proses
                                    3. Hasil desain proses
                                    4. Laporan Pendampingan Assessment (Internal/ External), yang
                                    mendokumentasikan proses:
                                    a. Pendampingan penyusunan assessment plan
                                    b. Pendampingan assessment dokumen
                                    c. Pendampingan assessment implementasi
                                    d. Pendampingan management review
                                    e. Pendampingan pelaksanaan corrective action',
            ],
            [
                'category_id' => 8,
                'workPack_number' => '8.1',
                'name' => 'Privacy/ PII Processing Compliance Assessment',
                'volumeQTY' => 1,
                'duration' => 70,
                'actualScope' => '"Initial Stage :  
                                            -Kick-off Meeting 
                                            Pembahasan penyesuaian lingkup sesuai Peran IT 

                                            Assesment Stage : 
                                            Pengisian assesment form Kementrian BUMN 
                                            Pengisian assesment form Pertamina Persero 
                                            Kajian kebijakan sosialisasi ROPA 
                                            Pendampingan penyusunan ROPA upon request 
                                            Kajian Tools pendukung PDP 
                                            Inisiasi RKST pengadaan Tools PDP",',
                'deliverable' => '1. Framework untuk asesmen perlindungan data pribadi 
                                    2. Struktur dan kompetensi tim pelaksana PDP 
                                    3. Awarness Privacy/PII/PDP di lingkungan Perusahaan 
                                    4. Tahapan dan strategi implementasi 
                                    5. Daftar STK ',
            ],
            [
                'category_id' => 8,
                'workPack_number' => '8.2',
                'name' => 'Privacy/ PII Protection Implementation Plan',
                'volumeQTY' => 1,
                'duration' => 108,
                'actualScope' => '',
                'deliverable' => 'Laporan desain implementasi perlindungan data pribadi (PDP), yang
                                    memuat:
                                    1. Framework untuk asesmen perlindungan data pribadi
                                    2. Struktur dan Kompetensi tim pelaksana PDP di PERUSAHAAN
                                    3. Awareness Privacy / PII / PDP di lingkungan Perusahaan
                                    4. Tahapan dan strategi implementasi
                                    5. Daftar STK yang relevan terkait PDP
                                    6. Dokumentasi workshop (apabila dilaksanakan), termasuk di dalamnya
                                    materi workshop dan daftar hadir',
            ],
            [
                'category_id' => 8,
                'workPack_number' => '8.3',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 1,
                'duration' => 34,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan desain serta keterangan penyesuaian apabila
                                    terdapat perbedaan terhadap rencana',
            ],
            [
                'category_id' => 8,
                'workPack_number' => '8.4',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 1,
                'duration' => 14,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi rencana, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya.',
            ],
            [
                'category_id' => 8,
                'workPack_number' => '8.5',
                'name' => 'Revisit',
                'volumeQTY' => 3,
                'duration' => 26,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian desain beserta dokumen teknis hasil
                                    penyesuaian sebagai lampiran',
            ],
            [
                'category_id' => 9,
                'workPack_number' => '9.1',
                'name' => 'Control/Framework Assessment & Design',
                'volumeQTY' => 4,
                'duration' => 166,
                'actualScope' => '',
                'deliverable' => 'Laporan Assessment & Engineering Design, yang mencakup:
                                    1. Hasil assessment kondisi existing terkait penerapan sistem, dengan
                                    menggunakan framework yang sesuai
                                    2. Hasil analisis kebutuhan sistem
                                    3. Desain ideal model penerapan sistem (process, people, technology
                                    architecture & specification)
                                    4. Gap analysis
                                    5. Penyusunan strategi pentahapan implementasi (roadmap implementasi)
                                    6. Dokumentasi workshop, termasuk di dalamnya materi workshop dan daftar
                                    hadir untuk:
                                    a. Workshop pembahasan draft hasil perancangan sistem
                                    b. Workshop finalisasi perancangan sistem',
            ],
            [
                'category_id' => 9,
                'workPack_number' => '9.2',
                'name' => 'Implementation Assistance, Mentoring, & Monitoring',
                'volumeQTY' => 3,
                'duration' => 40,
                'actualScope' => '',
                'deliverable' => 'Laporan Implementation Assistance, Mentoring, & Monitoring, yang
                                    memuat:
                                    1. Rincian kegiatan implementasi
                                    2. Kesesuaian dengan desain serta keterangan penyesuaian apabila
                                    terdapat perbedaan terhadap desain',
            ],
            [
                'category_id' => 9,
                'workPack_number' => '9.3',
                'name' => 'Post Implementation Review',
                'volumeQTY' => 3,
                'duration' => 14,
                'actualScope' => '',
                'deliverable' => 'Laporan Post Implementation Review, yang memuat:
                                    1. Identifikasi dampak yang diharapkan diperbandingkan terhadap dampak
                                    yang diperoleh
                                    2. Analisis dampak terhadap proses implementasi
                                    3. Analisis implementasi terhadap desain yang disusun
                                    4. Evaluasi desain, proses implementasi, dan dampak, serta penyusunan
                                    rekomendasi penyesuaian untuk periode berikutnya',
            ],
            [
                'category_id' => 9,
                'workPack_number' => '9.4',
                'name' => 'Revisit',
                'volumeQTY' => 3,
                'duration' => 26,
                'actualScope' => '',
                'deliverable' => 'Laporan Revisit, yang memuat:
                                    1. Poin penyesuaian
                                    2. Resume hasil penyesuaian desain beserta dokumen teknis hasil
                                    penyesuaian sebagai lampiran',
            ],
            [
                'category_id' => 10,
                'workPack_number' => '10.1',
                'name' => 'Initial Design - Information Security Policy, Procedures, Guideline',
                'volumeQTY' => 36,
                'duration' => 16,
                'actualScope' => '',
                'deliverable' => 'Initial Design - Information Security Policy, Procedures, Guideline
                                    Dokumen sistem tata kerja (STK) baru, baik kebijakan (pedoman), prosedur
                                    (Tata Kerja Organisasi/ Tata Kerja Individu), dan guideline baru sesuai
                                    kebutuhan PERUSAHAAN.',
            ],
            [
                'category_id' => 10,
                'workPack_number' => '10.2',
                'name' => 'Revisit - Information Security Policy, Procedures, Guideline',
                'volumeQTY' => 18,
                'duration' => 12,
                'actualScope' => '',
                'deliverable' => 'Revisit - Information Security Policy, Procedures, Guideline
                                    Pembaruan dari dokumen sistem tata kerja (STK), baik kebijakan (pedoman),
                                    prosedur (Tata Kerja Organisasi/ Tata Kerja Individu), dan guideline sesuai
                                    kebutuhan PERUSAHAAN.',
            ],
            [
                'category_id' => 11,
                'workPack_number' => '11.1',
                'name' => 'Information Security Assistance, Support, & Monitoring Services',
                'volumeQTY' => 1,
                'duration' => 0,
                'actualScope' => 'Onsite consultant',
                'deliverable' => 'Laporan Pelaksanaan Information Security Assistance, Support, &
                                    Monitoring Services, yang memuat:
                                    1. Activity Log / Activirty Record
                                    2. Resume pelaksanaan kegiatan',
            ],
            [
                'category_id' => 11,
                'workPack_number' => '11.2',
                'name' => 'Human Security Risk Awareness Services',
                'volumeQTY' => 12,
                'duration' => 0,
                'actualScope' => '"Executive Leaders Forum on Cybersecurity 1.0:
Empowering Oil and Gas Leaders with Critical Insight into Cybersecurity and Data Privacy Fundamentals"',
                'deliverable' => 'Laporan Pelaksanaan Program Human Risk Security Awareness
                                    Services, per kegiatan yang memuat:
                                    1. Materi
                                    2. Resume pelaksanaan kegiatan
                                    3. Saran perbaikan.
                                    4. Daftar Hadir (apabila relevan)
                                    5. Notulen Rapat (apabila relevan)
                                    6. Sertifikat (apabila relevan)',
            ],
            [
                'category_id' => 11,
                'workPack_number' => '11.3',
                'name' => 'Human Security Risk Capabilities Development Services',
                'volumeQTY' => 40,
                'duration' => 0,
                'actualScope' => '"Focus Group Discussion (FGD) 
Upskilling & Sertifikasi Certified in Risk & Information System Control (CRISC)"',
                'deliverable' => 'Laporan Pelaksanaan Program Human Risk Security Capabilities
                                    Development Services, per kegiatan yang memuat:
                                    1. Materi
                                    2. Resume pelaksanaan kegiatan
                                    3. Saran perbaikan.
                                    4. Daftar Hadir (apabila relevan)
                                    5. Notulen Rapat (apabila relevan)',
            ],
            [
                'category_id' => 11,
                'workPack_number' => '11.4',
                'name' => 'General Information Security Services',
                'volumeQTY' => 30,
                'duration' => 0,
                'actualScope' => '',
                'deliverable' => 'Laporan Pelaksanaan Program Information Security Services, per
                                    kegiatan yang memuat:
                                    1. Materi
                                    2. Resume pelaksanaan kegiatan
                                    3. Saran perbaikan.
                                    4. Daftar Hadir (apabila relevan)
                                    5. Notulen Rapat (apabila relevan)
                                    6. Sertifikat (apabila relevan)',
            ],
        ];
        foreach ($workpackages as $workpackage) {
            WorkPackage::create($workpackage);
        };
    }
}
