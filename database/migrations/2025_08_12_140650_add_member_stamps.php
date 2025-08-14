<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberStamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_stamps', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 128);
            $table->string('shop', 128);
            $table->string('address', 128);
            $table->string('email', 128);
            $table->string('phone_number', 128);
            $table->string('qr_code', 512);
            $table->boolean('is_used')->default(false);
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
        Schema::dropIfExists('member_stamps');
    }
}
