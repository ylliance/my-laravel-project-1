<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_request_id')->unique();
            $table->string('external_payment_id')->nullable(); // paymentId from Alipay+
            $table->string('order_id');
            $table->unsignedBigInteger('amount_minor'); // store minor units
            $table->string('currency', 3);
            $table->string('status')->default('created'); // created|processing|succeeded|failed|unknown|closed
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->json('last_notification')->nullable();
            $table->timestamps();
            $table->index(['order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('payments');
    }
}
