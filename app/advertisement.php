<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class advertisement extends Model
{
    protected $fillable = [
        'title', 'desc', 'company_name','link','img','status',
    ];
}
