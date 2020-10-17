<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'subject' => $faker->sentence,
        'inquiry' => $faker->realText,
    ];
});
