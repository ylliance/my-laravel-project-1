<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('users')->insert([
            ['name' => "Super Admin", 'email' => "admin@admin.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-0", 'email' => "talent0@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-1", 'email' => "talent1@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-2", 'email' => "talent2@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-3", 'email' => "talent3@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-4", 'email' => "talent4@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-5", 'email' => "talent5@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
            ['name' => "Talent-6", 'email' => "talent6@talent.com", 'password' => Hash::make('secret2025'), 'ip_address' => '127.0.0.1'],
        ]);
    }
}
