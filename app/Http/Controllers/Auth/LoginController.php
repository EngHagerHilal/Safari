<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Controllers\MailController;
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
    public function resendEmail(Request $request){
        if($request->wantsJson()){
            //validate json
            $validateRules=[
                'email'         =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
        }
        else{
            $dataValidated=$request->validate([
                'email'         => 'required',
            ]);
        }
        $verfiyCode=Str::random(70);
        $user=User::where('email',$request->email)->first();
        if($user==null){
            if($request->wantsJson()) {
                return \Response::json(['error'=>'user not found with this email !']);
            }
            return redirect()->back()->with('alert','user not found with this email !');
        }
        $user->verfiy_code=$verfiyCode;
        $user->save();
        $message='reset your password please click link below';
        $url=url('/user/resetPassword/'.$request->email.'/'.$verfiyCode);
        MailController::sendEmail($user,$url,'reset password',$message);
        if($request->wantsJson()) {
            return \Response::json(['success'=>'email sent success please check your inbox mail!']);
        }
        return redirect()->back()->with('success','email sent success please check your inbox mail!');
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
            $user=User::where('email',$request->email)->first();
            return \Response::json(['success'=>'login success ','UserData'=>$user]);
        }
        return \Response::json(['error'=>'login failed ','message'=>'incorrect username or password']);



    }

}
