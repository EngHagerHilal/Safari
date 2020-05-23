<?php

namespace App\Http\Controllers\AdminAuth;

use App\Admin;
use App\Http\Controllers\MailController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Admin
     */
    protected function create(array $data)
    {
        $verfiyCode=Str::random(70);
        $data=Admin::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'api_token'=>Str::random(60),
            'verfiy_code'=>$verfiyCode,
            'password'=>bcrypt($data['password']),
        ]);

        $message='you need to verfy your account please click link below';
        $url=url('/admin/verfiy/'.$data->email.'/'.$verfiyCode);
        //MailController::sendEmail($data,$url,'verfy your account',$message);
        $data->message='email created successfully check your email address to active your account';
        return $data;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('admin.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }


    public function APIregister(Request $request)
    {
        $validateRules=[
            'name'          =>  'required|unique:admins',
            'email'         =>  'required|unique:admins',
            'password'      =>  'required|min:8',

        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $verfiyCode=Str::random(70);
        $data=Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'api_token'=>Str::random(60),
            'verfiy_code'=>$verfiyCode,
            'password'=>Hash::make($request->password)
        ]);

        $message='you need to verfy your account please click link below';
        $url=url('/admin/verfiy/'.$data->email.'/'.$verfiyCode);
        MailController::sendEmail($data,$url,'verfy your account',$message);
        $data->message='email created successfully check your email address to active your account';

        return $data;
    }

}
