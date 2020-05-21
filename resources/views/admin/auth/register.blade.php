@extends('admin.layout.auth')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <form class="login100-form validate-form p-l-55 p-r-55 p-t-178"method="POST" action="{{ url('/admin/register') }}">
                        @csrf
                        <span class="login100-form-title text-uppercase">
                        {{__('frontEnd.register')}}
                        </span>

                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                            <input required class="input100 @error('name') is-invalid @enderror" type="text" name="name" id="name" placeholder="{{__('frontEnd.your_name')}}">
                            <span class="focus-input100"></span>
                            @error('name')
                            <span class="px-4 invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                            <input id="email" class="@error('email') is-invalid @enderror input100" type="email" name="email" placeholder="{{__('frontEnd.your_email')}}" required="required" autocomplete="email" >
                            <span class="focus-input100"></span>
                            @error('email')
                            <span class="px-4 invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                            <input class="@error('password') is-invalid @enderror input100" placeholder="{{__('frontEnd.password')}}" id="password" type="password" name="password" required="required" autocomplete="new-password" aria-autocomplete="list">
                            <span class="focus-input100"></span>
                            @error('password')
                            <span class="px-4 invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                            <input class="@error('password_confirmation') is-invalid @enderror input100" id="password-confirm" placeholder="{{__('frontEnd.confirm_pass')}}" type="password" name="password_confirmation" required="required" autocomplete="new-password" aria-autocomplete="list">

                            <span class="focus-input100"></span>
                            @error('password_confirmation')
                            <span class="px-4 invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="text-right p-t-13 p-b-23">
                        <span class="txt1">
                        </span>
                            <a href="{{route('login')}}" class="txt2">
                                {{__('frontEnd.have_account')}}
                            </a>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn">
                                {{__('frontEnd.sign_up')}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
