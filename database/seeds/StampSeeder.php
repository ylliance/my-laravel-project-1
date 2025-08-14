<?php

use App\MemberStamps;
use Illuminate\Database\Seeder;

class StampSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('member_stamps')->truncate();
        Schema::enableForeignKeyConstraints();
        
        factory(MemberStamps::class, 25)->create();
    }
}
