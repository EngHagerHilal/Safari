<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
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
        $user=Admin::where('email',$request->email)->first();
        if($user==null){
            if($request->wantsJson()) {
                return \Response::json(['error'=>'user not found with this email!']);
            }
            return redirect()->back()->withErrors('email','user not found with this email!');
        }
        $user->verfiy_code=$verfiyCode;
        $user->save();
        $message='reset your password please click link below';
        $url=url('/admin/resetPassword/'.$request->email.'/'.$verfiyCode);
        MailController::sendEmail($user,$url,'reset password',$message);
        if($request->wantsJson()) {
            return \Response::json(['success'=>'email sent success please check your inbox mail!']);
        }
        return redirect()->back()->with('success','email sent success please check your inbox mail!');
    }
    public function ViewResetForm(Request $request){
        if($request->type=='user'){
            $user=User::where([['email',$request->email],['verfiy_code',$request->verfiyCode]])->get()->first();
        }
        elseif($request->type=='company'){
            $user=Company::where([['email',$request->email],['verfiy_code',$request->verfiyCode]])->get()->first();
        }
        elseif($request->type=='admin'){
            $user=Admin::where([['email',$request->email],['verfiy_code',$request->verfiyCode]])->get()->first();
        }
        else{
            return view('error');
        }
        if($user==null){
            return view('notAvialable',['message'=>'this user not found.']);
        }
        $data=[
                'type'=>$request->type,
                'email'=>$request->email,
                'verfiy_code'=>$request->verfiyCode,
        ];
        return view('resetNewPasswordForm',$data);
    }
    public function updateNewPassword(Request $request){
        $validated=$request->validate([
            'type'          => 'required',
            'verfiy_code'   => 'required',
            'email'         => 'required',
            'new_password'  => 'required',
            'confirm_password'=> 'required|same:new_password',
        ]);
        if($request->type=='user'){
            $user=User::where([['email',$request->email],['verfiy_code',$request->verfiy_code]])->get()->first();
        }
        elseif($request->type=='company'){
            $user=Company::where([['email',$request->email],['verfiy_code',$request->verfiy_code]])->get()->first();
        }
        elseif($request->type=='admin'){
            $user=Admin::where([['email',$request->email],['verfiy_code',$request->verfiy_code]])->get()->first();
        }
        else{
            return view('error');
        }
        if($user==null){
            return view('notAvialable',['message'=>'this user not found.']);
        }
        $verfiyCode=Str::random(70);
        $user->password=\Hash::make($request->new_password);
        $user->verfiy_code=$verfiyCode;
        $user->update();
        return redirect('home')->with('success','new password reset success you can now login');
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
