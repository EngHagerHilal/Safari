<?php

namespace App\Http\Controllers\CompanyAuth;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
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
    public $redirectTo = '/company/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('company.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('company.auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
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
        $user=Company::where('email',$request->email)->first();
        if($user==null){
            if($request->wantsJson()) {
                return \Response::json(['error'=>'user not found with this email!']);
            }
            return redirect()->back()->withErrors('email','user not found with this email!');
        }
        $user->verfiy_code=$verfiyCode;
        $user->save();
        $message='reset your password please click link below';
        $url=url('/company/resetPassword/'.$request->email.'/'.$verfiyCode);
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
        if (Auth::guard('company')->attempt($credentials, $request->has('remember'))){
            $Company=Company::where('email',$request->email)->get()->first();
            if($Company->email_verified_at =='')
                return \Response::json(['alert'=>'login failed ','message'=>'your account need to verify please check your email inbox']);
            $Company->api_token= Str::random(60);
            $Company->save();
            $Company=Company::where('email',$request->email)->get()->first();
            return \Response::json(['success'=>'login success ','CompanyData'=>$Company]);
        }
        return \Response::json(['error'=>'login failed ','message'=>'incorrect username or password']);



    }

}
