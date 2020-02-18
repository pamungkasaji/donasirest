<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donatur extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'nama', 'is_anonim', 'jumlah', 'bukti', 'id_konten', 'is_diterima'
    ];

    protected $table = 'donatur';

    public function konten(){
        //belongsTo(related, foreign key, owner key)
        return $this->belongsTo(Konten::class , 'id_konten' , 'id');
    }
}
