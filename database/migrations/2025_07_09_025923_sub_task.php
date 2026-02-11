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
        Schema::create('trs_subTask', function (Blueprint $table) {
            $table->id('subTask_id');
            $table->unsignedBigInteger('task_id');
            $table->text('name');
            $table->decimal('completeness', 5, 2);
            $table->string('trs_subTaskcol', 45)->nullable();

            $table->foreign('task_id')
                ->references('task_id')
                ->on('mst_task')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_subTask');
    }
};
