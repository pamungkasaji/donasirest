<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    protected $fillable = [
        'judul', 'gambar','id_konten','deskripsi', 
    ];

    protected $table = 'perkembangan';

    public $timestamps = false;

    public function konten(){
        return $this->belongsTo(Konten::class , 'id_konten' , 'id');
    }
}
