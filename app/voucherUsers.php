<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucherUsers extends Model
{
    protected $fillable=[
        'code',
        'voucher_id',
        'user_id',
        'trip_id',
    ];
}
