<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('會員ID')->nullable(true);
            $table->integer('sailing_id')->comment('船班ID')->nullable(true);
            $table->string('seccode')->comment('訂單編號')->nullable(true);
            $table->string('serial_number')->comment('流水編號')->nullable(true);
            $table->integer('person_number')->comment('人次編號')->nullable(true);
            $table->integer('type')->comment('訂單類型(1:個人訂單 2:團購訂單)')->nullable(true);
            $table->integer('parent_id')->comment('團購主單ID')->nullable(true);
            $table->integer('status')->comment('訂單狀態(1:未入庫 2:已入庫 3:宅配派送中 4:完成 5:取消)')->nullable(true);
            $table->integer('pay_status')->comment('付款狀態(1:未付款 2:已出帳 3:已付款)')->nullable(true);
            $table->integer('total_price')->comment('訂單總金')->nullable(true);
            $table->text('shipment_use')->comment('目的')->nullable(true);
            $table->text('sender_name')->comment('寄件者姓名')->nullable(true);
            $table->text('sender_phone')->comment('寄件者電話')->nullable(true);
            $table->text('sender_address')->comment('寄件者地址')->nullable(true);
            $table->text('sender_company')->comment('寄件者公司名稱')->nullable(true);
            $table->text('sender_taxid')->comment('寄件者統編')->nullable(true);
            $table->text('sender_email')->comment('寄件者信箱')->nullable(true);
            $table->text('for_name')->comment('收件者姓名')->nullable(true);
            $table->text('for_phone')->comment('收件者電話')->nullable(true);
            $table->text('for_address')->comment('收件者地址')->nullable(true);
            $table->text('for_company')->comment('收件者公司名稱')->nullable(true);
            $table->text('for_taxid')->comment('收件者統編')->nullable(true);
            $table->integer('invoice')->comment('發票(1:不需要 2:二聯 3:三聯)')->nullable(true);
            $table->string('captcha')->comment('下線訂單驗證碼')->nullable(true);
            $table->string('updateToken')->comment('修改訂單驗證碼')->nullable(true);
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
        Schema::dropIfExists('orders');
    }
}
