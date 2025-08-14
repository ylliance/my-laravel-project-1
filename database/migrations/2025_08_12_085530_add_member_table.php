<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('username');
            $table->string('phone_number');
            $table->string('email');
            $table->dateTime('last_login')->nullable();
            $table->timestamps();
        });

        Schema::create('otp_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('password');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
        Schema::dropIfExists('otp_passwords');
    }
}
