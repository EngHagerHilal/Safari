<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class trip_rate extends Model
{
    protected $fillable = [
        'user_id', 'trip_id','rate',
    ];
}
