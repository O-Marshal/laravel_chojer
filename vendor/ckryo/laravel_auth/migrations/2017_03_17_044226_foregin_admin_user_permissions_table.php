<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeginAdminUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户权限外键
        Schema::table('admin_user_permissions', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('admin_permissions')->onDelete('cascade');
        });
    }

}
