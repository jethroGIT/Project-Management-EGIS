<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set order_index untuk data yang sudah ada
        $volumes = \DB::table('task')
            ->select('volume_id')
            ->distinct()
            ->pluck('volume_id');
        
        foreach ($volumes as $volume_id) {
            $tasks = \DB::table('task')
                ->where('volume_id', $volume_id)
                ->orderBy('task_id', 'asc')
                ->get();
                
            $orderIndex = 1;
            foreach ($tasks as $task) {
                \DB::table('task')
                    ->where('task_id', $task->task_id)
                    ->update(['order_index' => $orderIndex]);
                $orderIndex++;

                // Debug: Log untuk memastikan urutan
                \Log::info("Setting order_index for Task ID: {$task->task_id}, Order: " . ($orderIndex - 1));
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::table('task')->update(['order_index' => 1]);
    }
};
