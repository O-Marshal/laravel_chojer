<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogiIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ip 访问记录
        Schema::create('logi_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('finger');
            $table->tinyInteger('is_secure');
            $table->char('method', 10);
            $table->string('host');
            $table->string('uri');
            $table->char('ip', 20);
            $table->string('user_agent');
            $table->text('params');
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
        Schema::dropIfExists('logi_ips');
    }
}
