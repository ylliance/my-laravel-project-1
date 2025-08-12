<?php

use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('role_user')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('role_user')->insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
            ['user_id' => 3, 'role_id' => 3],
            ['user_id' => 4, 'role_id' => 4],
            ['user_id' => 5, 'role_id' => 5],
            ['user_id' => 6, 'role_id' => 6],
            ['user_id' => 7, 'role_id' => 7],
            ['user_id' => 8, 'role_id' => 8],
        ]);
    }
}
