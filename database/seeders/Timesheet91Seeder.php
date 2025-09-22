<?php

namespace Database\Seeders;

use App\Models\Timesheet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Timesheet91Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timesheets = [
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-03-4',
                'activity' => 'Membuat komparasi ASM/CTI/VM/CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-4',
                'activity' => 'Mempelajari Konsep CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-4',
                'activity' => 'Research Cyber Offensive Security Automation',
                'duration' => 1
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-03-6',
                'activity' => 'Merancang konsep dasar CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-03-10',
                'activity' => 'Diskus CTEM dan Setup Cyber Offensive Security untuk PHE',
                'duration' => 1
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-10',
                'activity' => 'Diskus CTEM dan Setup Cyber Offensive Security untuk PHE',
                'duration' => 1
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-10',
                'activity' => 'Diskus CTEM dan Setup Cyber Offensive Security untuk PHE',
                'duration' => 1
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-12',
                'activity' => 'Drafting Awal B dan B1',
                'duration' => 1
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-12',
                'activity' => 'Drafting Awal B dan B1',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-03-12',
                'activity' => 'Drafting Awal B dan B1',
                'duration' => 1
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-13',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-13',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-03-13',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-14',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-14',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-03-14',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-18',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-18',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-03-18',
                'activity' => 'Drafting B dan B1',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-03-24',
                'activity' => 'Demonstrasi Cymulate ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-03-24',
                'activity' => 'Demonstrasi Cymulate ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-03-24',
                'activity' => 'Demonstrasi Cymulate ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-03-24',
                'activity' => 'Demonstrasi Cymulate ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-8',
                'activity' => 'Demonstrasi PICUS ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-8',
                'activity' => 'Demonstrasi PICUS ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-8',
                'activity' => 'Demonstrasi PICUS ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-8',
                'activity' => 'Demonstrasi PICUS ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-9',
                'activity' => 'Review RKS CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-9',
                'activity' => 'Mengerjakan RKS CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-10',
                'activity' => 'Demo AttackIQ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-10',
                'activity' => 'Demo AttackIQ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-10',
                'activity' => 'Demo AttackIQ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-10',
                'activity' => 'Demo AttackIQ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-22',
                'activity' => 'Checkpoint CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-22',
                'activity' => 'Checkpoint CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-22',
                'activity' => 'Checkpoint CTEM',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-24',
                'activity' => 'Meeting Finalisasi RKST CTEM - II ',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-04-24',
                'activity' => 'Meeting Finalisasi RKST CTEM - II ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-24',
                'activity' => 'Meeting Finalisasi RKST CTEM - II ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-24',
                'activity' => 'Meeting Finalisasi RKST CTEM - II ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-24',
                'activity' => 'Meeting Finalisasi RKST CTEM - II ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-28',
                'activity' => 'Meeting Progress Weekly ',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-04-28',
                'activity' => 'Meeting Progress Weekly ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-28',
                'activity' => 'Meeting Progress Weekly ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-28',
                'activity' => 'Meeting Progress Weekly ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-28',
                'activity' => 'Meeting Progress Weekly ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-04-30',
                'activity' => 'Checkpoint Finalisasi CTEM ',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-04-30',
                'activity' => 'Checkpoint Finalisasi CTEM ',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-04-30',
                'activity' => 'Checkpoint Finalisasi CTEM ',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-04-30',
                'activity' => 'Checkpoint Finalisasi CTEM ',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-04-30',
                'activity' => 'Checkpoint Finalisasi CTEM ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-15',
                'activity' => 'Review Draft CTEM B dan B1 v1',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-15',
                'activity' => 'Finalisasi Draf CTEM Lampiran B v1',
                'duration' => 0.5
            ],
            [
                'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-15',
                'activity' => 'Finalisasi Draf CTEM Lampiran B v1',
                'duration' => 0.5
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-15',
                'activity' => 'Finalisasi Draf CTEM Lampiran B v1',
                'duration' => 0.5
            ],
            [
                'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-16',
                'activity' => 'Meeting Joint Planning Session - IB Group ',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-16',
                'activity' => 'Meeting Joint Planning Session - IB Group ',
                'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-16',
            'activity' => 'Meeting Joint Planning Session - IB Group ',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-16',
            'activity' => 'Meeting Joint Planning Session - IB Group ',
            'duration' => 0.5
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-16',
            'activity' => 'Meeting Joint Planning Session - IB Group ',
            'duration' => 0.5
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-16',
            'activity' => 'Meeting Joint Planning Session - IB Group ',
            'duration' => 0.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE + ThreatQ demo',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE + ThreatQ demo',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE + ThreatQ demo',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE + ThreatQ demo',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-19',
            'activity' => 'FGD Workshop CTEM ',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD CTEM PHE
            Exercise Security Posture Worksheet - KP PHE
            Meeting STK DevSecOps',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-20',
            'activity' => 'FGD Workshop CTEM ',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-21',
            'activity' => 'FGD Workshop CTEM ',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-22',
            'activity' => 'FGD Workshop CTEM ',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD CTEM PHE',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-23',
            'activity' => 'FGD Workshop CTEM ',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-26',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-27',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team +Demo RF',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'Demo RF',
            'duration' => 0.5
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-05-28',
            'activity' => 'FGD Defensive Security/Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-06-2',
            'activity' => 'Meeting Vendor Anomali (Pararel) ',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-2',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-06-2',
            'activity' => 'Meeting Vendor Anomali (Pararel) ',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-06-2',
            'activity' => 'Meeting Vendor Anomali (Pararel) ',
            'duration' => 1
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-06-2',
            'activity' => 'Meeting Vendor Anomali (Pararel) ',
            'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-06-2',
                'activity' => 'Drafting NR FGD CTEM, IAM, Defensive Security',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-06-3',
                'activity' => 'Drafting Surat Arahan Blue Team
                Internal meeting STK DevSecOps with Equinne',
                'duration' => 1
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-3',
                'activity' => 'Drafting Surat Arahan Blue Team
                Internal meeting STK DevSecOps with Equinne',
                'duration' => 1
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-06-3',
                'activity' => 'Drafting Surat Arahan Blue Team
                Internal meeting STK DevSecOps with Equinne',
                'duration' => 1
            ],
            [
                'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-06-3',
                'activity' => 'Drafting Surat Arahan Blue Team
                Internal meeting STK DevSecOps with Equinne',
                'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-06-3',
            'activity' => 'Formating lampiran b CTEM',
            'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-4',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-5',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-9',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-10',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-06-10',
            'activity' => 'Drafting Lampiran Standarisasi Blue Team',
            'duration' => 0.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Mandiant Meeting ',
            'duration' => 0.5
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Mandiant Meeting ',
            'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Drafting Surat Arahan Blue Team',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Mandiant Meeting ',
            'duration' => 0.5
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Mandiant Meeting ',
            'duration' => 0.5
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Mandiant Meeting ',
            'duration' => 0
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-06-11',
            'activity' => 'Drafting Lampiran Standarisasi Blue Team',
            'duration' => 0.5
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-06-18',
            'activity' => 'Formatting lampiran GRC tools',
            'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-23',
            'activity' => 'Drafting Surat Arahan Blue Team - offering perapihan awal - finalisasi',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-06-30',
            'activity' => 'Drafting Surat Arahan Blue Team - meeting perubahan di surat arahan',
            'duration' => 1
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-2',
            'activity' => 'Number formatting Surat Arahan, berdasarkan email tanggal 3 dan 4 Juli 2025',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-10',
            'activity' => 'Review To do list, Melengkapi Deliverable',
            'duration' => 0.5
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-10',
            'activity' => 'Number formatting Surat Arahan, berdasarkan email 8 Juli 2025',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-11',
            'activity' => 'Update Beberapa Deliverable yg belum sesuai',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-15',
            'activity' => 'Checkpoint CTEM, Drafting OR',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-07-15',
            'activity' => 'Drafting document B4',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-16',
            'activity' => 'Review OE, Revisi OE',
            'duration' => 1
            ],
            [
            'user_id' => 14,'volume_id' => 59,'execution_date' => '2025-07-16',
            'activity' => 'Drafting document B4',
            'duration' => 1
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-20',
            'activity' => 'Revisi Lampiran Surat Arahan Defensive Security',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-21',
            'activity' => 'Revisi Lampiran Surat Arahan Defensive Security',
            'duration' => 0.5
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-07-22',
            'activity' => 'Klarifikasi BoQ SI',
            'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-22',
            'activity' => 'Klarifikasi BoQ SI',
            'duration' => 0.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-07-28',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-07-28',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 2
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-28',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 2
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-07-28',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 2
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-28',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-07-29',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-07-29',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-07-29',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-29',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-29',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-07-30',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-07-30',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-30',
            'activity' => '- Review dokumen B
            - Update CSI -> ICS
            - Update CSO -> OCS
            - Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-30',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-07-31',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 0.5
            ],
            [
            'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-07-31',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-07-31',
            'activity' => '- Update Dokumen B
            - Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-07-31',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1.5
            ],
            [
            'user_id' => 1,'volume_id' => 59,'execution_date' => '2025-08-1',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 0.5
            ],
            [
            'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-08-1',
            'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
            'duration' => 1
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-08-1',
                'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-08-1',
                'activity' => 'Worskhop Performance Review, Pemaparan Progress, dan Strategi Akselerasi Deliverables Proyek EGIS Terintergrasi Tahun 2025',
                'duration' => 1
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-08-4',
                'activity' => 'Update numbering lampiran mengikuti surat arahan (based on request wa 4 Agustus 2025)',
                'duration' => 0.5
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-08-5',
                'activity' => 'Diskusi Surat Arahan Blue Team, dengan catatan: 
                - table sdr capabilities tech matrix menjadi ada di Surat dan Lampiran
                - penambahan sub bab kualifikasi masing2 role per kapabilitas di lampiran untuk sub bab sumber daya manusia (akan dicontohkan dulu oleh mba lidya untuk capabilities SDR)
                - perapihan kembali numbering
                - Konfirmasi kembali sub bab 1.7 di surat yang bagian kewenangan untuk regional/ ap apa perlu disatukan atau tidak (cc mba lidya untuk follow up ke mas oni/pak niko)
                - Lampiran: Matrix Hak, kewajiban, wewenang, tugas dan tanggung jawab di bawah masing-masing capabilities ditarik ke bagian 
                Umum',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-08-5',
                'activity' => 'Perapihan Lampiran Standarisasi Blue Team v.2.4',
                'duration' => 1
            ],
            [
                'user_id' => 4,'volume_id' => 59,'execution_date' => '2025-08-8',
                'activity' => 'Update Dokumen B berdasarkan hasil diskusi',
                'duration' => 0.5
            ],
            [
                'user_id' => 3,'volume_id' => 59,'execution_date' => '2025-08-11',
                'activity' => 'Progress Report dan Disuksi Dokumen B1',
                'duration' => 0.5
            ],
            [
            'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-08-11',
            'activity' => 'Progress Report dan Disuksi Dokumen B1. List fitur-fitur pada kontrak B1',
            'duration' => 0.5
            ],
            [
            'user_id' => 11,'volume_id' => 59,'execution_date' => '2025-08-11',
            'activity' => 'Progress Report dan Disuksi Dokumen B1',
            'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-08-11',
                'activity' => 'Formatting Surat Arahan dan Lampiran Standarisasi Blue Team v.2.4 (berdasarkan meeting 5 Agustus 2025) berdasarkan request PHE by WA 8 Agustus 2025',
                'duration' => 0.5
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-08-12',
                'activity' => 'Update B1, Update List Fitur',
                'duration' => 0
            ],
            [
                'user_id' => 10,'volume_id' => 59,'execution_date' => '2025-08-13',
                'activity' => 'Update B1 - CSI bagian People dan Process',
                'duration' => 0.5
            ],
            [
                'user_id' => 5,'volume_id' => 59,'execution_date' => '2025-08-13',
                'activity' => 'Insert caption gambar dan tabel pada Surat Arahan dan Lampiran Standarisasi Blue Team v.2.4 (berdasarkan request PHE by WA 13 Agustus 2025)',
                'duration' => 0.5
            ],
        ];
        foreach ($timesheets as $timesheet) {
            Timesheet::create($timesheet);
        };
    }
}
