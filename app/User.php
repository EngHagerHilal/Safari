<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable //implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verfiy_code','api_token','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','url','verfiy_code','email_title','email_message'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public static function filterBy($statusFilter)
    {
        return $data=User::where('status','=',$statusFilter)->get();
    }
    public static function isLoggedIn($api_token){
        $user=User::where('api_token','=',$api_token)->get()->first();
        if($user==null){
            return null;
        }
        return $user;

    }

    public function myTrips($user_id)
    {
        $MyTrips=new User();
        $trips=[];
        $userTrips= userTrips::where('user_id','=',$user_id)->get();
        foreach ($userTrips as $trip){
            $trips[]=trips::find($trip->trip_id);
        }
        return $trips;

    }
    public function myTripsIds($user_id)
    {
        $trips=[];
        $trip_id=userTrips::where('user_id','=',$user_id)->get();
        foreach ($trip_id as $trip){
            $trips[]=$trip->trip_id;
        }
        return $trips;
    }

}
