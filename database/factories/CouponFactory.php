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
        'status' => $faker->randomElement(['valid', 'used', 'expired']),
        'member_id' => $faker->randomElement([null, 1, 2, 3, 4]), 
        'used_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
        'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});