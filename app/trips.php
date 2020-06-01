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
            $img=gallary::where('trip_id','=',$trip->id)->get()->first();//->img_url;
            if($img==null){
                $trip->mainIMG='img/no-img.png';
            }
            else{
                $trip->mainIMG=$img->img_url;
            }
            $trip->joinersNumber=userTrips::where(
                'trip_id','=',$trip->id
            )->count();
        }
        foreach ($mytrips->disabled as $trip){
            $img=gallary::where('trip_id','=',$trip->id)->get()->first();//->img_url;
            if($img==null){
                $trip->mainIMG='img/no-img.png';
            }
            else{
                $trip->mainIMG=$img->img_url;
            }
            $trip->joinersNumber=userTrips::where(
                'trip_id','=',$trip->id
            )->count();
        }
        foreach ($mytrips->completed as $trip){
            $img=gallary::where('trip_id','=',$trip->id)->get()->first();//->img_url;
            if($img==null){
                $trip->mainIMG='img/no-img.png';
            }
            else{
                $trip->mainIMG=$img->img_url;
            }
            $trip->joinersNumber=userTrips::where(
                'trip_id','=',$trip->id
            )->count();
        }
        return $mytrips;
    }
    public function joinedUsers()
    {
        return $this->belongsToMany(User::class, 'user_trips');
    }
}
