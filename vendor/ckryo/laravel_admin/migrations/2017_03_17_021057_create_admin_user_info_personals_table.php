<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserInfoPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 账号信息 - 个人信息
        Schema::create('admin_user_info_personals', function (Blueprint $table) {
            $table->integer('user_id')->unique()->comment('关联账号');
            $table->integer('district_id')->comment('关联行政省市');
            $table->char('name', 20)->nullable()->comment('姓名');
            $table->char('card_no', 18)->nullable()->comment('身份证号码');
            $table->string('certificate')->nullable()->comment('证件信息');
            $table->char('mobile', 11)->nullable()->comment('手机号码');
            $table->char('wx', 25)->nullable()->comment('微信号');
            $table->char('qq', 15)->nullable()->comment('qq号码');
            $table->string('district_detail')->nullable()->comment('详细街道信息');
            $table->timestamps();
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
        Schema::dropIfExists('admin_user_info_personals');
    }
}
