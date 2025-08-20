<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Admin only
            'manage work packages',
            'manage users',
            'manage roles',
            'manage timesheets',
            // General
            'view wpv details',
            'edit wpv details',
            'manage tasks',
            'edit financial data',
            'view timesheet summary',
            'manage timesheet activity',
            'view user profile',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
}
