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
        Schema::create('trs_workPackVolume', function (Blueprint $table) {
            $table->id('volume_id');
            $table->unsignedBigInteger('workOrder_id');
            $table->unsignedBigInteger('workPackage_id');
            $table->integer('volumeNumber');
            $table->integer('executionYear');
            $table->timestamp('startDate');
            $table->timestamp('endDate');
            $table->timestamps();

            $table->foreign('workPackage_id')
                ->references('workPackage_id')
                ->on('trs_workPackage')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('workOrder_id')
                ->references('workOrder_id')
                ->on('mst_workOrder')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_workPackVolume');
    }
};
