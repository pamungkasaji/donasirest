<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //seeding diurutkan dari user -> konten -> perkembangan -> donatur -> perpanjangan

        //factory( \App\User::class , 5 )->create();
        //factory( \App\Konten::class , 10 )->create();
        //factory( \App\Perkembangan::class , 20 )->create();
        //factory( \App\Donatur::class , 40 )->create();
        factory( \App\Perpanjangan::class , 5 )->create();
    }
}
