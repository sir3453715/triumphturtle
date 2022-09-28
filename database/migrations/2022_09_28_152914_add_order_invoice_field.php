<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderInvoiceField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_status')->comment('發票狀態')->nullable();
            $table->string('invoice_code')->comment('發票號碼')->nullable();
            $table->text('invoice_cancel_reason')->comment('作廢原因')->nullable();
            $table->text('invoice_result')->comment('發票回傳')->nullable();
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
            $table->dropColumn('invoice_status');
            $table->dropColumn('invoice_code');
            $table->dropColumn('invoice_cancel_reason');
            $table->dropColumn('invoice_result');
        });
    }
}
