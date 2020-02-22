<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Konten;

class LamaWaktu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lama:donasi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengurangi lama waktu donasi tiap hari';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Konten::where('lama_donasi','>', 0)
          ->update(['lama_donasi' => DB::raw('lama_donasi-1')]);
    }
}
