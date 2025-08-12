<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('roles')->insert([
            ['title' => 'SuperAdmin'],
            ['title' => 'Talent 0'],
            ['title' => 'Talent 1'],
            ['title' => 'Talent 2'],
            ['title' => 'Talent 3'],
            ['title' => 'Talent 4'],
            ['title' => 'Talent 5'],
            ['title' => 'Talent 6'],
        ]);
    }
}
