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
        Schema::create('work', function (Blueprint $table) {
            $table->id('work_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('volume_id');
            // $table->integer('mandays_realization')->default(0);
            // $table->decimal('resource_cost', 15, 2)->default(0.00); // biaya tenaga kerja (Rp)
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user')->onDelete('cascade');
            $table->foreign('volume_id')->references('volume_id')->on('work_package_volume')->onDelete('cascade');
            $table->unique(['user_id', 'volume_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work');
    }
};
