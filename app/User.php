<?php

namespace App;

use App\Model\Booking;
use App\Model\Therapist;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->hasOne('App\Model\UserProfile');
    }

    public function bookings(){
        return $this->hasMany('App\Model\Booking');
    }
    public function reviews(){
        return $this->hasMany('App\Model\Review');
    }

    public function canReview(Therapist $therapist){
        $bookings=$this->bookings()
            ->where('therapist_id',$therapist->id)
            ->where('status',1)->where('date','<',Carbon::now()->toDateString())->get();
        $reviews=$this->reviews()->where('therapist_id',$therapist->id)->get();
        return sizeof($bookings)>sizeof($reviews);

    }

    public function visited(Booking $visisted){
        $now=Carbon::now();
        if($now->lt(Carbon::parse($visisted->date)) && $visisted->status==1)
            return false;
        else return true;
    }

    public function canCancelBooking(Booking $booking){
        $now=Carbon::now();
        if($now->lt(Carbon::parse($booking->date))){
            return true;
        }
        else {
            if($booking->status==0)
                return true;
            else return false;
        }
    }
}
