<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Konten;
use Faker\Generator as Faker;

$factory->define(Konten::class, function (Faker $faker) {
    return [
        //
        'judul' => $faker->sentence,
        'deskripsi' => $faker->text,
        'id_user' => $faker->numberBetween( 1, 5),
        'gambar' => $faker->imageUrl( 800, 600 ),
        'target' => $faker->numberBetween( 5000000, 80000000),
        'terkumpul' => $faker->numberBetween( 2000000, 4000000),
        'lama_donasi' => $faker->numberBetween( 30, 90),
        'nomorrekening' => $faker->randomNumber(8),
        'bank' => $faker->name,
        'status' => $faker->randomElement($array = array ('verifikasi','aktif','selesai','ditolak')),
    ];
});
