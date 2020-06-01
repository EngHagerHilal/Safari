<?php

namespace App\Http\Controllers\company;

use App\Admin;
use App\Company;
use App\gallary;
use App\Http\Controllers\Controller;
use App\trips;
use App\User;
use App\userTrips;
use App\voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class companyController extends Controller
{
    public function home(){
        $mytrips=trips::myTrips(Auth::guard('company')->id());
        //return $mytrips;
        return view('company.home',['active'=>$mytrips->active,'disabled'=>$mytrips->disabled,'completed'=>$mytrips->completed,]);
    }
    public function newTrip(){
        return view('company.new_trip');
    }
    public function insertNewTrip(Request $request){
        $dataValidated=$request->validate([
            'title'         => 'required|max:255',
            'description'   => 'required',
            'trip_from'     => 'required',
            'trip_to'       => 'required',
            'phone'         => 'required',
            'price'         => 'required',
            'category'      => 'required',
            'start_at'      => 'required',
            'end_at'        => 'required',
            'img'           => 'required',
            'img.*'         => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        $dataValidated['company_id']=Auth::guard('company')->user()->id;
            unset($dataValidated['img']);
            $trip = trips::create($dataValidated);
            $files=$request->file('img');
            foreach ($files as $file) {
                $newFile = 'img' . time().rand(1,100) . '.' . $file->getClientOriginalExtension();
                $newFilesArray[] = $newFile;
                $file->move(public_path('img/company/' . Auth::guard('company')->user()->id . '/trips/' . $trip->id ), $newFile);
                $img_url = 'img/company/' . Auth::guard('company')->user()->id . '/trips/' . $trip->id . '/' . $newFile;
                $newGallary = gallary::create(
                    [   'trip_id' => $trip->id,
                        'img_url' => $img_url,
                    ]
                )->id;
            }
            return redirect('company/home');
        /*}
        else{
            return redirect()->back()->withErrors('img','one image required at least');
        }*/
    }
    public function newVoucher(Request $request){
        $dataValidated=$request->validate([
            'discount'      => 'required',
            'trip_id'       => 'required',
            'expire_at'     => 'required',
            ]);
        $voucherCode=mt_rand(100000,999999);
        $voucherCode=implode('-',str_split(str_shuffle($voucherCode.time(now())),4));
        $newVoucher=voucher::create([
            'trip_id'=>$request->trip_id,
            'discount'=>$request->discount,
            'expire_at'=>$request->expire_at,
            'code'=>$voucherCode,
        ]);
        if($newVoucher){
            return redirect()->back()->with('success',__('frontEnd.voucher_created').' : '.$voucherCode);
        }
        else{
            return 'error';
            return redirect()->back()->with('alert',__('frontEnd.error_happened'));
        }
    }
    public function controlTrip(Request $request){
        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',Auth::guard('company')->user()->id]])->get()->first();
        if($trip==null){
            return view('error');
        }
        $status=['active','disabled','completed'];
        if(!in_array($request->action,$status))
            return view('error');

        $trip->status=$request->action;
        $trip->save();
        return redirect()->back()->with('trip_message','the trip status udated ')->with('status',$trip->status);
    }
    public function controlJoiners(Request $request){

        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',Auth::guard('company')->user()->id]])->get()->first();
        if($trip==null){
            return 'no';
            return view('error');
        }
        $user=User::find($request->user_id);
        if($user==null){
            return view('error');
        }

        $controlArray=['confirmed','resolved','pending','rejected'];
        $control = $request->action;
        if (!in_array($control, $controlArray)) {
            return view('error');
        }
         $JoinRequest=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',$user->id]
        ])->update(['status'=>$control]);
        if($JoinRequest!=true){
            return view('error');
        }
            return redirect()->back()->with('trip_message','the joiner status updated ')->with('status',$control);
    }
    public function tripDetails(Request $request){

        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',Auth::guard('company')->user()->id]])->get()->first();
        if($trip==null){
            return view('error');
        }
        $trip->img=gallary::where('trip_id','=',$trip->id)->get();
        $joinersNumber=userTrips::where('trip_id',$trip->id)->count();
        $activeVouchers=voucher::where([['trip_id',$trip->id],['status','active']])->get();
        $disableVouchers=voucher::where([['trip_id',$trip->id],['status','disable']])->get();
        $expiredVouchers=voucher::where([['trip_id',$trip->id],['status','expired']])->get();
        return view('company.tripDetails',
            [
                'trip'=>$trip,
                'joinersNumber'=>$joinersNumber,
                'activeVoucher'=>$activeVouchers,
                'disabledVoucher'=>$disableVouchers,
                'expiredVoucher'=>$expiredVouchers,
            ]
        );
        return redirect()->back()->with('trip_message','the trip status udated ')->with('status',$trip->status);
    }



    public function editProfile(){
        $user=Auth::guard('company')->user();
        return view('company.editProfile',['user'=>$user]);

    }
    public function updateProfile(Request $request){
        $dataValidated=$request->validate([
            'name'              => 'required',
            'email'             => 'required|email',
            'current_password'  => 'required',
        ]);
        $other_user=Company::where([
            ['email','=',$request->email],
            ['id','!=',Auth::guard('company')->id()]
        ])->first();
        if(!$other_user){
            $other_user=User::where('email','=',$request->email)->first();
        }
        if($other_user){
            return redirect()->back()->with(['email',__('frontEnd.repeatedEmail')]);
        }
        if($request->has('new_password')){
            $dataValidated=$request->validate([
                'new_password'               => 'required',
                'new_password_confirmation'  => 'required|same:new_password',
            ]);
        }
        if(Auth::guard('company')->attempt(['email'=>$request->email,'password'=>$request->current_password])){
            $user=Company::where('email',$request->email)->first();
            $user->name=$request->name;
            $user->email=$request->email;
            if($request->has('new_password')){
                $user->password=Hash::make($request->new_password);
            }
            $user->save();

            return redirect()->back()->with('success',__('fontEnd.profileUpdated'));
        }
        else{
            return redirect()->back()->withErrors(['current_password' => __('frontEnd.pass_failed')]);
        }
    }

    ////////////api //////////////
    public function insertNewTripAPI(Request $request){
        $user=Company::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $validateRules=[
            'api_token'     => 'required',
            'title'         => 'required|max:255',
            'description'   => 'required',
            'trip_from'     => 'required',
            'trip_to'       => 'required',
            'phone'         => 'required',
            'price'         => 'required',
            'category'      => 'required',
            'start_at'      => 'required',
            'end_at'        => 'required',
            'img'           => 'required',
            'img.*'         => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $error= \Illuminate\Support\Facades\Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $data=[
            'company_id'     => $user->id,
            'title'         => $request->title,
            'description'   => $request->description,
            'trip_from'     => $request->trip_from,
            'trip_to'       => $request->trip_to,
            'phone'         => $request->phone,
            'price'         => $request->price,
            'category'      => $request->category,
            'start_at'      => $request->start_at,
            'end_at'        => $request->end_at,

        ];
        $trip = trips::create($data);
        $files=$request->file('img');
        foreach ($files as $file) {
            $newFile = 'img' . time().rand(1,100) . '.' . $file->getClientOriginalExtension();
            $newFilesArray[] = $newFile;
            $file->move(public_path('img/company/' . $user->id . '/trips/' . $trip->id ), $newFile);
            $img_url = 'img/company/' . $user->id . '/trips/' . $trip->id . '/' . $newFile;
            $newGallary = gallary::create(
                [   'trip_id' => $trip->id,
                    'img_url' => $img_url,
                ]
            )->id;
        }
        return \Response::json(['success'=>'trip created success']);
        /*}
        else{
            return redirect()->back()->withErrors('img','one image required at least');
        }*/
    }
    public function controlTripAPI(Request $request){
        $user=Company::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',$user->id]])->get()->first();
        if($trip==null){
            return \Response::json(['error'=>'trip not found']);
        }
        $trip->status=$request->action;
        $trip->save();
        return \Response::json(['success'=>'trip status updated success']);
    }
    public function homeAPI(Request $request){
        $user=Company::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        return $mytrips=trips::myTrips($user->id);
        //return $mytrips;
    }
    public function tripDetailsAPI(Request $request){
        $user=Company::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',$user->id]])->get()->first();
        if($trip==null){
            return \Response::json(['error'=>'trip not found']);
        }
        $trip->img=gallary::where('trip_id','=',$trip->id)->get();
        $joiners=userTrips::where('trip_id','=',$trip->id)->get();
        foreach ($joiners as $joiner){
            $user=User::find($joiner->user_id)->get()->first();
            $joiner->id=$user->id;
            $joiner->name=$user->name;
            $joiner->email=$user->email;
        }
        return $data=['trip'=>$trip,'joiners'=>$joiners];
    }

    public function controlJoinersAPI(Request $request){
        $user=Company::isLoggedIn($request->api_token);
        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $trip=trips::where([['id','=',$request->trip_id],['company_id','=',$user->id]])->get()->first();
        if($trip==null){
            return \Response::json(['error'=>'not found','message'=>'trip not found']);
        }

        $controlArray=['confirmed','resolved','pending','rejected'];
        $control = $request->action;
        if (!in_array($control, $controlArray)) {
            return \Response::json(['error'=>'not valid','message'=>'the control action not correct']);
        }
        $JoinRequest=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',$request->user_id]
        ])->update(['status'=>$control]);
        if($JoinRequest!=true){
            return \Response::json(['error'=>'not found','message'=>'the join request not found']);
        }

        return \Response::json(['success'=>'updated success','message'=>'the join request updated to be'.$control]);
    }

}
