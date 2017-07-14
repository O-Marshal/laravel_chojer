<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 角色权限表
        Schema::create('admin_role_permissions', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->comment('角色ID');
            $table->integer('permission_id')->unsigned()->comment('权限ID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_role_permissions');
    }
}
