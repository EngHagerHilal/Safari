<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function ApiLogin(Request $request)
    {
        $validateRules=[
            'email'         =>  'required',
            'password'      =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $credentials  = array('email' => $request->email, 'password' =>$request->password);
        if (Auth::attempt($credentials, $request->has('remember'))){
            $user=User::where('email',$request->email)->get()->first();
            if($user->email_verified_at =='')
                return \Response::json(['alert'=>'login failed ','message'=>'your account need to verify please check your email inbox']);
            $user->api_token= Str::random(60);
            $user->save();
            $user=User::where('email',$request->email)->get()->first();
            return \Response::json(['success'=>'login success ','UserData'=>$user]);
        }
        return \Response::json(['error'=>'login failed ','message'=>'incorrect username or password']);



    }

}
