<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    protected $fillable=[
        'code',
        'trip_id',
        'expire_at',
        'discount',
    ];
}
