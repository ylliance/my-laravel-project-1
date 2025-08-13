<?php

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

        DB::table('member_stamps')->insert([
            ['member_id' => 3, 'is_used' => 0, 'created_at' => '2025-08-13 01:46:50' ],
            ['member_id' => 3, 'is_used' => 0, 'created_at' => '2025-08-13 02:46:50' ],
            ['member_id' => 3, 'is_used' => 0, 'created_at' => '2025-08-13 03:46:50' ],
            ['member_id' => 5, 'is_used' => 0, 'created_at' => '2025-08-15 01:46:50' ],
            ['member_id' => 5, 'is_used' => 0, 'created_at' => '2025-08-15 02:46:50' ],
            ['member_id' => 5, 'is_used' => 0, 'created_at' => '2025-08-15 03:46:50' ],
            ['member_id' => 5, 'is_used' => 0, 'created_at' => '2025-08-15 04:46:50' ],
        ]);
    }
}
