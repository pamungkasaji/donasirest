<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Donatur;
use Faker\Generator as Faker;

$factory->define(Donatur::class, function (Faker $faker) {
    return [
        //
        'nama' => $faker->name,
        'is_anonim' => $faker->boolean($chanceOfGettingTrue = 40),
        'is_diterima' => $faker->boolean($chanceOfGettingTrue = 70),
        'jumlah' => $faker->numberBetween( 20000, 100000),
        'bukti' => $faker->imageUrl( 800, 600 ),
        'nohp' => $faker->phoneNumber,
        'id_konten' => $faker->numberBetween( 1, 10),
    ];
});
