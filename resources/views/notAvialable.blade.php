@extends('layouts.app')

@section('content')
<div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <h4 class="text-center text-uppercase py-5">sorry !</h4>
                <h5 class="text-center py-5">{{ $message ?? 'this trip not available now.' }}</h5>
            </div>
        </div>
    </div>
</div>

@endsection
