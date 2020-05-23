@extends('layouts.app')

@section('content')
<div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <h4 class="text-center text-uppercase">sorry !</h4>
                @if($message!=null)
                <h5 class="text-center">{{$message}}</h5>
                @else
                    <h5 class="text-center">this trip not available now.</h5>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
