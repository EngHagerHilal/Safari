@extends('company.layout.auth')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST" action="{{route('company.login')}}">
                        @csrf
                        <span class="login100-form-title">
                        {{__('frontEnd.partner_login')}}
                        </span>
                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                            <input class="input100 @error('email') is-invalid @enderror" type="text" name="email" placeholder="email">
                            <span class="focus-input100"></span>
                            @error('email')
                            <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Please enter password">
                            <input class="input100 @error('password') is-invalid @enderror" type="password" name="password" placeholder="{{__('frontEnd.password')}}">
                            <span class="focus-input100"></span>
                            @error('password')
                            <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="text-right p-t-13 p-b-23">
                        <span class="txt1">
                        </span>
                            <a href="{{route('forgotPassword')}}" class="txt2">
                                {{__('frontEnd.forgot_password')}}
                            </a>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                {{__('frontEnd.login')}}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
