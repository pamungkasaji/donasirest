<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    //
    protected $table = 'admin';

    public $timestamps = false;

    use Notifiable;

    //protected $guard = 'admin';

    protected $fillable = [
        'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];
}
