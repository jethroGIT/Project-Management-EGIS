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
        Schema::create('trs_humanResource', function (Blueprint $table) {
            $table->id('hresource_id');
            $table->unsignedTinyInteger('role_id');
            $table->unsignedBigInteger('workPackage_id');
            $table->integer('jtk');
            $table->integer('jhk');
            $table->timestamps();

            $table->foreign('role_id')
                ->references('role_id')
                ->on('mst_roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('workPackage_id')
                ->references('workPackage_id')
                ->on('trs_workPackage')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_humanResource');
    }
};
