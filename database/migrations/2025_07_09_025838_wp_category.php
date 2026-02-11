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
        Schema::create('trs_category', function (Blueprint $table) {
            $table->id('category_id');
            $table->unsignedBigInteger('project_id');
            $table->string('categoryNumber');
            $table->string('name', 100);
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();

            $table->foreign('project_id')
                ->references('project_id')
                ->on('mst_projects')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_category');
    }
};
