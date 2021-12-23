<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSailingScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sailing_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('船班名稱')->nullable(true);
            $table->integer('status')->comment('狀態(1:集貨中 2:準備中 3:開航中 4:抵達目的 5:取消)')->nullable(true);
            $table->string('from_country')->comment('出發國家')->nullable(true);
            $table->string('to_country')->comment('抵達國家')->nullable(true);
            $table->date('statement_time')->comment('結單時間')->nullable(true);
            $table->date('parcel_deadline')->comment('包裹進截止日')->nullable(true);
            $table->date('sailing_date')->comment('開船日')->nullable(true);
            $table->date('arrival_date')->comment('抵達目的地倉庫日')->nullable(true);
            $table->integer('on_off')->comment('上架/下架(0:下架 1:上架)')->nullable(true);
            $table->integer('price')->comment('原價')->nullable(true);
            $table->integer('minimum')->comment('低消')->nullable(true);
            $table->string('box_interval')->comment('箱數級距')->nullable(true);
            $table->string('discount')->comment('折扣')->nullable(true);
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
        Schema::dropIfExists('sailing_schedule');
    }
}
