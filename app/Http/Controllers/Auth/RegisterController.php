<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
     * Where to redirect users after registration.
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
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:companies'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $verfiyCode=Str::random(70);
        $data=User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'api_token'=>Str::random(60),
            'verfiy_code'=>$verfiyCode,
            'password'=>bcrypt($data['password']),
        ]);

        $message='you need to verfy your account please click link below';
        $url=url('/user/verfiy/'.$data->email.'/'.$verfiyCode);
        //MailController::sendEmail($data,$url,'verfy your account',$message);
        $data->message='email created successfully check your email address to active your account';
        return $data;
    }
    public function APIregister(Request $request)
    {
        $validateRules=[
            'name'          =>  'required|unique:users',
            'email'         =>  'required|unique:users',
            'password'      =>  'required|min:8',

        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $verfiyCode=Str::random(70);
        $data=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'api_token'=>Str::random(60),
            'verfiy_code'=>$verfiyCode,
            'password'=>Hash::make($request->password)
        ]);

        $message='you need to verfy your account please click link below';
        $url=url('/users/verfiy/'.$data->email.'/'.$verfiyCode);
        MailController::sendEmail($data,$url,'verfy your account',$message);
        $data->message='email created successfully check your email address to active your account';

        return $data;
    }

}
