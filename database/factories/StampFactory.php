<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MemberStamps;
use Faker\Generator as Faker;

$factory->define(MemberStamps::class, function (Faker $faker) {
    return [
        'member_id' => $faker->numberBetween(1, 10),
        'shop' => $faker->userName,
        'address' => $faker->address,
        'email' => $faker->unique()->safeEmail,
        'phone_number' => $faker->phoneNumber,
        'qr_code' => $faker->uuid
    ];
});
