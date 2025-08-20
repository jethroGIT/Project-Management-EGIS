<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions = [
            // halaman manajemen kelola komponen work package
            'manage work packages',
            'manage users',
            'manage roles',
            'manage timesheets',
        ];

        $generalPermissions = [
            // halaman work package volume
            'view wpv details',
            'edit wpv details',
            'manage tasks',
            'edit financial data',
            'view timesheet summary',
            'manage timesheet activity',    
            // halaman profil user
            'view user profile'
        ];
        
        // identify admin and karyawan roles
        $adminRole = Role::where('name', 'admin')->first();
        $karyawanRole = Role::where('name', 'karyawan')->first();

        // assign permissions to admin role
        $adminRole->givePermissionTo(array_merge($adminPermissions, $generalPermissions));

        // assign general permissions to karyawan role
        $karyawanRole->givePermissionTo($generalPermissions);
    }
}
