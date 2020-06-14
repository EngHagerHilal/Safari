@extends('company.layout.auth')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <h2 class="text-center">{{__('wellcome_back')}}</h2>
                    <h4 class="text-center">{{__('account_rejected')}}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection
