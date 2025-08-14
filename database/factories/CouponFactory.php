<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Coupon;
use Faker\Generator as Faker;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'coupon_no' => $faker->userName,
        'shop' => $faker->word,
        'type' => $faker->numberBetween(1,3),
        'value' => $faker->numberBetween(1,100),
        'status' => $faker->numberBetween(0,2), /* valid: 0, used: 1, expired: 2*/ 
        'member_id' => $faker->numberBetween(0,20), 
        'used_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});