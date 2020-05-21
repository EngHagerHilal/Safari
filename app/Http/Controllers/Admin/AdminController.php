<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Company;
use App\Http\Controllers\Controller;
use App\trips;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Compound;

class AdminController extends Controller
{
    public function verifyEmail(Request $request){
        $account=$request->accountType;
        $email=$request->email;
        $verifyCode=$request->verifyCode;
        if($account=='admin'){
            $type='admins';
        }
        elseif($account=='company'){
            $type='companies';
        }
        elseif ($account=='user'){
            $type='users';
        }
        else{
            return view('error');
        }
        $account=DB::table($type)->where([['email','=',$request->email],['verfiy_code','=',$request->verifyCode]])->get()->first();
        if($account==null){
            return view('error');
        }
        elseif($account->email_verified_at !=''){
            return view('email_verified',['username'=>$account->name,'message'=>'your account already verified !']);
        }
        $accountUpdate=DB::table($type)->where(
            [['email','=',$request->email],['verfiy_code','=',$request->verifyCode]]
        )->update(['email_verified_at'=>now()]);
        return view('email_verified',['username'=>$account->name,'message'=>'your email is verified now !.']);
    }
    public function homeAdmin(){
        $users=User::all()->count();
        $active_users=User::filterBy('active')->count();
        $blocked_users=User::filterBy('blocked')->count();
        $companies=Company::all()->count();
        $active_companies=Company::filterBy('active')->count();
        $blocked_companies=Company::filterBy('blocked')->count();
        return view('admin.home',[
            'users'             => $users,
            'active_users'      => $active_users,
            'blocked_users'     => $blocked_users,
            'partners'          => $companies,
            'active_partners'   => $active_companies,
            'blocked_partners'  => $blocked_companies,
            ]);
    }

    public function partnersControl(){
        $patrners=Company::all()->count();
        $pending=Company::filterBy('pending');
        $active=Company::filterBy('active');
        $blocked=Company::filterBy('blocked');
        $rejected=Company::filterBy('rejected');
        return view('admin.partners',['patrners'=>$patrners,'pending'=>$pending,'active'=>$active,'blocked'=>$blocked,'rejected'=>$rejected]);
    }
    public function acceptPartner(Request $request){
        $patrner=Company::find($request->partner_id);
        if($patrner!=null) {
            $patrner->status = 'active';
            $patrner->save();
            return redirect()->back()->with('partner_message_success', 'partner ' . $patrner->name . ' Accepted');
        }
        else{
            return redirect()->back()->with('partner_message_error', 'partner ' . $patrner->name . ' not found');
        }
    }
    public function rejectPartner(Request $request){
        $patrner=Company::find($request->partner_id);
        if($patrner!=null) {
            $patrner->status = 'rejected';
            $patrner->save();
            return redirect()->back()->with('partner_message_success', 'partner ' . $patrner->name . ' rejected');
        }
        else{
            return redirect()->back()->with('partner_message_error', 'partner <strong>' . $patrner->name . '</strong> not found');
        }
    }
    public function activePartner(Request $request){
        $patrner=Company::find($request->partner_id);
        if($patrner!=null) {
            if($patrner->status=='active'){
                $patrner->status = 'blocked';
            }else{
                $patrner->status = 'active';
            }
            $patrner->save();
            return redirect()->back()->with('partner_message_success', 'partner ' . $patrner->name . ' status updated');
        }
        else{
            return redirect()->back()->with('partner_message_error', 'partner <strong>' . $patrner->name . '</strong> not found');
        }
    }
    public function usersControl(){
        $users=User::all()->count();
        $active=User::filterBy('active');
        $blocked=User::filterBy('blocked');
        return view('admin.users',['users'=>$users,'active'=>$active,'blocked'=>$blocked,]);
    }
    public function blockUser(Request $request){
        if(!in_array($request->control,['active','blocked'])){
            return view('error');
        }
        $user=User::find($request->user_id);
        if($user==null){
            return view('error');
        }

        $user->status=$request->control;
        $user->save();
        return redirect()->back()->with('trip_message','the user status udated ')->with('status',$user->status);

    }










    ////////////////////////////api //////////////////////////
    public function APIhome(Request $request){
            Admin::isLoggedIn($request->api_token);
            $users=[];
            $companies=[];

            $users['allCount']=User::all()->count();
            $users['activeCount']=User::filterBy('active')->count();
            $users['blockedCount']=User::filterBy('blocked')->count();
            /*
            $users['active']=User::filterBy('active');
            $users['blocked']=User::filterBy('blocked');
            $companies['active']=Company::filterBy('active');
            $companies['blocked']=Company::filterBy('blocked');
            $companies['pending']=Company::filterBy('pending');
            $companies['rejected']=Company::filterBy('rejected');
            */
            $companies['allCount']=Company::all()->count();
            $companies['activeCount']= Company::filterBy('active')->count();
            $companies['blockedCount']=Company::filterBy('blocked')->count();
            $companies['pendingCount']=Company::filterBy('pending')->count();
            $companies['rejectedCount']=Company::filterBy('rejected')->count();

            $data=new User();
            $data->users=$users;
            $data->companies=$companies;
            return $data;
        }
    public function APIpartnersControl(Request $request){
        Admin::isLoggedIn($request->api_token);
        $companies=[];

        $companies['allCount']=Company::all()->count();
        $companies['activeCount']= Company::filterBy('active')->count();
        $companies['blockedCount']=Company::filterBy('blocked')->count();
        $companies['pendingCount']=Company::filterBy('pending')->count();
        $companies['rejectedCount']=Company::filterBy('rejected')->count();

        $companies['active']=Company::filterBy('active');
        $companies['blocked']=Company::filterBy('blocked');
        $companies['pending']=Company::filterBy('pending');
        $companies['rejected']=Company::filterBy('rejected');



        $data=new User();
        $data->companies=$companies;
        return $data;
    }
    public function APIusersControl(Request $request){
        Admin::isLoggedIn($request->api_token);
        $users=[];

        $users['allCount']=User::all()->count();
        $users['activeCount']=User::filterBy('active')->count();
        $users['blockedCount']=User::filterBy('blocked')->count();

        $users['active']=User::filterBy('active');
        $users['blocked']=User::filterBy('blocked');
        $data=new User();
        $data->users=$users;
        return $data;
    }
    public function APIacceptCompant(Request $request){
        Admin::isLoggedIn($request->api_token);

        $patrner=Company::find($request->company_id);
        if($patrner!=null) {
            $patrner->status = 'active';
            $patrner->save();
            return \Response::json(['success'=>'accepted','message'=>'new company accepted']);
        }
        else{
            return \Response::json(['error'=>'not found','message'=>'company not found']);
        }
    }
    public function APIrejectCompant(Request $request){
        Admin::isLoggedIn($request->api_token);
        $patrner=Company::find($request->company_id);
        if($patrner!=null) {
            $patrner->status = 'rejected';
            $patrner->save();
            return \Response::json(['success'=>'rejected','message'=>'new company rejected']);
        }
        else{
            return \Response::json(['error'=>'not found','message'=>'company not found']);
        }
    }

    }
