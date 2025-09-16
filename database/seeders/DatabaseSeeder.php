<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            RolePermissionSeeder::class,
            WpCategorySeeder::class,
            WorkOrderSeeder::class,
            WorkPackageSeeder::class,
            WorkPackageVolumeSeeder::class,
            HumanResourceSeeder::class,
            WorkSeeder::class,
            TaskSeeder::class,
            SubTaskSeeder::class,
            Timesheet31Seeder::class,
            Timesheet32Seeder::class,
            Timesheet52Seeder::class,
            Timesheet62Seeder::class,
            Timesheet91Seeder::class,
        ]);
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
