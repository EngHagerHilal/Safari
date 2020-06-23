@extends('layouts.app')

@section('content')
<div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('alert'))
                    <div class="alert alert-info" role="alert">
                        {{ session('alert') }}
                    </div>
                @endif
                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST" action="{{ route('updatePassword') }}">
                    @csrf
                        <span class="login100-form-title">
                        {{__('frontEnd.resetPassword')}}
                        </span>
                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                        <input class="input100 @error('email') is-invalid @enderror" type="text" name="email" value="{{$email}}" placeholder="{{__('frontEnd.email')}}">
                        <span class="focus-input100"></span>
                        <input type="hidden" name="type" value="{{$type}}">
                        <input type="hidden" name="verfiy_code" value="{{$verfiy_code}}">
                        @error('email')
                        <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                        <input class="input100 @error('new_password') is-invalid @enderror" type="password" name="new_password" placeholder="{{__('frontEnd.new_password')}}">

                        @error('new_password')
                        <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                        <input class="input100 @error('confirm_password') is-invalid @enderror" type="password" name="confirm_password" placeholder="{{__('frontEnd.new_password_confirmation')}}">
                        @error('confirm_password')
                        <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            {{__('frontEnd.save')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
