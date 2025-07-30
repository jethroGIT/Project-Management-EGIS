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
        Schema::create('role', function(Blueprint $table){
            $table->id('role_id');
            $table->string('name',30)->unique();
            $table->string('alt_name', 30)->nullable();
            $table->text('desc')->nullable();
            $table->decimal('resource_cost', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
