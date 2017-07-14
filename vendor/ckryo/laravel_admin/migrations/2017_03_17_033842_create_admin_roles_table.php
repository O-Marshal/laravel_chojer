<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 角色表 - 程序员, 管理员, 运营品牌, 区域, 供应商, 门店, 【员工账号】
        //         组织机构账号, 员工账号
        //         组织角色, 员工角色 - 角色模板
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default(0)->comment('父级角色');

            $table->tinyInteger('type')->default(0)->comment('角色类型:0, 私有角色(管理员); 1,开放角色; 2,自定义角色; 3,模板角色');
            $table->integer('org_id')->unsigned()->default(0)->comment('私有角色定义');
            $table->integer('template_id')->unsigned()->default(0)->comment('模板id');

            $table->char('code', 16)->nullable()->comment('角色识别码, 英文, 模板角色可重复');
            $table->string('name')->comment('角色名称 - 中文显示');
            $table->string('description')->nullable()->comment('角色描述');
            $table->string('tel')->nullable()->comment('部门电话');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_roles');
    }
}
