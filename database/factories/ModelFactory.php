<?php

use Illuminate\Support\Facades\Hash;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => $faker->e164PhoneNumber,
        'password' => Hash::make('secret'),
        'type' => 'teacher',
        'is_active' => true,
    ];
});
