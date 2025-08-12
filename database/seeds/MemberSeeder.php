<?php

use Illuminate\Database\Seeder;
use App\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('members')->truncate(); // or Member::truncate();
        Schema::enableForeignKeyConstraints();
        
        factory(Member::class, 50)->create();
    }
}
