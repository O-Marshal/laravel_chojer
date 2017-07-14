<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeginAdminRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 角色权限外键
//        Schema::table('admin_role_permissions', function (Blueprint $table) {
//            $table->foreign('role_id')->references('id')->on('admin_roles')->onDelete('cascade');
//            $table->foreign('permission_id')->references('id')->on('admin_permissions')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_role_permissions', function (Blueprint $table) {
            //
        });
    }
}
