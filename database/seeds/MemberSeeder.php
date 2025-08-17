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
        \DB::table('members')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('members')->insert([
            'uuid' => 'eb0baac3-086b-3095-a292-822d4b4f91f4',
            'username' => 'Test User',
            'phone_number' => '838-274-8156',
            'email'=> 'test_user@test.com',
            'created_at' => new DateTime,
            'updated_at' => new DateTime,
        ]);

        factory(Member::class, 2500)->create();
    }
}
