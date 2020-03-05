<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Konten extends Model
{
    //
    protected $fillable = [
        'judul','deskripsi','gambar','target','lama_donasi', 'nomorrekening',
        'id_user', 'is_verif',
    ];

    protected $table = 'konten';

    public $timestamps = false;

    public function user(){
        //belongsTo(related, foreign key, owner key)
        return $this->belongsTo(User::class , 'id_user' , 'id');
    }

    public function perkembangan(){

        return $this->hasMany(Perkembangan::class , 'id_konten' , 'id');
    }

    public function donatur(){

        return $this->hasMany(Donatur::class , 'id_konten' , 'id');
    }

    public function perpanjangan(){

        return $this->hasOne(Perpanjangan::class , 'id_konten' , 'id');
    }

}
