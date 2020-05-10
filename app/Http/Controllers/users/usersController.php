<?php

namespace App\Http\Controllers\users;

use App\Company;
use App\gallary;
use App\Http\Controllers\Controller;
use App\trips;
use App\User;
use App\userTrips;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index(){
        $user=User::find(Auth::id());
         $myTrips = $user->myTrips($user->id);
        $availableTrips= DB::table('trips')
            ->whereNotIn('id', $user->myTripsIds($user->id))
            ->where('status', 'active')
            ->get();
        return view('home',['myTrips'=>$myTrips,'available'=>$availableTrips]);
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
            )->get();

        }
        else{
            $availableTrips = trips::where('status','=','active')->get();
        }

        return view('search',['available'=>$availableTrips]);
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

        return $trip;
    }

}
