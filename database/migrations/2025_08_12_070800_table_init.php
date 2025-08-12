<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column for soft deletes
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('role_id');
            $table->string('permission_id');
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('role_id');
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
            $table->softDeletes(); // Adds deleted_at column for soft deletes
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64);
            $table->string('email', 128);
            $table->string('password', 64);
            $table->dateTime('last_login')->nullable();;
            $table->string('ip_address');
            $table->timestamps();
        });

        Schema::create('ip_list', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address');
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
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('ip_list');
    }
}
