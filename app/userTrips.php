<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userTrips extends Model
{
    protected $fillable = [
        'user_id', 'trip_id','status','joinCode','QR_code'
    ];
    public static function checkCode($code,$trip_id=null){
        if($trip_id)
        $valid=userTrips::where([['joinCode',$code],['trip_id',$trip_id]])->first();
        else
        $valid=userTrips::where('joinCode',$code)->first();
        if($valid)
            return $valid;
        return false;
    }

}
