<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\advertisement;
use App\Company;
use App\gallary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Mail\activeAccount;
use App\trips;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
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
        $account=DB::table($type)->where([['email','=',$request->email],['verfiy_code','=',$request->verifyCode]])->first();
        if($account==null){
            return view('error');
        }
        elseif($account->email_verified_at !=''){
            return view('email_verified',['username'=>$account->name,'message'=>'your account already verified !']);
        }
        $accountUpdate=DB::table($type)->where(
            [['email','=',$request->email],['verfiy_code','=',$request->verifyCode]]
        )->update(['email_verified_at'=>now()]);
        if($type=='companies'){
            $page='company.account_pending';
        }else{
            $page='email_verified';
        }
        return view($page,['username'=>$account->name,'message'=>'your email is verified now !.']);
    }
    public function homeAdmin(){
        $users=User::all()->count();
        $active_users=User::filterBy('active')->count();
        $blocked_users=User::filterBy('blocked')->count();
        $ads=advertisement::all()->count();
        $show_ads=advertisement::where('status','show')->count();
        $hide_ads=advertisement::where('status','hide')->count();
        $companies=Company::all()->count();
        $pending_companies=Company::filterBy('pending')->count();
        $active_companies=Company::filterBy('active')->count();
        $blocked_companies=Company::filterBy('blocked')->count();
        return view('admin.home',[
            'ads'               => $ads,
            'show_ads'          => $show_ads,
            'hide_ads'          => $hide_ads,
            'users'             => $users,
            'active_users'      => $active_users,
            'blocked_users'     => $blocked_users,
            'partners'          => $companies,
            'pending_partners'  => $pending_companies,
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
        $result=['patrners'=>$patrners,'pending'=>$pending,'active'=>$active,'blocked'=>$blocked,'rejected'=>$rejected];
        return view('admin.partners',$result);
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

    public function editProfile(){
        $user=Auth::guard('admin')->user();
        return view('admin.editProfile',['user'=>$user]);
    }
    public function updateProfile(Request $request){
        $dataValidated=$request->validate([
            'name'              => 'required',
            'email'             => 'required|email',
            'current_password'  => 'required',
            'current_email'     => 'required',
            'phone'             => 'required',
        ]);
        $other_user=Admin::where([['email','=',$request->email],['id','!=',Auth::guard('admin')->id()]])->first();
        if($other_user){
            return redirect()->back()->withErrors(['email'=>[__('frontEnd.repeatedData')]]);
        }

        $other_user=User::where([['phone','=',$request->phone],['id','!=',Auth::guard('admin')->id()]])->first();
        if($other_user){
            return redirect()->back()->withErrors(['phone'=>[__('frontEnd.repeatedData')]]);
        }

        if($request->new_password!=''){
            $dataValidated=$request->validate([
                'new_password'               => 'required',
                'new_password_confirmation'  => 'required|same:new_password',
            ]);
        }
        if(Auth::guard('admin')->attempt(['email' => $request->current_email, 'password' => $request->current_password])){
            $user=Auth::guard('admin')->user();
            $user->name=$request->name;
            $user->email=$request->email;
            if($request->new_password!=''){
                $user->password=Hash::make($request->new_password);
            }
            $user->save();

            return redirect()->back()->with('success',__('frontEnd.profileUpdated'));
        }
        else{
            return redirect()->back()->withErrors(['current_password' => __('validation.password')]);
        }
    }

    public function allAdvertisement(){
        $active=advertisement::where('status','show')->get();
        $disactive=advertisement::where('status','!=','show')->get();
        return view('admin.advertisement',['active'=>$active,'disactive'=>$disactive]);
    }
    public function newADS(){
        return view('admin.new_ads');
    }
    public function insertNewADS(Request $request){
        $dataValidated=$request->validate([
            'title'         => 'required|max:255',
            'desc'          => 'required',
            'company_name'  => 'required',
            'img'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $dataValidated['link']=$request->link;
            unset($dataValidated['img']);
        $ads=advertisement::create($dataValidated);
        if($ads){
            $newFile = 'img' . time().rand(1,100) . '.' . $request->file('img')->getClientOriginalExtension();
            $imgUrl='img/ads_img/'.$ads->id.'/'.$newFile;
            $ads->img=$imgUrl;
            $request->img->move(public_path('/img/ads_img/'.$ads->id), $newFile);
            $ads->save();
            return redirect(route('advertisement'))->with('success','new ads inserted');
        }
        return redirect()->back()->with('error','error happened');

    }
    public function newMessage(Request $request){
        if( $request->is('api/*')){
            //validate json
            $validateRules = [
                'name'          => 'required',
                'email'         => 'required',
                'message'       => 'required',
                ];
            $error = Validator::make($request->all(), $validateRules);
            if ($error->fails()) {
                return \Response::json(['errors' => $error->errors()->all()]);
            }
        }else{
            $dataValidated=$request->validate([
                'name'          => 'required',
                'email'         => 'required',
                'message'       => 'required',
            ]);
        }
        $url='mailto: '.$request->email;
        $user=new User();
        $user->name=$request->name;
        $user->message_from_user=$request->email;
        $user->email='ktwil.dzd@clanlenpa.ml';
        $user->email_message=$request->message;
        Mail::to(env('ADMIN_MAIL_RECIVE_FROM_USERS',$user->email))->send(new activeAccount($user));
        if( $request->is('api/*')) {
            return \Response::json(['success' => 'message sent success ']);
        }
            return redirect()->back()->with('success','message received');
    }
    public function controlADS (Request $request){
        if(!in_array($request->control,['show','hide'])){
            return view('error');
        }
        $ads=advertisement::find($request->ads_id);
        if($ads==null){
            return view('error');
        }

        $ads->status=$request->control;
        $ads->save();
        return redirect()->back()->with('success','the ADS is '.$ads->status.' now! ');

    }


    public function updateProfileAPI(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $validateRules=[
            'name'              => 'required',
            'current_email'     => 'required|email',
            'new_email'         => 'email',
            'current_password'  => 'required',
            'phone'             => 'required',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }

        $other_user=Admin::where([
            ['email','=',$request->current_email],
            ['id','!=',$user->id]
        ])->first();

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
        if(Auth::guard('admin')->attempt(['email'=>$request->current_email,'password'=>$request->current_password])){
            $user=Admin::where('email',$request->current_email)->first();
            $user->name=$request->name;
            $user->email=$request->current_email;
            if($request->has('new_password')){
                $user->password=Hash::make($request->new_password);
            }
            if($request->has('new_email')){
                $user->password=Hash::make($request->new_email);
            }
            $user->save();
            return \Response::json(['success'=>'profile updated']);
        }
        else{
            return \Response::json(['error'=> 'incorrect email or password']);
        }
    }
    public function editProfileAPI(Request $request){
        $user=Admin::isLoggedIn($request->api_token);

        if($user==null){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        return \Response::json(['success'=>'profile founded','profileData'=>$user]);
    }
    ////////////////////////////api //////////////////////////
    public function APIhome(Request $request){
            $user=Admin::isLoggedIn($request->api_token);
            if(!$user){
                return \Response::json(['error'=>'login','message'=>'please login to access this data']);
            }
            $users=[];
            $companies=[];
            $ads=[];
            $ads['allCount']=advertisement::all()->count();
            $ads['activeCount']=advertisement::where('status','show')->count();
            $ads['blockedCount']=advertisement::where('status','hide')->count();
            $users['allCount']=User::all()->count();
            $users['activeCount']=User::filterBy('active')->count();
            $users['blockedCount']=User::filterBy('blocked')->count();
            $companies['allCount']=Company::all()->count();
            $companies['activeCount']= Company::filterBy('active')->count();
            $companies['blockedCount']=Company::filterBy('blocked')->count();
            $companies['pendingCount']=Company::filterBy('pending')->count();
            $companies['rejectedCount']=Company::filterBy('rejected')->count();

            $data=new User();
            $data->users=$users;
            $data->companies=$companies;
            $data->ads=$ads;
            return $data;
        }
    public function APIpartnersControl(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
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
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $users=[];
        $users['allCount']=User::all()->count();
        $active=User::filterBy('active');
        $blocked=User::filterBy('blocked');
        $users['activeCount']=$active->count();
        $users['blockedCount']=$blocked->count();
        $users['active']=$active;
        $users['blocked']=$blocked;
        $data=new User();
        $data->users=$users;
        return $data;
    }
    public function APIacceptCompany(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }

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
    public function APIrejectCompany(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
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
    public function APIblockCompany(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $patrner=Company::find($request->company_id);
        if($patrner!=null) {
            $patrner->status = 'blocked';
            $patrner->save();
            return \Response::json(['success'=>'blocked','message'=>'new company blocked']);
        }
        else{
            return \Response::json(['error'=>'not found','message'=>'company not found']);
        }
    }
    public function APIactiveCompany(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $patrner=Company::find($request->company_id);
        if($patrner!=null) {
            $patrner->status = 'active';
            $patrner->save();
            return \Response::json(['success'=>'active','message'=>'new company active']);
        }
        else{
            return \Response::json(['error'=>'not found','message'=>'company not found']);
        }
    }
    public function allAdvertisementAPI(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $active=advertisement::where('status','show')->get();
        $disactive=advertisement::where('status','!=','show')->get();
        return \Response::json(['all ads'=>['active'=>$active,'hide'=>$disactive]]);
    }
    public function insertNewADSAPI(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $validateRules=[
            'title'         => 'required|max:255',
            'desc'          => 'required',
            'owner'         => 'required',
            'img'           => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        $ads=advertisement::create([
            'title'         => $request->title,
            'desc'          => $request->desc,
            'company_name'  => $request->owner,
        ]);
        if($ads){
            $newFile = 'img' . time().rand(1,100) . '.' . $request->file('img')->getClientOriginalExtension();
            $imgUrl='/img/ads_img/'.$ads->id.'/'.$newFile;
            $ads->img=$imgUrl;
            $request->img->move(public_path('/img/ads_img/'.$ads->id), $newFile);
            $ads->save();
            return \Response::json(['success'=>'new ads inserted']);
        }
        return \Response::json(['errors'=>'new ads inserted']);
    }
    public function controlADSAPI(Request $request){
        $user=Admin::isLoggedIn($request->api_token);
        if(!$user){
            return \Response::json(['error'=>'login','message'=>'please login to access this data']);
        }
        $validateRules=[
            'ads_id'        => 'required',
            'status'        => 'required',

        ];
        $error= Validator::make($request->all(),$validateRules);
        if($error->fails()){
            return \Response::json(['errors'=>$error->errors()->all()]);
        }
        if(!in_array($request->status,['show','hide'])){
            return \Response::json(['errors'=>'new status must be show or hide']);
        }
        $ads=advertisement::find($request->ads_id);
        if($ads==null){
            return \Response::json(['errors'=>'ads not found']);
        }
        $ads->status=$request->status;
        $ads->save();
        return \Response::json(['success'=>'ads updated ']);
    }
    public  function randomADS(){
        $ads=advertisement::where('status','show')->orderByRaw('RAND()')->take(3)->get();
        if($ads->count()>0)
        return $ads;
        return \Response::json(['alert'=>'no ads available now ']);
    }

}
