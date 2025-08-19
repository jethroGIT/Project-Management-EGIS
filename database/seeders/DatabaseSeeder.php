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
            WorkPackageSeeder::class,
            WorkPackageVolumeSeeder::class,
            HumanResourceSeeder::class,
            WorkSeeder::class,
            TaskSeeder::class,
            SubTaskSeeder::class,
            TimesheetSeeder::class,
        ]);
        
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
