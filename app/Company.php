<?php

namespace App;

use App\Notifications\CompanyResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable // implements MustVerifyEmail
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verfiy_code','api_token','status','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','url','verfiy_code','email_title','email_message',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CompanyResetPassword($token));
    }
    public static function filterBy($statusFilter)
    {
        return $data=Company::where('status','=',$statusFilter)->get(['name','email','phone']);
    }



    public static function isLoggedIn($api_token){
        $user=Company::where('api_token','=',$api_token)->get()->first();
        if($user==null){
            return null;
        }
        return $user;

    }
}
