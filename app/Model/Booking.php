<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $guarded=[];

    public function getStatus(){
        if($this->status==0)
            return "pending";
        else if($this->status==1)
            return "approved";
        else return "cancel";
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function therapist(){
        return $this->belongsTo('App\Model\Therapist');
    }
}
