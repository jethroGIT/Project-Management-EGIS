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
        Schema::create('task', function (Blueprint $table) {
            $table->id('task_id');
            $table->unsignedBigInteger('volume_id');
            $table->text('name');
            $table->decimal('completeness', 5, 2)->nullable();
            $table->enum('status', ['open', 'closed'])->default('open'); // status of the task
            $table->timestamps();

            $table->foreign('volume_id')->references('volume_id')->on('work_package_volume')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
