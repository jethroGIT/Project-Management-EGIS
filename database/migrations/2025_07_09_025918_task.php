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
        Schema::create('mst_task', function (Blueprint $table) {
            $table->id('task_id');
            $table->unsignedBigInteger('volume_id');
            $table->text('name');
            $table->decimal('completeness', 5, 2);
            $table->string('status');
            $table->timestamps();

            $table->foreign('volume_id')
                ->references('volume_id')
                ->on('trs_workPackVolume')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mst_task');
    }
};
