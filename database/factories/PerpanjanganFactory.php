<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Perpanjangan;
use Faker\Generator as Faker;

$factory->define(Perpanjangan::class, function (Faker $faker) {
    return [
        //'is_request' => $faker->boolean($chanceOfGettingTrue = 40),
        'status' => $faker->randomElement($array = array ('verifikasi','diterima','ditolak')),
        'jumlah_hari' => $faker->numberBetween( 10, 40),
        'alasan' => $faker->sentence(),
        'id_konten' => $faker->numberBetween( 1, 10),
    ];
});
