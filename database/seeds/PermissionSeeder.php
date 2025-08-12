<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Schema::disableForeignKeyConstraints();
        \DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('permissions')->insert([
            ['title' => 'role_access'],
            ['title' => 'role_create'],
            ['title' => 'role_edit'],
            ['title' => 'role_show'],
            ['title' => 'role_delete'],

            ['title' => 'user_access'],
            ['title' => 'user_create'],
            ['title' => 'user_edit'],
            ['title' => 'user_show'],
            ['title' => 'user_delete'],

            ['title' => 'member_access'],
            ['title' => 'member_create'],
            ['title' => 'member_edit'],
            ['title' => 'member_show'],
            ['title' => 'member_delete'],

            ['title' => 'coupon_access'],
            ['title' => 'coupon_create'],
            ['title' => 'coupon_edit'],
            ['title' => 'coupon_show'],
            ['title' => 'coupon_delete'],

            ['title' => 'redeem_treasure_access'],

            ['title' => 'redeem_coupon_access'],
        ]);
    }
}
