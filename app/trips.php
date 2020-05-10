<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trips extends Model
{
    protected $fillable=[
        'title',
        'description',
        'company_id',
        'trip_from',
        'status',
        'category',
        'trip_to',
        'phone',
        'price',
        'start_at',
        'end_at',
    ];
    public static function myTrips($id){
        $mytrips=new trips();
        $mytrips->active=trips::where([['company_id','=',$id],['status','=','active']])->get();
        $mytrips->disabled=trips::where([['company_id','=',$id],['status','=','disabled']])->get();
        $mytrips->completed=trips::where([['company_id','=',$id],['status','=','completed']])->get();
        foreach ($mytrips->active as $trip){
            $trip->joinersCount=userTrips::where('trip_id','=',$trip->id)->get()->count();
        }
        foreach ($mytrips->disabled as $trip){
            $trip->joinersCount=userTrips::where('trip_id','=',$trip->id)->get()->count();
        }
        foreach ($mytrips->completed as $trip){
            $trip->joinersCount=userTrips::where('trip_id','=',$trip->id)->get()->count();
        }
        return $mytrips;
    }
    public function joinedUsers()
    {
        return $this->belongsToMany(User::class, 'user_trips');
    }
}
