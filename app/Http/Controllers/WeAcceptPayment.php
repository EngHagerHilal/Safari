<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeAcceptPayment extends Controller
{
    public function testPayment(){
        $api_key        =env('WE_ACCEPT_API_KEY');
        $iFrameID       =env('WE_ACCEPT_IFRAME_ID');
        $cardIntegration=env('WE_ACCEPT_INTEGRATION_ID');
        $data = ["api_key" => $api_key ];

        $firstLink='https://accept.paymobsolutions.com/api/auth/tokens';
        $FirstResult=$this->postCURL($firstLink,$data);
        $token=$FirstResult->token;
        $merchant_id=$FirstResult->profile->id;
        //return json_encode($FirstResult);
        $secondLink='https://accept.paymobsolutions.com/api/ecommerce/orders';

        $merchant_order_id=strtotime(now());
        $secondParameter=[
            "auth_token"=> $token,
            "delivery_needed"=> "false",
            "merchant_id"=> $merchant_id,
            "merchant_order_id"=> $merchant_order_id,
            "amount_cents"=> "2000",
            "currency"=> "EGP",
            "items"=> [],
            "shipping_data"=>[
                "first_name"=> auth()->user()->name,
                "last_name" => auth()->user()->name,
                "phone_number"=> auth()->user()->phone,
                "email"=> auth()->user()->email,
            ]
        ];
        $secondResult=$this->postCURL($secondLink,$secondParameter);
        //return json_encode($secondResult);
        $order_id=$secondResult->id;

        $thirdLink='https://accept.paymobsolutions.com/api/acceptance/payment_keys';
        $thirdParameter=[
            "auth_token"=> $token,
            "amount_cents"=>"2000",
              "currency"=> "EGP",
              "card_integration_id"=> $cardIntegration,
              "order_id"=> $order_id,
              "billing_data"=> [
                  "apartment"=> "803",
                  "email"=> "claudette09@exa.com",
                  "floor"=> "42",
                  "first_name"=> "Clifford",
                  "street"=> "Ethan Land",
                  "building"=> "8028",
                  "phone_number"=> "+86(8)9135210487",
                  "shipping_method"=> "PKG",
                  "postal_code"=> "01898",
                  "city"=> "Jaskolskiburgh",
                  "country"=> "CR",
                  "last_name"=> "Nicolas",
                  "state"=> "Utah"
              ]
        ];
        $thirdResult=$this->postCURL($thirdLink,$thirdParameter);
        //return json_encode($thirdResult);
        $paymentKey=$thirdResult->token;
        $iFrameURL="https://accept.paymobsolutions.com/api/acceptance/iframes/$iFrameID?payment_token=$paymentKey";

        return view('pay',['url'=>$iFrameURL]);


        $fourthLink='https://accept.paymobsolutions.com/api/acceptance/iframes?token=';
        $fourthParameter=[
            "name"=> "test1",
            "description"=> "end to end iframe testing",
            "content_html"=> "<p>your escaped html</p>",
            "content_js"=> "console.log('this is your javascript');",
            "content_css"=> ".container {color: black;}"
        ];
        $fourthResult=$this->postCURL($fourthLink.$token,$fourthParameter);
        return $token;
        return json_encode($fourthResult);


    }
    public function postCURL($url,$data=[]){
        $postdata = json_encode($data);
        $remoteConnection=curl_init();
        curl_setopt($remoteConnection,CURLOPT_URL,$url);
        curl_setopt($remoteConnection, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($remoteConnection, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($remoteConnection, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($remoteConnection, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($postdata))
        );
        return json_decode(curl_exec($remoteConnection));

    }
}
