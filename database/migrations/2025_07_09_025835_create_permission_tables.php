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
        // mst_permissions
        Schema::create('mst_permissions', function (Blueprint $table) {
            $table->smallIncrements('permission_id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // mst_roles
        Schema::create('mst_roles', function (Blueprint $table) {
            $table->tinyIncrements('role_id');
            $table->string('name');
            $table->string('guard_name');
            $table->string('altName', 30)->nullable();
            $table->string('desc', 255)->nullable();
            $table->decimal('resourceCost', 15, 2)->default(0.00);
            $table->timestamps();

            $table->unique(['name', 'guard_name']);
        });

        // trs_modelPermission (polymorphic pivot)
        Schema::create('trs_modelPermission', function (Blueprint $table) {
            $table->unsignedSmallInteger('permission_id');
            $table->string('model_type');
            $table->unsignedSmallInteger('model_id');
            $table->timestamps();

            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('permission_id')
                ->on('mst_permissions')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['permission_id', 'model_id', 'model_type'],
                'model_has_permissions_permission_model_type_primary');
        });

        // trs_modelRole (polymorphic pivot)
        Schema::create('trs_modelRole', function (Blueprint $table) {
            $table->unsignedTinyInteger('role_id');
            $table->string('model_type');
            $table->unsignedSmallInteger('model_id');
            $table->timestamps();

            $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('role_id')
                ->on('mst_roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['role_id', 'model_id', 'model_type'],
                'model_has_roles_role_model_type_primary');
        });

        // trs_rolePermission (pivot)
        Schema::create('trs_rolePermission', function (Blueprint $table) {
            $table->unsignedTinyInteger('role_id');
            $table->unsignedSmallInteger('permission_id');
            $table->timestamps();

            $table->foreign('role_id')
                ->references('role_id')
                ->on('mst_roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('permission_id')
                ->references('permission_id')
                ->on('mst_permissions')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->primary(['role_id', 'permission_id'],
                'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trs_rolePermission');
        Schema::dropIfExists('trs_modelRole');
        Schema::dropIfExists('trs_modelPermission');
        Schema::dropIfExists('mst_roles');
        Schema::dropIfExists('mst_permissions');
    }
};
