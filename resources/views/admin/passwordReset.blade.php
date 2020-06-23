@extends('layouts.app')

@section('content')
<div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
    <div class="limiter">
        <div class="container">
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
                <div class="alert alert-danger" role="alert">
                    {{ session('alert') }}
                </div>
            @endif
        </div>

        <div class="container-login100">
            <div class="wrap-login100">

                <form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="POST" action="{{ route('admin.sendEmailReset') }}">
                    @csrf
                    <span class="login100-form-title">
                            {{__('frontEnd.resetPassword')}}
                        </span>
                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                        <input class="input100 @error('email') is-invalid @enderror" type="text" required name="email" placeholder=" {{__('frontEnd.email')}}">
                        <span class="focus-input100"></span>
                        @error('email')
                        <span class="px-4 invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            {{__('frontEnd.send')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
