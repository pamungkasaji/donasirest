<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Perkembangan;
use Faker\Generator as Faker;

$factory->define(Perkembangan::class, function (Faker $faker) {
    return [
        //
        'judul' => $faker->sentence,
        'deskripsi' => $faker->paragraph,
        'id_konten' => $faker->numberBetween( 1, 10),
        'gambar' => $faker->imageUrl( 800, 600 ),
    ];
});
