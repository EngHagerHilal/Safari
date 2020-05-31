<?php

namespace App\Http\Controllers\users;

use App\Company;
use App\gallary;
use App\Http\Controllers\Controller;
use App\trip_rate;
use App\trips;
use App\User;
use App\userTrips;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class usersController extends Controller
{

    public function joinToTrip(Request $request){
        $trip = trips::find($request->trip_id);
        if($trip->status !='active'){
            return redirect()->back()->with('alert','you can not join this trip now!');
        }
        $tripJoined=userTrips::where([
                ['trip_id','=',$trip->id],
                ['user_id','=',Auth::id()]
        ])->get()->first();
        if($tripJoined != null){
            return redirect()->back()->with('alert','you are already joined to this trip');
        }
        userTrips::create(['user_id'=>Auth::id(),
        'trip_id'=>$request->trip_id]);
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
        if($tripJoined == null){
            return redirect()->back()->with('alert','you are not joined to this trip!!');
        }
        return redirect()->back()->with('success','you are canceled this trip successfully ');
    }
    public function index(Request $request){
        $myTrips=[];
        if(Auth::check()){
            $availableTrips= DB::table('trips')
                ->whereNotIn('id', Auth::user()->myTripsIds(Auth::id()))
                ->where('status', 'active')
                ->paginate(10);
            $myTrips = Auth::user()->myTrips(Auth::id(),4);

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
        }
        else{
            $availableTrips= DB::table('trips')
                ->where('status', 'active')
                ->paginate(10);
            $myTrips = trips::orderByRaw('RAND()')->take(6)->get();
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


        }
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
        //return ['available'=>$availableTrips,'myTrips'=>$myTrips,];
        return view('home',['available'=>$availableTrips,'myTrips'=>$myTrips,]);
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
        $specilaTRips=Auth::user()->myTrips(Auth::id(),6);
        foreach ($specilaTRips as $availableTrip) {
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
        if($request->ajax()){
            $view = view('postPaginate',['availableTrips'=>$myTrips])->render();
            return response()->json(['success'=>'connection success','posts'=>$view,'pageNumber'=>$request->page]);
        }
        return view('myTrips',['myTrips'=>$myTrips,'specialTrips'=>$specilaTRips,'allCount'=>$allCount]);
    }
    public function search(Request $request){
        $param=[];
        if($request->city!=null){
            $param[]=['trip_to','like','%'.$request->city.'%'];
        }
        if($request->date!=null){
            $param[]=['start_at','=',$request->date];
        }
        if($request->category!=null) {
            $param[]=['category','=',$request->category];
        }

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
                $param
            )->count();
        }
        foreach ($availableTrips as $availableTrip) {
            $ratedCount = trip_rate::where([
                ['trip_id','=',$availableTrip->id],
            ])->get()->count();
            if($ratedCount >0 ){
                $availableTrip->rate=(trip_rate::where([
                        ['trip_id','=',$availableTrip->id],
                    ])->sum('rate')) / ($ratedCount);
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
        if(Auth::check()){
            $myTrips = Auth::user()->myTrips(Auth::id(),4);
        }
        else{
            $myTrips = trips::orderByRaw('RAND()')->take(6)->get();
        }

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

        return view('search',['available'=>$availableTrips,'myTrips'=>$myTrips,'totalFounded'=>$totalFounded]);
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
        $trip->joiners=userTrips::where('trip_id','=',$trip->id)->get()->count();
        $ratedCount = trip_rate::calcRate($trip->id);

        $trip->comapnyName=Company::find($trip->company_id)->name;
        $joined=userTrips::where([['user_id',\auth()->id()],['trip_id',$trip->id]])->get()->first();
        $trip->joined = $joined != null;
        //return $trip;
        return view('tripDetails',['trip'=>$trip]);
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
        ]);
        $other_user=User::where([['email','=',$request->email],['id','!=',Auth::id()]])->first();
        if(!$other_user){
            $other_user=Company::where('email','=',$request->email)->first();
        }
        if($other_user){
            return 'error email';
            return redirect()->back()->with('email',__('frontEnd.repeatedEmail'));
        }
        if($request->has('new_password')){
            $dataValidated=$request->validate([
                'new_password'               => 'required',
                'new_password_confirmation'  => 'required|same:new_password',
            ]);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->current_password])){
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
            return redirect()->back()->withErrors(['current_password' => __('frontEnd.pass_failed')]);
        }
    }


    /*api*/
    public function indexAPI(Request $request){
        $joinedTripsID=[];
        $myTrips=[];
        if($request->has('api_token')){
            $user = User::isLoggedIn($request->api_token);
            if ($user == null) {
                return \Response::json(['error' => 'login', 'message' => 'please login to access this data']);
            }
            $user = User::find($user->id);
            $myTrips = $user->myTrips($user->id);
            $joinedTripsID=$user->myTripsIds($user->id);
        }
        $availableTrips= DB::table('trips')
            ->whereNotIn('id', $joinedTripsID)
            ->where('status', 'active')
            ->get();
        foreach ($availableTrips as $availableTrip) {
            $ratedCount = trip_rate::where([
                ['trip_id','=',$availableTrip->id],
            ])->get()->count();
            if($ratedCount >0 ){
                $availableTrip->rate=(trip_rate::where([
                        ['trip_id','=',$availableTrip->id],
                    ])->sum('rate')) / ($ratedCount);
            }
            else{
                $availableTrip->rate=0;
            }
        }
        foreach ($myTrips as $availableTrip) {
            $ratedCount = trip_rate::where([
                ['trip_id','=',$availableTrip->id],
            ])->get()->count();
            if($ratedCount >0 ){
                $availableTrip->rate=(trip_rate::where([
                        ['trip_id','=',$availableTrip->id],
                    ])->sum('rate')) / ($ratedCount);
            }
            else{
                $availableTrip->rate=0;
            }
        }
        return $data=['myTrips'=>$myTrips,'available'=>$availableTrips];
    }
    public function joinToTripAPI(Request $request){
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
        ])->get()->first();
        if($tripJoined != null){
            return \Response::json(['alert' => 'already joined', 'message' => 'you are already joined to this trip before !']);
        }
        userTrips::create(['user_id'=>$user->id,
            'trip_id'=>$request->trip_id]);
        return \Response::json(['success' => 'joined', 'message' => 'you are now joined to this trip']);

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
        return \Response::json(['success' => 'joined', 'message' => 'you are canceled this trip']);
    }
    public function searchAPI(Request $request){
        $param=[];
        if($request->city!=null){
            $param[]=['trip_to','like','%'.$request->city.'%'];
        }
        if($request->date!=null){
            $param[]=['start_at','=',$request->date];
        }
        if($request->category!=null) {
            $param[]=['category','=',$request->category];
        }

        if(count($param)>0){
            return $availableTrips = trips::where(
                    $param
            )->get();
            return $param;

        }
        else{
            return $availableTrips = trips::where('status','=','active')->get();

        }
    }
    public function tripDetailsAPI(Request $request){
        $trip=trips::where([['id','=',$request->trip_id],['status','!=','disabled']])->get()->first();
        if($trip==null){
            return \Response::json(['error'=>'trip not found']);
        }
        $trip->img=gallary::where('trip_id','=',$trip->id)->get();
        $trip->joiners=userTrips::where('trip_id','=',$trip->id)->get()->count();
        $ratedCount = trip_rate::where([
            ['trip_id','=',$trip->id],
        ])->get()->count();
        if($ratedCount >0 ){
            $trip->rate=(trip_rate::where([
                    ['trip_id','=',$trip->id],
                ])->sum('rate')) / ($ratedCount);
        }
        else{
            $trip->rate=0;
        }
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
        $tripRated=trip_rate::updateOrCreate([
            'trip_id'=>$trip->id,
            'user_id'=>Auth::id(),
            'rate'=>$request->rate
        ]);
        if($tripRated != null){
            return \Response::json(['success' => 'rated', 'message' => 'trip rated successfully ']);
        }
        return \Response::json(['error' => 'error', 'message' => 'error hapend']);
    }

}
