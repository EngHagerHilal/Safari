<?php

namespace App\Http\Controllers;

use App\trips;
use App\userTrips;
use App\voucher;
use App\voucherUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class paypalController extends Controller
{
    private $apiContext;
    private $secret;
    private $clientId;
    public function __construct()
    {
        $this->clientId=config('paypal.client_id');
        $this->secret=config('paypal.secret');

        $this->apiContext=new ApiContext(new OAuthTokenCredential($this->clientId,$this->secret));
        $this->apiContext->setConfig(config('paypal.settings'));
    }
    public function payWithPayPal(Request $request){
        $trip = trips::find($request->trip_id);
        if($trip->status !='active'){
            return redirect()->back()->with('alert','you can not join this trip now!');
        }
        $price=$trip->price;
        $tripJoined=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',Auth::id()]
        ])->first();
        if($tripJoined != null){
            return redirect()->back()->with('alert','you are already joined to this trip');
        }
        if($price<=0)
            return redirect()->back()->with('alert','price can not be 0');
        if(!$request->code==''){
            $voucher=voucher::where([['trip_id',$request->trip_id],['code',$request->code],['status','active']])->first();
            if($voucher){
                $price=$trip->price*$voucher->discount/100;
            }
            else{
                return redirect()->back()->with('alert','this voucher invalid');
            }
        }
        //////////////////
        $name=$trip->title;
        $payer=new Payer();
        $payer->setPaymentMethod('PAYPAL');
        $item=new Item();
        $item->setName($name)->setCurrency('USD')->setQuantity(1)->setPrice($price);
        $itemList=new ItemList();
        $itemList->setItems([$item]);
        $amount=new Amount();
        $amount->setCurrency('USD')->setTotal($price);
        $transition = new Transaction();
        $transition->setAmount($amount)->setItemList($itemList)->setDescription($trip->description);
        $redirectURLs=new RedirectUrls();
        $redirectURLs->setReturnUrl(route('paypal.status',['trip_id'=>$trip->id,'voucher_code'=>$request->code]))->setCancelUrl(route('users.tripDetails',['trip_id'=>$trip->id]));
        $payment=new Payment();
        $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectURLs)->setTransactions([$transition]);
        try{
            $payment->create($this->apiContext);
        }catch (\PayPal\Exeption\PPConnectionExeption $ex){
            dd($ex);
        }
        $paymentLink=$payment->getApprovalLink();
        return redirect($paymentLink);
    }
    public function joinToTrip(Request $request){
        if(!$request->PayerID||!$request->token||!$request->trip_id){
            dd('payment not completed');
        }
        if(!$request->code=='') {
            $voucher=voucher::where('code', $request->code)->first();
            $usedBefore = voucherUsers::where([['user_id', Auth::id()], ['voucher_id', $voucher->id]])->first();
            if ($usedBefore) {
                return redirect()->back()->with('alert', 'you are used this voucher before');
            }
            $newUserVoucher = voucherUsers::create([
                'voucher_id' => $voucher->id,
                'user_id' => Auth::id(),
                'trip_id' => $request->trip_id,
            ]);
        }
        $paymentId=$request->paymentId;
        $payment=Payment::get($paymentId,$this->apiContext);
        $execution=new PaymentExecution();
        $execution->setPayerId($request->PayerID);
        try {
            $result = $payment->execute($execution, $this->apiContext);
        }
        catch(Exception $e){
            die($e);
        }
        $trip=trips::find($request->trip_id);
        $tripJoined=userTrips::where([
            ['trip_id','=',$trip->id],
            ['user_id','=',Auth::id()]
        ])->first();
        if($tripJoined != null){
            return redirect()->back()->with('alert','you are already joined to this trip');
        }
        if($result->getState()=='approved'){
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
            if(!$request->code=='')
                return redirect()->back()->with('success',__('frontEnd.joined_with_code').' : '.$request->code);
                return redirect()->back()->with('success','you are joined successfully ');
        }
        else{
            return redirect()->back()->with('alert','sorry error happened !!!');
        }

    }
}
