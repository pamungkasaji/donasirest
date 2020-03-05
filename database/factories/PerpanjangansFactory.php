<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Perpanjangans;
use Faker\Generator as Faker;

$factory->define(Perpanjangans::class, function (Faker $faker) {
    return [
        'is_request' => $faker->boolean($chanceOfGettingTrue = 40),
        'jumlah_hari' => $faker->numberBetween( 10, 40),
        'alasan' => $faker->sentence(),
        'id_konten' => $faker->numberBetween( 1, 10),
    ];
});
