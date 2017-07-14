<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 权限信息表
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级权限');

            $table->char('key', 15)->comment('权限验证符, 唯一');
            $table->string('name')->comment('权限名称 - 中文显示');
            $table->string('description')->nullable()->comment('权限描述');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_permissions');
    }
}
