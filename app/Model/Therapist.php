<?php

namespace App\Model;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;

class Therapist extends Authenticatable
{
    //
    use Notifiable;
    use Sluggable;
    use SluggableScopeHelpers;
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
                'unique' => true,
            ]
        ];
    }

    protected $guard = 'therapist';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function profile(){
        return $this->hasOne('App\Model\TherapistProfile');
    }

    public function groups(){
            return $this->belongsToMany('App\Model\Group','therapist_groups');
    }

    public function problems(){
        return $this->belongsToMany('App\Model\Problem','therapist_problems');
    }

    public function services(){
        return $this->hasMany('App\Model\TherapistService');
    }
    
    public function educations(){
        return $this->hasMany('App\Model\TherapistEducation');
    }
    
    public function specializations(){
        return $this->hasMany('App\Model\TherapistSpecialization');
    }
    
    public function schedules(){
        return $this->hasMany('App\Model\TherapistSchedule');
    }

    public function bookings(){
        return $this->hasMany('App\Model\Booking');
    }
    public function reviews(){
        return $this->hasMany('App\Model\Review');
    }

    public function getStars(){
        $reviews=$this->reviews;
        $total=sizeof($reviews);
        $totalStars=0;
        foreach($reviews as $r){
            $totalStars+=$r->stars;
        }
        return $total==0?0:number_format($totalStars/$total,1);
    }

    public function getStarPercentages(){
        $reviews=$this->reviews;
        $size=sizeof($reviews)>0?sizeof($reviews):1;
        $stars=[];
        $stars[1]=0;
        $stars[2]=0;
        $stars[3]=0;
        $stars[4]=0;
        $stars[5]=0;
        foreach($reviews as $r){
            $stars[$r->stars]++;
        }

        foreach ($stars as $index=>$star){
            $stars[$index]=number_format(($stars[$index]*100)/$size,1);
        }


        return $stars;
    }
    public function subscriptions(){
        return $this->hasMany('App\Model\Subscription');
    }
    
    public function canUse(){
        $sub=$this->subscriptions()->where('start','<=',Carbon::now()->toDateTimeString())
            ->where('end','>=',Carbon::now()->toDateTimeString())
            ->first();
        return $sub?true:false;
    }

    public function getLink(){
        $domain= env('APP_URL');
        return $domain.'/therapist-profile/'.$this->slug;
    }

    public function completeAddress(){
        $address=$this->profile->location_name;
        $pn=$this->profile->address;
        if($address && $pn)
            return $pn.' '.$address;
        else if($address && !$pn)
            return $address;
        else if(!$address && $pn)
            return 'Property Number : '.$pn;
        else return '-';
    }


}
