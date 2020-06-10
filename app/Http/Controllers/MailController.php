<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Mail\activeAccount;
use Illuminate\Http\Request;
use App\Mail\DemoEmail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public static function sendEmail($user,$url,$title,$message)
    {
        //$user = Admin::where('id','=',1)->get()->first();
        $user->url=$url;
        $user->email_title=$title;
        $user->email_message=$message;
        return Mail::to($user->email)->send(new activeAccount($user));
    }
}
