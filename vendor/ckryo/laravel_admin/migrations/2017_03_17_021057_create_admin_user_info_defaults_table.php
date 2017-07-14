<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserInfoDefaultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 账号信息 - 员工
        Schema::create('admin_user_info_defaults', function (Blueprint $table) {
            $table->integer('user_id')->unique()->comment('关联账号');
            $table->tinyInteger('sex')->default(0)->comment('性别: 0 男, 1 女');
            $table->char('qq', 20)->nullable()->comment('qq');
            $table->char('wechat', 20)->nullable()->comment('微信');
            $table->char('address', 20)->nullable()->comment('家庭住址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user_info_defaults');
    }
}