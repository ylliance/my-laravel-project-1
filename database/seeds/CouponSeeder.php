<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Coupon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        \DB::table('coupons')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::table('coupons')->insert([
            'coupon_no' => 'S546124$*%2343423534',
            'shop' => 'Candy Street Shop',
            'type' => '2',
            'value'=> '50',
            'status' => 'valid',
            'member_id' => 1,
            'created_at'=> date('Y-m-d H:i:s'), 
        ]);
        
        factory(Coupon::class, 10)->create();
    }
}
