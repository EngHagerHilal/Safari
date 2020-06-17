<?php

namespace App\Http\Controllers\users;

use App\advertisement;
use App\Company;
use App\gallary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\trip_rate;
use App\trips;
use App\User;
use App\userTrips;
use App\voucherUsers;
use App\voucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class usersController extends Controller
{
    public function resendEmailActivation(Request $request){
        if( $request->is('api/*')){
            //validate json
            $validateRules=[
                'email'         =>  'required',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
            $user=User::where('email',$request->email)->first();
            if(!$user){
                $user=Company::where('email',$request->email)->first();
            }
            if(!$user){
                return \Response::json(['errors'=>'user not found']);
            }
            if($user->hasVerifiedEmail()){
                return \Response::json(['errors','your account activated before']);
            }

        }
        else{
            if(!$user=Auth::user()){
                if(!$user=Auth::guard('company')->user());
                return redirect(route('login'));
            }
            if($user->hasVerifiedEmail()){
                return redirect()->back()->with('success','your account activated before');
            }
        }
        $verfiyCode=Str::random(70);
        $user->verfiy_code=$verfiyCode;
        $user->save();
        $message='you need to verfy your account please click link below';
        $url=url('/user/verfiy/'.$user->email.'/'.$verfiyCode);
        MailController::sendEmail($user,$url,'verfy your account',$message);
        if( $request->is('api/*')){
            return \Response::json(['success'=>'activation email sent successfully check your email address to active your account']);
        }
        return redirect()->back()->with('success','activation email sent successfully check your email address to active your account');
    }
    public function resendEmailPasswordAPI(Request $request){
        if( $request->is('api/*')){
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
            if( $request->is('api/*')){
                return \Response::json(['error'=>'user not found with this email!']);
            }
            return redirect()->back()->withErrors('email','user not found with this email!');
        }
        $user->verfiy_code=$verfiyCode;
        $user->save();
        $message='reset your password please click link below';
        $url=url('/user/resetPassword/'.$request->email.'/'.$verfiyCode);
        MailController::sendEmail($user,$url,'reset password',$message);
        if( $request->is('api/*')){
            return \Response::json(['success'=>'email sent success please check your inbox mail!']);
        }
        return redirect()->back()->with('success','email sent success please check your inbox mail!');
    }

    public function joinToTrip(Request $request){

        //////////////////////
        $trip = trips::find($request->trip_id);
        if($trip->status !='active'){
            return redirect()->back()->with('alert','you can not join this trip now!');
        }
        $price=$trip->price;
        $tripJoined=userTrips::where([
                ['trip_id','=',$trip->id],
                ['user_id','=',Auth::id()]
        ])->get()->first();
        if($tripJoined != null){
            return redirect()->back()->with('alert','you are already joined to this trip');
        }
        if($request->has('code')){
            $voucher=voucher::where([['trip_id',$request->trip_id],['code',$request->code],['status','active']])->first();
            if($voucher){
                $usedBefore=voucherUsers::where([['user_id',Auth::id()],['voucher_id',$voucher->id]])->first();
                if($usedBefore){
                    return redirect()->back()->with('alert','you are used this voucher before');
                }
                $newUserVoucher=voucherUsers::create([
                    'voucher_id'=>$voucher->id,
                    'user_id'   =>Auth::id(),
                    'trip_id'   =>$request->trip_id,
                ]);
                if(!$newUserVoucher){
                    return redirect()->back()->with('alert','error happened');
                }
            }
            else{
                return redirect()->back()->with('alert','this voucher invalid');
            }
            $price=$trip->price*$voucher->discount/100;
        }
        $joinCode=mt_rand(100000,999999);
        $joinCode=implode('-',str_split(str_shuffle($joinCode.time(now())),4));
        $user_id=Auth::id();
        $QR_code=public_path(
             "img/users/$user_id/trips/$trip->id"
        );
        if(!is_dir(public_path("img/users/")))
        mkdir(public_path('img/users/'));
        if(!is_dir(public_path("img/users/").Auth::id()))
        mkdir(public_path('img/users/').Auth::id());
         if(!is_dir(public_path("img/users/").Auth::id()."/trips/"))
            mkdir(public_path('img/users/').Auth::id()."/trips/");
         if(!is_dir(public_path("img/users/").Auth::id()."/trips/".$trip->id))
            mkdir(public_path('img/users/').Auth::id()."/trips/".$trip->id);
        $new_img=time(now()).'.png';
         QrCode::format('png')->size(400)
            ->generate($joinCode,$QR_code.'\img_'.$new_img );
        userTrips::create([
            'user_id'=>Auth::id(),
            'trip_id'=>$request->trip_id,
            'joinCode'=>$joinCode,
            'QR_code'=>"img/users/$user_id/trips/$trip->id/img_$new_img",
        ]);
        return view('payment',['price'=>$price,'trip_id'=>$trip->id]);
        if($request->has('code'))
        return redirect()->back()->with('success',__('frontEnd.joined_with_code').' : '.$request->code);
        return redirect()->back()->with('success','you are joined successfully ');
    }
    public function cancleToTrip(Request $request){
        $trip = trips::find($request->trip_id);
        if($trip == null){
            return redirect()->back()->with('alert','trip not found');
        }
        $tripJoined=userTrips::where([
                ['trip_id','=',$trip->id],
                ['user_id','=',Auth::id()]
        ])->delete();

        $usedBefore=voucherUsers::where([['user_id',Auth::id()],['trip_id',$trip->id]])->delete();
        $QR_code=public_path(
            "img/users/".Auth::id()."/trips/$trip->id"
        );
        Controller::deleteDirectory($QR_code);
        if($tripJoined == null){
            return redirect()->back()->with('alert','you are not joined to this trip!!');
        }
        return redirect()->back()->with('success','you are canceled this trip successfully ');
    }
    public function index(Request $request){
        $myTrips=[];
        if($request->has('api_token')){
            $user_id=User::where('api_token',$request->api_token)->first()->id;
        }else{
            $user_id=Auth::id();
        }
        if( $request->is('api/*')){
            if($request->has('api_token')){
                $user=User::where('api_token',$request->api_token)->first();
                $availableTrips= DB::table('trips')
                    ->whereNotIn('id', $user->myTripsIds($user->id))
                    ->where('status', 'active')
                    ->paginate(10);
            }
            else{
                $availableTrips= DB::table('trips')
                    ->where('status', 'active')
                    ->paginate(10);
            }
        }
        else{
            if(Auth::check()){
                $availableTrips= DB::table('trips')
                    ->whereNotIn('id', Auth::user()->myTripsIds(Auth::id()))
                    ->where('status', 'active')
                    ->paginate(10);
            }
            else{
                $availableTrips= DB::table('trips')
                    ->where('status', 'active')
                    ->paginate(10);
            }
        }

        foreach ($availableTrips as $availableTrip) {
            $availableTrip->rate=trip_rate::calcRate($availableTrip->id);
            $rated=trip_rate::where([
                ['trip_id','=',$availableTrip->id],
                ['user_id','=',$user_id],
            ])->first();
            if($rated ){
                $availableTrip->rated=true;
            }
            else{
                $availableTrip->rated=false;
            }
             $availableTrip->companyName=Company::find($availableTrip->company_id)->name;
             $img=gallary::where('trip_id','=',$availableTrip->id)->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='/img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
            $img=gallary::where('trip_id','=',$availableTrip->id)->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='/img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
        }
        if(! $request->is('api/*')){
            $ads=advertisement::where('status','show')->orderByRaw('RAND()')->take(3)->get();
            return view('home',['available'=>$availableTrips,'ads'=>$ads,]);
        }
        else{
            return \response(['available trips'=>$availableTrips]);
        }
    }
    public function pagination(Request $request){
            $availableTrips= DB::table('trips')
                ->where('status', 'active')
                ->paginate(10);
        foreach ($availableTrips as $availableTrip) {
            $availableTrip->rate=trip_rate::calcRate($availableTrip->id);
            $rated=trip_rate::where([
                ['trip_id','=',$availableTrip->id],
                ['user_id','=',Auth::id()],
            ])->get()->first();
            if($rated ){
                $availableTrip->rated=true;
            }
            else{
                $availableTrip->rated=false;
            }
             $availableTrip->companyName=Company::find($availableTrip->company_id)->name;
             $img=gallary::where('trip_id','=',$availableTrip->id)->get()->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
            $img=gallary::where('trip_id','=',$availableTrip->id)->get()->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
        }

            $view = view('postPaginate',compact('availableTrips'))->render();
            return response()->json(['success'=>'connection success','posts'=>$view,'pageNumber'=>$request->page]);

    }
    public function myTrips(Request $request){
        $trips=[];
        $userTrips= userTrips::where('user_id','=',Auth::id())->paginate(10);
        $allCount= userTrips::where('user_id','=',Auth::id())->count();
        foreach ($userTrips as $trip){
            $trips[]=trips::find($trip->trip_id);
        }
        $myTrips = $trips;

        foreach ($myTrips as $availableTrip) {
            $availableTrip->rate = trip_rate::calcRate($availableTrip->id);
            $rated = trip_rate::where([
                ['trip_id', '=', $availableTrip->id],
                ['user_id', '=', Auth::id()],
            ])->get()->first();
            if ($rated) {
                $availableTrip->rated = true;
            } else {
                $availableTrip->rated = false;
            }
            $img = gallary::where('trip_id', '=', $availableTrip->id)->get()->first();//->img_url;
            if ($img == null) {
                $availableTrip->mainIMG = 'img/no-img.png';
            } else {
                $availableTrip->mainIMG = $img->img_url;
            }
            $availableTrip->companyName = Company::find($availableTrip->company_id)->name;
            $img = gallary::where('trip_id', '=', $availableTrip->id)->get()->first();//->img_url;
            if ($img == null) {
                $availableTrip->mainIMG = 'img/no-img.png';
            } else {
                $availableTrip->mainIMG = $img->img_url;
            }
        }

        // return $myTrips;
        $ads=advertisement::where('status','show')->orderByRaw('RAND()')->take(3)->get();
        if($request->ajax()){
            $view = view('postPaginate',['availableTrips'=>$myTrips])->render();
            return response()->json(['success'=>'connection success','posts'=>$view,'pageNumber'=>$request->page]);
        }
        return view('myTrips',['myTrips'=>$myTrips,'ads'=>$ads,'allCount'=>$allCount]);
    }
    public function search(Request $request){
        $param=[];

        if($request->text!=null){
            $param[]=['title', 'LIKE', "%$request->text%"];
            $param[]=['description', 'LIKE', "%$request->text%"];
        }
        if($request->city!=null){
            $param[]=['trip_to','like','%'.$request->city.'%'];
        }
        if($request->date!=null){
            $param[]=['start_at','=',$request->date];
        }
        if($request->category!=null) {
            $param[]=['category','=',$request->category];
        }
        $param[]=['status','=','active'];

        if(count($param)>0){
            $availableTrips = trips::where(
                $param
            )->paginate(10);
            $totalFounded = trips::where(
                $param
            )->count();

        }
        else{
            $availableTrips = trips::where('status','=','active')->paginate(10);
            $totalFounded = trips::where(
                'status','=','active'
            )->count();
        }
        foreach ($availableTrips as $availableTrip) {
            $ratedCount = trip_rate::where([
                ['trip_id','=',$availableTrip->id],
            ])->get()->count();
            if($ratedCount >0 ){
                $availableTrip->rate=trip_rate::calcRate($availableTrip->id);
            }
            else{
                $availableTrip->rate=0;
            }
            $availableTrip->companyName=Company::find($availableTrip->company_id)->name;
            $img=gallary::where('trip_id','=',$availableTrip->id)->get()->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
        }
        if($request->ajax()){
            $view = view('postPaginate',compact('availableTrips'))->render();
            return response()->json(['success'=>'connection success','posts'=>$view,'pageNumber'=>$request->page]);
        }
        $ads=advertisement::where('status','show')->orderByRaw('RAND()')->take(3)->get();



        return view('search',['available'=>$availableTrips,'ads'=>$ads,'totalFounded'=>$totalFounded]);
    }
    public function tripDetails(Request $request){
        $trip=trips::where([['id','=',$request->trip_id],['status','!=','disabled']])->get()->first();
        if($trip==null){
            return view('notAvialable');
        }
        $trip->rate = trip_rate::calcRate($trip->id);
        $rated = trip_rate::where([
            ['trip_id', '=', $trip->id],
            ['user_id', '=', Auth::id()],
        ])->get()->first();
        if ($rated) {
            $trip->rated = true;
        } else {
            $trip->rated = false;
        }
        $trip->img=gallary::where('trip_id','=',$trip->id)->get();
        $trip->joiners=userTrips::where('trip_id','=',$trip->id)->count();
        $ratedCount = trip_rate::calcRate($trip->id);

        $trip->comapnyName=Company::find($trip->company_id)->name;
        $joined=userTrips::where([['user_id',\auth()->id()],['trip_id',$trip->id]])->first();
        if($joined){
            $trip->joined = $joined;
        }
        else{
            $trip->joined = false;
        }
        //return $trip;
        return view('tripDetails',['trip'=>$trip]);
    }
    public function checkVoucher(Request $request){
        if($request->has('code') &&$request->has('trip_id')){
            $voucher=voucher::where([['trip_id',$request->trip_id],['code',$request->code],['status','active']])->first();
            if($voucher) {
                return response()->json(['success' =>'voucher valid','valid'=>true,'discount'=>$voucher->discount]);
            }
            else{
                return response()->json(['error' =>'voucher invalid',]);
            }
        }

    }
    public function rateTrip(Request $request){
        $trip = trips::find($request->trip_id);
        if(!$trip){
            return redirect()->back()->with('alert','sorry trip not found!');
        }
        $tripRated=trip_rate::where([
            'trip_id'=>$trip->id,
            'user_id'=>Auth::id(),
        ])->get()->first();
        if($tripRated==null){

            $tripRated= trip_rate::create([
                'trip_id'=>$trip->id,
                'user_id'=>Auth::id(),
                'rate'=>$request->rate,
            ]);


            if($tripRated != null){
                $newRate=trip_rate::calcRate($request->trip_id);
                return response()->json(['success' =>'rated success','newRate'=>$newRate]);
            }
            return response()->json(['error' =>'rate errors',]);
        }
        else{
            $newRate=trip_rate::calcRate($request->trip_id);

            return response()->json(['success' =>'rated success','already'=>true,'newRate'=>$newRate]);
        }

    }
    public function editProfile(){
        $user=Auth::user();
        return view('editProfile',['user'=>$user]);
    }
    public function updateProfile(Request $request){
        $dataValidated=$request->validate([
            'name'              => 'required',
            'email'             => 'required|email',
            'current_password'  => 'required',
            'current_email'     => 'required',
            'phone'             => 'required',
        ]);
        $other_user=User::where([['email','=',$request->email],['id','!=',Auth::id()]])->first();
        if($other_user){
            return redirect()->back()->with('email',__('frontEnd.repeatedEmail'));
        }
        $other_user=Company::where('email','=',$request->email)->first();
        if($other_user){
            return redirect()->back()->with('email',__('frontEnd.repeatedEmail'));
        }
        $other_user=User::where([['phone','=',$request->phone],['id','!=',Auth::id()]])->first();
        if($other_user){
            return redirect()->back()->with('phone',__('repeated field'));
        }
        $other_user=Company::where('phone','=',$request->phone)->first();
        if($other_user){
            return redirect()->back()->with('phone',__('repeated field'));
        }
        if($request->new_password!=''){
            $dataValidated=$request->validate([
                'new_password'               => 'required',
                'new_password_confirmation'  => 'required|same:new_password',
            ]);
        }
        if(Auth::attempt(['email' => $request->current_email, 'password' => $request->current_password])){
            $user=Auth::user();
            $user->name=$request->name;
            $user->email=$request->email;
            if($request->has('new_password')){
                $user->password=Hash::make($request->new_password);
            }
            $user->save();

            return redirect()->back()->with('success',__('fontEnd.profileUpdated'));
        }
        else{
            return redirect()->back()->withErrors(['current_password' => __('password not correct')]);
        }
    }


    /*api*/
    public function myJoinedTRipsAPI(Request $request){
        if($request->has('api_token')) {
            $user = User::isLoggedIn($request->api_token);
            if ($user == null) {
                return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
            }
            $myTrips = $user->myTrips($user->id);
            foreach ($myTrips as $availableTrip) {
                $availableTrip->ratedCount = trip_rate::calcRate($availableTrip->id);
                $availableTrip->img=$img=gallary::where('trip_id','=',$availableTrip->id)->get();
                if(count($img)<1)
                    $availableTrip->img='/img/no-img.png';
            }
            return $myTrips;
        }
    }
    public function indexAPI(Request $request){
        $joinedTripsID=[];
        if($request->has('api_token')){
            $user = User::isLoggedIn($request->api_token);
            if ($user == null) {
                return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
            }
            $user = User::find($user->id);
            $joinedTripsID=$user->myTripsIds($user->id);
        }
        $availableTrips= DB::table('trips')
            ->whereNotIn('id', $joinedTripsID)
            ->where('status', 'active')
            ->paginate(10);;
        foreach ($availableTrips as $availableTrip) {
            $availableTrip->ratedCount = trip_rate::calcRate($availableTrip->id);
            $availableTrip->img= $img =gallary::where('trip_id','=',$availableTrip->id)->get();
            if(count($img)<1)
                $availableTrip->img='/img/no-img.png';
        }
        return $data=['available trips'=>$availableTrips];
    }
    public function joinToTripAPI(Request $request){
        $user = User::isLoggedIn($request->api_token);
        if ($user == null) {
            return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
        }
        $validateRules=[
            'api_token'     => 'required',
            'trip_id'       => 'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $trip = trips::find($request->trip_id);
        if($trip->status !='active'){
            return \Response::json(['error' => 'not available', 'message' => 'sorry you can not join this trip now']);
        }
        $tripJoined=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',$user->id]
        ])->get()->first();
        if($tripJoined != null){
            return \Response::json(['alert' => 'already joined', 'message' => 'you are already joined to this trip before !']);
        }
        if($request->has('code')){
            $voucher=voucher::where([['trip_id',$request->trip_id],['code',$request->code],['status','active']])->first();
            if($voucher){
                $usedBefore=voucherUsers::where([['user_id',$user->id],['voucher_id',$voucher->id]])->first();
                if($usedBefore){
                    return \Response::json(['alert' => 'used before', 'message' => 'you are used this voucher before !']);
                }
                $newUserVoucher=voucherUsers::create([
                    'voucher_id'=>$voucher->id,
                    'user_id'   =>$user->id,
                    'trip_id'   =>$request->trip_id,
                ]);
                if(!$newUserVoucher){
                    return \Response::json(['error' => 'error happened']);
                }
            }
            else{
                return \Response::json(['alert' => 'invalid', 'message' => 'this voucher invalid !']);
            }
            $price=$trip->price*$voucher->discount/100;
        }
        $joinCode=mt_rand(100000,999999);
        $joinCode=implode('-',str_split(str_shuffle($joinCode.time(now())),4));
        $user_id=$user->id;
        $QR_code=public_path(
            "img/users/$user_id/trips/$trip->id"
        );
        if(!is_dir(public_path("img/users/")))
            mkdir(public_path('img/users/'));
        if(!is_dir(public_path("img/users/").$user_id))
            mkdir(public_path('img/users/').$user_id);
        if(!is_dir(public_path("img/users/").$user_id."/trips/"))
            mkdir(public_path('img/users/').$user_id."/trips/");
        if(!is_dir(public_path("img/users/").$user_id."/trips/".$trip->id))
            mkdir(public_path('img/users/').$user_id."/trips/".$trip->id);
        $new_img=time(now()).'.png';
        QrCode::format('png')->size(400)
            ->generate($joinCode,$QR_code.'\img_'.$new_img );
        $join=userTrips::create([
            'user_id'=>$user->id,
            'trip_id'=>$request->trip_id,
            'joinCode'=>$joinCode,
            'QR_code'=>"img/users/$user_id/trips/$trip->id/img_$new_img",
        ]);
        if($join)
        return \Response::json([
            'success' => 'joined',
            'your data' =>[
                'joinCode'=>$joinCode,
                'QR_code'=>asset("/img/users/$user_id/trips/$trip->id/img_$new_img")
            ]
        ]);
        return \Response::json([
            'error' => 'join','message'=>'sorry error happened '
        ]);
    }
    public function cancleToTripAPI(Request $request){
        $user = User::isLoggedIn($request->api_token);
        if ($user == null) {
            return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
        }
        $trip = trips::find($request->trip_id);
        if($trip->status !='active'){
            return \Response::json(['error' => 'not available', 'message' => 'sorry you can not join this trip now']);
        }
        $tripJoined=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',$user->id]
        ])->delete();
        if($tripJoined == null){
            return \Response::json(['alert' => 'not joined', 'message' => 'you are not joined to this trip before !']);
        }
        $usedBefore=voucherUsers::where([['user_id',Auth::id()],['trip_id',$trip->id]])->delete();
        $QR_code= "img/users/".$user->id."/trips/$trip->id";
        Controller::deleteDirectory($QR_code);

        return \Response::json(['success' => 'canceled', 'message' => 'you are canceled this trip']);
    }
    public function searchAPI(Request $request){
        $param=[];
        if($request->city!=null){
            $param[]=['trip_to','like','%'.$request->city.'%'];
        }if($request->text!=null){
            $param[]=['title', 'LIKE', "%$request->text%"];

        }
        if($request->city!=null){
            $param[]=['trip_to','like','%'.$request->city.'%'];
        }
        if($request->date!=null){
            $param[]=['start_at','=',$request->date];
        }
        if($request->category!=null) {
            $param[]=['category','=',$request->category];
        }
        $param[]=['status','=','active'];

        if(count($param)>0){
            $availableTrips = trips::where(
                    $param
            )->paginate(10);
            $availableTrips->totalAvailable = trips::where(
                $param
            )->count();
        }
        else{
            $availableTrips = trips::where('status','=','active')->paginate(10);
            $availableTrips->totalAvailable = trips::where(
                'status','=','active'
            )->count();
        }
        foreach ($availableTrips as $availableTrip) {
            $ratedCount = trip_rate::where([
                ['trip_id','=',$availableTrip->id],
            ])->get()->count();
            if($ratedCount >0 ){
                $availableTrip->rate=trip_rate::calcRate($availableTrip->id);
            }
            else{
                $availableTrip->rate=0;
            }
            $availableTrip->companyName=Company::find($availableTrip->company_id)->name;
            $img=gallary::where('trip_id','=',$availableTrip->id)->get()->first();//->img_url;
            if($img==null){
                $availableTrip->mainIMG='/img/no-img.png';
            }
            else{
                $availableTrip->mainIMG=$img->img_url;
            }
        }


        return $availableTrips;
    }
    public function tripDetailsAPI(Request $request){
        $trip=trips::where([['id','=',$request->trip_id],['status','!=','disabled']])->first();
        if($trip==null){
            return \Response::json(['error'=>'trip not found']);
        }
        if($request->has('api_token')){
            $user = User::isLoggedIn($request->api_token);
            if ($user == null) {
                return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
            }
            $rated = trip_rate::where([
                ['trip_id', '=', $trip->id],
                ['user_id', '=', $user->id],
            ])->get()->first();
            if ($rated) {
                $trip->rated = true;
            } else {
                $trip->rated = false;
            }
            $joined=userTrips::where([['user_id',$user->id],['trip_id',$trip->id]])->first();
            if($joined){
                $trip->joinCode = $joined->joinCode;
                $trip->QR_Code = $joined->QR_Code;
            }
        }
        $trip->img=gallary::where('trip_id','=',$trip->id)->get();
        $trip->joiners=userTrips::where('trip_id','=',$trip->id)->count();
        $trip->rateCount = trip_rate::calcRate($trip->id);

        $trip->comapnyName=Company::find($trip->company_id)->name;

        return $trip;
    }
    public function rateTripAPI(Request $request){
        $user = User::isLoggedIn($request->api_token);
        if ($user == null) {
            return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
        }
        $trip = trips::find($request->trip_id);
        if($trip ==null){
            return \Response::json(['error' => 'not found', 'message' => 'sorry trip not found!']);
        }
        $validateRules=[
            'trip_id'         =>  'required',
            'rate'            =>  'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $tripRated=trip_rate::where([
            'trip_id'=>$trip->id,
            'user_id'=>$user->id,
        ])->first();
        if($tripRated==null){
            $tripRated= trip_rate::create([
                'trip_id'=>$trip->id,
                'user_id'=>$user->id,
                'rate'=>$request->rate,
            ]);
            if($tripRated != null){
                $newRate=trip_rate::calcRate($request->trip_id);
                return \Response::json(['success' => 'rated', 'message' => 'trip rated successfully ','newRate'=>$newRate]);
            }
            return response()->json(['error' =>'rate errors',]);
        }
        else{
            $newRate=trip_rate::calcRate($request->trip_id);
            return \Response::json(['alert' =>'rated before','newRate'=>$newRate]);
        }
    }
    public function updateProfileAPI(Request $request){
        $user=User::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $validateRules=[
            'name'              => 'required',
            'email'             => 'required|email',
            'current_password'  => 'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }

        $other_user=User::where([
            ['email','=',$request->email],
            ['id','!=',$user->id]
        ])->first();
        if(!$other_user){
            $other_user=Company::where('email','=',$request->email)->first();
        }
        if($other_user){
            return \Response::json(['errors'=>['email'=>'duplicated email']]);

        }
        if($request->has('new_password')){
            $validateRules=[
                'new_password'               => 'required',
                'new_password_confirmation'  => 'required|same:new_password',
            ];
            $error= Validator::make($request->all(),$validateRules);
            if($error->fails()){
                return \Response::json(['errors'=>$error->errors()->all()]);
            }
        }
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->current_password])){
            $user=User::where('email',$request->email)->first();
            $user->name=$request->name;
            $user->email=$request->email;
            if($request->has('new_password')){
                $user->password=Hash::make($request->new_password);
            }
            $user->save();
            return \Response::json(['success'=>'profile updated']);

        }
        else{
            return \Response::json(['error'=> 'incorrect email or password']);
        }
    }
    public function editProfileAPI(Request $request){
        $user=User::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        return \Response::json(['success'=>'profile founded','profileData'=>$user]);
    }
}
