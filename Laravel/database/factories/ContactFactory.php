<?php

use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'avatar' => $faker->avatar,
        'first_name' => $faker->first_name,
        'last_name' => $faker->last_name,
        'address' => $faker->address,
        'city' => $faker->city,
        'zip' => $faker->zip,
        'country' => $faker->country,
        'email' => $faker->email,
        'phone' => $faker->phone,
        'note' => $faker->note
    ];
});
