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
        //seeding diurutkan dari user -> konten -> perkembangan -> donatur

        //factory( \App\User::class , 5 )->create();
        //factory( \App\Konten::class , 10 )->create();
        //factory( \App\Perkembangan::class , 20 )->create();
        factory( \App\Donatur::class , 40 )->create();
    }
}
