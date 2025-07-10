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
        Schema::create('work_package', function (Blueprint $table) {
            $table->id('wp_id');
            $table->string('wp_number')->unique();
            $table->string('name');
            $table->integer('volume_qty')->default(1);
            $table->integer('duration'); // in days
            $table->text('actual_scope_contract')->nullable();
            $table->text('deliverable')->nullable();
            $table->decimal('completeness', 5, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_package');
    }
};
