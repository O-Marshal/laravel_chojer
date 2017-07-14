<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenuPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 权限 - 菜单对应关系
        Schema::create('admin_menu_permissions', function (Blueprint $table) {
            $table->integer('menu_id')->unsigned()->comment('菜单ID');
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
        Schema::dropIfExists('admin_menu_permissions');
    }
}
