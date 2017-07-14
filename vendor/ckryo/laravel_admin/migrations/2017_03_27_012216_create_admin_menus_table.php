<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 菜单信息
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('is_top')->default(0)->comment('是否顶级菜单');
            $table->integer('parent_id')->default(0)->comment('父级菜单');
            $table->integer('order')->default(0)->comment('排序');

            $table->string('title')->comment('名称');
            $table->char('icon', 15)->nullable()->comment('图标');
            $table->string('description')->nullable()->comment('说明文字');
            $table->string('uri')->nullable()->comment('路径');
            $table->char('tree', 1)->nullable()->comment('用于模型递归查询');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
