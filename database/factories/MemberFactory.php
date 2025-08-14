<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'username' => $faker->userName,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'last_login' => $faker->dateTimeBetween('-1 year', 'now'),
    ];
});