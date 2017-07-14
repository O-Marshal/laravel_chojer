<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpBlacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ip 黑名单
        Schema::create('ip_blacks', function (Blueprint $table) {
            $table->increments('id');
            $table->char('ip', 20);
            $table->integer('block_time')->comment('封停时间至-');
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_blacks');
    }
}