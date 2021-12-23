<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->id();
            $table->string('country')->comment('國家')->nullable();
            $table->string('img')->comment('圖片')->nullable();
            $table->string('title')->comment('倉庫名稱')->nullable();
            $table->string('phone')->comment('電話')->nullable();
            $table->text('address')->comment('地址')->nullable();
            $table->text('link')->comment('購買連結')->nullable();
            $table->text('notes')->comment('備註說明')->nullable();
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
        Schema::dropIfExists('warehouse');
    }
}
