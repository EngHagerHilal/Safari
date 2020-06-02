
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/')}}/payment_style.css">
    <meta name="robots" content="noindex,follow" />
</head>
<body>

<div class="checkout-panel">
    <div class="panel-body" style="padding: 120px">
        <h2 class="title">Checkout</h2>

        <div class="progress-bar">
            <div class="step active"></div>
            <div class="step active"></div>
            <div class="step"></div>
            <div class="step"></div>
        </div>

        <div class="payment-method">
            <label for="card" class="method card">
                <div class="card-logos">
                    <img src="{{asset('img')}}/visa_logo.png"/>
                    <img src="{{asset('img')}}/mastercard_logo.png"/>
                </div>

                <div class="radio-input">
                    <input id="card" type="radio" name="payment">
                    Pay {{$price}} $ with credit card
                </div>
            </label>

            <label for="paypal" class="method paypal">
                <img src="{{asset('img')}}/paypal_logo.png"/>
                <div class="radio-input">
                    <input id="paypal" type="radio" name="payment">
                    Pay {{$price}} $ with PayPal
                </div>
            </label>
        </div>

        <div class="input-fields">
            <div class="column-1">
                <label for="cardholder">Cardholder's Name</label>
                <input type="text" id="cardholder" />

                <div class="small-inputs">
                    <div>
                        <label for="date">Valid thru</label>
                        <input type="text" id="date" placeholder="MM / YY" />
                    </div>

                    <div>
                        <label for="verification">CVV / CVC *</label>
                        <input type="password" id="verification"/>
                    </div>
                </div>

            </div>
            <div class="column-2">
                <label for="cardnumber">Card Number</label>
                <input type="password" id="cardnumber"/>

                <span class="info">* CVV or CVC is the card security code, unique three digits number on the back of your card separate from its number.</span>
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <button class="btn back-btn"><a href="{{url('/tripDetails/'.$trip_id)}}"> Back</a></button>
        <button class="btn next-btn"><a href="{{url('/tripDetails/'.$trip_id)}}"> Next Step</a></button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{asset('/js')}}/payment_code.js"></script>
</body>
</html>
