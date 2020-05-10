<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Support\Facades\Hash;
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

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
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
        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))){
            $admin=Admin::where('email',$request->email)->get()->first();
            $admin->api_token= Str::random(60);
            $admin->save();
            $admin=Admin::where('email',$request->email)->get()->first();
            return \Response::json(['success'=>'login success ','AdminData'=>$admin]);
        }
        return \Response::json(['error'=>'login failed ','message'=>'incorrect username or password']);



    }

}
