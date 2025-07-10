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
        Schema::create('resource', function (Blueprint $table) {
            $table->id('resource_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('wp_id');
            $table->integer('jtk')->default(1); // Jumlah Tenaga Kerja
            $table->integer('jhk'); // Jumlah Hari Kerja
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('role')->onDelete('cascade');
            $table->foreign('wp_id')->references('wp_id')->on('work_package')->onDelete('cascade');
            $table->unique(['wp_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resource');
    }
};
