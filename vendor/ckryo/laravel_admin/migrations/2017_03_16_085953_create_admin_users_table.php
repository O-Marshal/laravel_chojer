<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 账号信息表
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->default(0)->comment('角色信息');
            $table->integer('website_id')->unsigned()->default(0)->comment('平台信息');
            $table->integer('org_id')->unsigned()->default(0)->comment('账号归属, 公司信息');


            $table->char('name', 20)->comment('公司名称');
            $table->char('post', 20)->nullable()->comment('职位');

            $table->string('email', 55)->nullable()->comment('邮箱');
            $table->char('mobile')->nullable()->comment('手机号');

            $table->string('account', 20)->comment('账号名称, 最长不能超过 20位');
            $table->string('password');

            $table->rememberToken()->nullable()->comment('web 登录验证');
            $table->string('api_token')->nullable()->comment('app 登录验证');

            $table->timestamps();
            $table->softDeletes();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('check_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
