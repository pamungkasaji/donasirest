<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'password' => bcrypt(123456),
        'fotoktp' => $faker->imageUrl( 800, 600 ),
        'nohp' => $faker->phoneNumber,
        'namalengkap' => $faker->name,
        'alamat' => $faker->address,
        'nomorktp' => $faker->numberBetween(6000000, 9000000),
        'is_verif' => $faker->boolean($chanceOfGettingTrue = 70),
    ];
});
