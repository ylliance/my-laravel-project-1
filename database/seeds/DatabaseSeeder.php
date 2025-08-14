<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([PermissionRoleSeeder::class]);
        $this->call([PermissionSeeder::class]);
        $this->call([RoleSeeder::class]);
        $this->call([RoleUserSeeder::class]);
        $this->call([UserSeeder::class]);
        $this->call([MemberSeeder::class]);
        $this->call([StampSeeder::class]);
        $this->call([CouponSeeder::class]);
    }
}
