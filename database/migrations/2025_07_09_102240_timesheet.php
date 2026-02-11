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
        Schema::create('trs_timesheet', function (Blueprint $table) {
            $table->id('timesheet_id');
            $table->unsignedSmallInteger('user_id');
            $table->unsignedBigInteger('volume_id');
            $table->date('execution_date');
            $table->text('activity');
            $table->decimal('duration', 3, 1);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('user_id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('cascade');

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
        Schema::dropIfExists('trs_timesheet');
    }
};
