<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $guarded=[];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function therapist(){
        return $this->belongsTo('App\Model\Therapist');
    }
}
