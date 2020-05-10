<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userTrips extends Model
{
    protected $fillable = [
        'user_id', 'trip_id',
    ];

}
