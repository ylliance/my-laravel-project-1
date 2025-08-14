<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_no', 128);
            $table->string('shop', 512);
            $table->string('type');
            $table->integer('value');
            $table->enum('status', ['valid', 'used', 'expired'])->default('expired');
            $table->integer('member_id')->nullable(true);
            $table->dateTime('used_at');
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
        Schema::dropIfExists('coupons');
    }
}
