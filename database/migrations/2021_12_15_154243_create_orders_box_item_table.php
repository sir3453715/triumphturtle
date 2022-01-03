<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersBoxItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_box_item', function (Blueprint $table) {
            $table->id();
            $table->Integer('order_id')->comment('訂單ID');
            $table->Integer('box_id')->comment('箱子ID');
            $table->string('item_name')->comment('商品描述')->nullable(true);
            $table->integer('item_num')->comment('數量')->nullable(true);
            $table->float('unit_price')->comment('單價(USD)')->nullable(true);
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
        Schema::dropIfExists('orders_box_item');
    }
}
