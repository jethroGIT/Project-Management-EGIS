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
        Schema::create('sub_task', function (Blueprint $table) {
            $table->id('sub_task_id');
            $table->unsignedBigInteger('task_id');
            $table->text('name');
            $table->decimal('completeness', 5, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('task_id')->references('task_id')->on('task')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_task');
    }
};
