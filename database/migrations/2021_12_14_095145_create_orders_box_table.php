<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_box', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->comment('訂單id');
            $table->integer('box_weight')->comment('毛重(KG)')->nullable(true);
            $table->integer('box_length')->comment('外箱長度(CM)')->nullable(true);
            $table->integer('box_width')->comment('外箱寬度(CM)')->nullable(true);
            $table->integer('box_height')->comment('外箱高度(CM)')->nullable(true);
            $table->integer('box_price')->comment('箱子金額')->nullable(true);
            $table->string('tracking_number')->comment('宅配單號')->nullable(true);
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
        Schema::dropIfExists('orders_box');
    }
}
