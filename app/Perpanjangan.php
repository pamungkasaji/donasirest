<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perpanjangan extends Model
{
    //
    protected $fillable = [
        'is_request','jumlah_hari', 'alasan','id_konten', 
    ];

    protected $table = 'perpanjangan';

    public $timestamps = false;

    public function konten(){
        //belongsTo(related, foreign key, owner key)
        return $this->belongsTo(Konten::class , 'id_konten' , 'id');
    }
}
