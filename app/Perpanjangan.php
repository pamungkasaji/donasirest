<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perpanjangan extends Model
{
    protected $fillable = [
        'status','jumlah_hari', 'alasan','id_konten', 
    ];

    protected $table = 'perpanjangan';

    public $timestamps = false;

    public function konten(){
        return $this->belongsTo(Konten::class , 'id_konten' , 'id');
    }
}
