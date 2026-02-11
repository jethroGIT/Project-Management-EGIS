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
        Schema::create('trs_workPackage', function (Blueprint $table) {
            $table->id('workPackage_id');
            $table->unsignedBigInteger('category_id');
            $table->string('workPack_number', 10);
            $table->string('name');
            $table->integer('volumeQTY');
            $table->integer('duration');
            $table->text('actualScope');
            $table->text('deliverable');
            $table->timestamps();

            $table->foreign('category_id')
                ->references('category_id')
                ->on('trs_category')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_workPackage');
    }
};
