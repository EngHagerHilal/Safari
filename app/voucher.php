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
    public static function checkExpiredVoucher($date=null){
        if(!$date){
            $date=date("Y-m-d");
        }
        $expired=voucher::where('expire_at',$date)->get();
        foreach ($expired as $voucher){
            $voucher->status='expired';
            $voucher->save();
        }
    }
}
