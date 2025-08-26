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
        Schema::create('work_package_volume', function (Blueprint $table) {
            $table->id('volume_id');
            $table->unsignedBigInteger('wp_id');
            $table->integer('volume_number');
            $table->integer('execution_year')->nullable();
            $table->integer('work_order_number')->nullable();
            // $table->decimal('completeness', 5, 2)->default(0.00);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();

            $table->foreign('wp_id')->references('wp_id')->on('work_package')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_package_volume');
    }
};
