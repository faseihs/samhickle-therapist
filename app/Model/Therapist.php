<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Therapist extends  Authenticatable
{
    //
    use Notifiable;

    protected $guard = 'therapist';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

}
