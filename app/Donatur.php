<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    //

    protected $fillable = [
        'nama', 'is_anonim', 'jumlah', 'bukti', 'id_konten', 'is_diterima'
    ];

    protected $table = 'donatur';

    public $timestamps = false;

    public function konten(){
        //belongsTo(related, foreign key, owner key)
        return $this->belongsTo(Konten::class , 'id_konten' , 'id');
    }
}
