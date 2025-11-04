<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $workers =[
        //     // 1
        //     [
        //         'name' => 'Oki Jamhur',
        //         'email' => 'oki123@gmail.com',
        //         'password' => bcrypt('okij123!'),
        //         // 'role' => 'Project Manager',
        //         'desc' => 'Project Manager dengan pengalaman 10+ tahun',
        //     ],
        //     // 2
        //     [
        //         'name' => 'Restia Moegiono',
        //         'email' => 'restia123@gmail.com',
        //         'password' => bcrypt('rest123!'),
        //         // 'role' => 'Senior Consultant',
        //         'desc' => 'Senior Consultant dengan pengalaman 8+ tahun',
        //     ],
        //     // 3
        //     [
        //         'name' => 'Yudistira Dwi Wardhana',
        //         'email' => 'yudistira123@gmail.com',
        //         'password' => bcrypt('yudi123!'),
        //         // 'role' => ['Associate Consultant', 'Senior Consultant'],
        //         'desc' => 'Consultant dengan pengalaman 5+ tahun',
        //     ],
        //     // 4
        //     [
        //         'name' => 'Annisa Yuniar',
        //         'email' => 'annisay123@gmail.com',
        //         'password' => bcrypt('anny123!'),
        //         // 'role' => 'Junior Consultant',
        //         'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
        //     ],
        //     // 5
        //     [
        //         'name' => 'Vanika I',
        //         'email' => 'vanika123@gmail.com',
        //         'password' => bcrypt('vani123!'),
        //          // 'role' => 'Technical Writer',
        //         'desc' => 'Technical Writer dengan background teknis',
        //     ],
        //     // 6
        //     [
        //         'name' => 'Wahyu Winarno',
        //         'email' => 'wahyu123@gmail.com',
        //         'password' => bcrypt('wahy123!'),
        //         // 'role' => 'Senior Consultant',
        //         'desc' => 'Senior Consultant dengan pengalaman 10+ tahun',
        //     ],
        //     // 7
        //     [
        //         'name' => 'Nus Primata Nugraheni',
        //         'email' => 'nusprimata123@gmail.com',
        //         'password' => bcrypt('nusp123!'),
        //         // 'role' => 'Senior Consultant',
        //         'desc' => 'Senior Consultant dengan pengalaman 12+ tahun',
        //     ],
        //     // 8
        //     [
        //         'name' => 'Eko Yon Handri',
        //         'email' => 'ekoyon123@gmail.com',
        //         'password' => bcrypt('ekoy123!'),
        //         // 'role' => 'Senior Consultant',
        //         'desc' => 'Senior Consultant dengan pengalaman 15+ tahun',
        //     ],
        //     // 9
        //     [
        //         'name' => 'Indra',
        //         'email' => 'indra123@gmail.com',
        //         'password' => bcrypt('indr123!'),
        //         // 'role' => 'Associate Consultant',
        //         'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
        //     ],
        //     // 10
        //     [
        //         'name' => 'Bayu Samudra',
        //         'email' => 'bayu123@gmail.com',
        //         'password' => bcrypt('bayu123!'),
        //         // 'role' => 'Junior Consultant',
        //         'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
        //     ],
        //     // 11
        //     [
        //         'name' => 'Galuh Dhipa',
        //         'email' => 'galuhd123@gmail.com',
        //         'password' => bcrypt('galu123!'),
        //         // 'role' => 'Junior Consultant',
        //         'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
        //     ],
        //     // 12
        //     [
        //         'name' => 'Decky',
        //         'email' => 'decky123@gmail.com',
        //         'password' => bcrypt('deck123!'),
        //         // 'role' => 'Technical Writer',
        //         'desc' => 'Technical Writer dengan background teknis',
        //     ],
        //     // 13
        //     [
        //         'name' => 'Issa',
        //         'email' => 'issa123@gmail.com',
        //         'password' => bcrypt('issa123!'),
        //         // 'role' => 'Associate Consultant',
        //         'desc' => 'Associate Consultant dengan pengalaman 5+ tahun',
        //     ],
        //     // 14
        //     [
        //         'name' => 'Ariya',
        //         'email' => 'ariya123@gmail.com',
        //         'password' => bcrypt('ariya123!'),
        //         // 'role' => 'Junior Consultant',
        //         'desc' => 'Junior Consultant dengan pengalaman 2+ tahun',
        //     ],
        // ];

        $workers = [
            // 1. Project Manager
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@company.com',
                'password' => bcrypt('budi123!'),
                'desc' => 'Project Manager (PM) dengan pengalaman 10+ tahun, bersertifikasi PMP, ahli dalam manajemen risiko dan anggaran.'
            ],

            // 2. Senior Consultant
            [
                'name' => 'Dewi Purnama',
                'email' => 'dewi.purnama@company.com',
                'password' => bcrypt('dewi123!'),
                'desc' => 'Senior Consultant yang fokus pada transformasi digital dan optimasi proses bisnis. Ahli di bidang riset dan analisis.'
            ],

            // 3. Associate Consultant
            [
                'name' => 'Fajar Nugraha',
                'email' => 'fajar.nugraha@company.com',
                'password' => bcrypt('fajar123!'),
                'desc' => 'Associate Consultant yang memiliki keahlian dalam perancangan solusi teknis dan dokumentasi kebutuhan fungsional.'
            ],

            // 4. Junior Consultant
            [
                'name' => 'Sinta Amelia',
                'email' => 'sinta.amelia@company.com',
                'password' => bcrypt('sinta123!'),
                'desc' => 'Junior Consultant yang mendukung tim dalam pengumpulan data, administrasi proyek, dan penyusunan laporan mingguan.'
            ],

            // 5. Technical Writer
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky.pratama@company.com',
                'password' => bcrypt('rizky123!'),
                'desc' => 'Technical Writer yang bertanggung jawab atas seluruh dokumentasi teknis, manual pengguna, dan basis pengetahuan.'
            ]
        ];

        foreach ($workers as $worker) {
            // $role = $worker['role'];
            // unset($worker['role']);
            $worker = User::create($worker);
            // $worker->assignRole(['karyawan',$role]);
            $worker->assignRole('karyawan');
        };

        // $admin= User::create([
        //     'name' => 'Aiman',
        //     'email' => 'aiman123@gmail.com',
        //     'password' => bcrypt('aima123!'),
        //     'desc' => 'Administrasi',
        // ]);

        $admin= User::create([
            'name' => 'administrator',
            'email' => 'administrator@gmail.com',
            'password' => bcrypt('admi123!'),
            'desc' => 'Administrasi',
        ]);
        $admin->assignRole('admin');
    }
}
