<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trip_rate extends Model
{
    protected $table = 'users_rating';

    protected $fillable = [
        'user_id', 'trip_id','rate',
    ];
    public static function calcRate($trip_id){
        $ratedCount = trip_rate::where([
            ['trip_id','=',$trip_id],
        ])->get()->count();
        $tripRateSum=trip_rate::where([
            ['trip_id','=',$trip_id],
        ])->sum('rate');
        if($ratedCount>0)
       return ($tripRateSum) / ($ratedCount);
        else return 0;
}
}
