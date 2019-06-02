<?php

namespace App\Model;

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


}
