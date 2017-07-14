<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserInfoCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 账号信息 - 公司信息
        Schema::create('admin_user_info_companies', function (Blueprint $table) {
            $table->integer('user_id')->unique()->comment('关联账号');
            $table->integer('district_id')->comment('关联行政省市');
            $table->char('name', 20)->nullable()->comment('公司简称');
            $table->char('full_name', 20)->nullable()->comment('公司全称');
            $table->char('card_no', 25)->nullable()->comment('证件号');
            $table->string('certificate')->nullable()->comment('证件信息');
            $table->char('mobile', 11)->nullable()->comment('公司电话');
            $table->char('contact_name', 20)->nullable()->comment('联系人姓名');
            $table->char('contact_phone_bk', 25)->nullable()->comment('联系人电话(紧急)');
            $table->char('contact_phone', 25)->nullable()->comment('联系人电话');
            $table->char('contact_name_bk', 20)->nullable()->comment('联系人姓名(紧急)');
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
        Schema::dropIfExists('admin_user_info_companies');
    }
}
