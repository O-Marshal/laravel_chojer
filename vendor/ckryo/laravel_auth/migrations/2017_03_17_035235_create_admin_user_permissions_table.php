<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_permissions', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->comment('用户ID');
            $table->integer('permission_id')->unsigned()->comment('权限ID');
            $table->tinyInteger('is_inverse')->default(0)->comment('屏蔽权限, 用于屏蔽角色本身拥有的权限');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_permissions');
    }
}
