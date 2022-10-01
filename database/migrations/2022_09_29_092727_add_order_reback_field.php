<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderRebackField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('reback')->comment('是否回台灣[1:是,2:否]')->nullable();
            $table->string('reback_time')->comment('回台時間')->nullable();
            $table->string('invoice_time')->comment('發票時間')->nullable();//補發票時間
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('reback');
            $table->dropColumn('reback_time');
            $table->dropColumn('invoice_time');
        });
    }
}
