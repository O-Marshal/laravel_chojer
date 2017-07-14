<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogiActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logi_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('logi_id')->commit('ip访问记录id');
            $table->string('union_module')->commit('关联模块');
            $table->integer('union_id')->commit('关联ID');
            $table->string('action')->commit('行为');
            $table->string('description')->commit('描述');
            $table->text('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logi_actions');
    }
}
