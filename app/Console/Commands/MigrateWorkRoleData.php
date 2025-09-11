<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Work;
use App\Models\HumanResource;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class MigrateWorkRoleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:work-roles {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing work records to include role_id based on user roles and work package human resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Starting work role migration...');
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }
        
        try {
            DB::beginTransaction();
            
            // Ambil semua work records yang belum memiliki role_id
            $workRecords = Work::whereNull('role_id')
                ->with([
                    'volume.workPackage.humanResources.role',
                    'user.roles'
                ])
                ->get();
            
            if ($workRecords->isEmpty()) {
                $this->info('No work records found that need migration.');
                return 0;
            }
            
            $this->info("Found {$workRecords->count()} work records to migrate");
            
            $updated = 0;
            $skipped = 0;
            $errors = 0;
            
            // Progress bar
            $progressBar = $this->output->createProgressBar($workRecords->count());
            $progressBar->start();
            
            foreach ($workRecords as $work) {
                try {
                    $roleId = $this->determineUserRole($work);
                    
                    if ($roleId) {
                        if (!$dryRun) {
                            $work->update(['role_id' => $roleId]);
                        }
                        
                        $role = Role::find($roleId);
                        $roleName = $role ? $role->name : 'Unknown';
                        
                        Log::info('Work record role migration', [
                            'work_id' => $work->work_id,
                            'user_id' => $work->user_id,
                            'user_name' => $work->user->name ?? 'Unknown',
                            'volume_id' => $work->volume_id,
                            'wp_id' => $work->volume->workPackage->wp_id ?? null,
                            'role_id' => $roleId,
                            'role_name' => $roleName,
                            'dry_run' => $dryRun
                        ]);
                        
                        $updated++;
                    } else {
                        $this->warn("Could not determine role for work_id: {$work->work_id}, user: {$work->user->name}");
                        $skipped++;
                    }
                    
                } catch (\Exception $e) {
                    $this->error("Error processing work_id {$work->work_id}: " . $e->getMessage());
                    Log::error('Work role migration error', [
                        'work_id' => $work->work_id,
                        'error' => $e->getMessage()
                    ]);
                    $errors++;
                }
                
                $progressBar->advance();
            }
            
            $progressBar->finish();
            $this->newLine(2);
            
            // Summary
            $this->info('Migration Summary:');
            $this->table(
                ['Status', 'Count'],
                [
                    ['Updated', $updated],
                    ['Skipped', $skipped],
                    ['Errors', $errors],
                    ['Total', $workRecords->count()]
                ]
            );
            
            if (!$dryRun) {
                DB::commit();
                $this->info('Migration completed successfully!');
            } else {
                DB::rollback();
                $this->info('Dry run completed. Use without --dry-run to apply changes.');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Migration failed: ' . $e->getMessage());
            Log::error('Work role migration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    /**
     * Determine the appropriate role for a work record
     */
    private function determineUserRole(Work $work): ?int
    {
        $user = $work->user;
        $workPackage = $work->volume->workPackage;
        
        if (!$user || !$workPackage) {
            return null;
        }

        // Step 1: Cari role berdasarkan intersection antara user roles dan work package human resources
        $userRoleIds = $user->roles->pluck('id')->toArray();
        $wpRoleIds = $workPackage->humanResources->pluck('role_id')->toArray();
        
        // Ambil role yang ada di user dan juga di work package (kecuali 'karyawan' dan 'admin')
        $matchingRoleIds = array_intersect($userRoleIds, $wpRoleIds);
        
        // Filter out 'karyawan' dan 'admin' roles
        $karyawanRoleId = Role::where('name', 'karyawan')->first()?->id;
        $adminRoleId = Role::where('name', 'admin')->first()?->id;
        
        $validRoleIds = array_filter($matchingRoleIds, function($roleId) use ($karyawanRoleId, $adminRoleId) {
            return $roleId !== $karyawanRoleId && $roleId !== $adminRoleId;
        });
        
        if (!empty($validRoleIds)) {
            // Ambil role pertama yang valid
            return reset($validRoleIds);
        }
        
        // Step 2: Jika tidak ada matching, ambil role pertama dari work package human resources
        $firstHumanResource = $workPackage->humanResources->first();
        if ($firstHumanResource) {
            return $firstHumanResource->role_id;
        }
        
        // Step 3: Fallback ke role user pertama (kecuali karyawan/admin)
        $userValidRoles = $user->roles->filter(function($role) {
            return !in_array($role->name, ['karyawan', 'admin']);
        });
        
        if ($userValidRoles->isNotEmpty()) {
            return $userValidRoles->first()->id;
        }
        
        // Strategi 4: Ultimate fallback ke 'karyawan'
        return $karyawanRoleId;
    }
}
