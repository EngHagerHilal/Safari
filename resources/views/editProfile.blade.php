@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
    $offset_1= str_replace('_', '-', app()->getLocale()) =='ar' ? 'margin-right:8.3%' : 'margin-left:8.3%';
@endphp
@extends('layouts.app')

@section('content')
<div class="main-bg-safary">
    <div class="container bg-glass ">
        <div dir="ltr" class="row mb-5">
            <div class="col-md-10 offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="font-weight-bolder text-center py-5">

                        </h2>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    @if(session('status'))
                        <div class="alert alert-success">
                            status now : <strong>{{session('status')}}</strong>
                        </div>
                    @endif
                    <div class="panel-body">
                        <div class="row">
                            <div class="{{$text}} col-10 col-md-8 offset-lg-2">
                                <form style="background-color: rgba(211,211,211,0.53);border-radius: 15px"
                                      class="overflow-hidden login100-form validate-form p-l-55 p-r-55 p-t-178 mb-3"
                                      method="POST" action="{{ route('users.updateProfile') }}">
                                    @csrf
                                    <span class="login100-form-title text-uppercase">
                                        <strong>
                                            {{__('frontEnd.Edit_profile')}}
                                        </strong>
                                    </span>

                                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                                        <input required class="{{$text}} input100 @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{$user->name}}" placeholder="{{__('frontEnd.your_name')}}">
                                        <input required type="hidden" name="current_email" value="{{$user->email}}" >
                                        <span class="focus-input100"></span>
                                        @error('name')
                                        <span class="px-4 invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
                                        <input id="email" class="@error('email') is-invalid @enderror input100 {{$text}}" type="email" name="email" placeholder="{{__('frontEnd.your_email')}}" value="{{$user->email}}" required="required" autocomplete="email" >
                                        <span class="focus-input100"></span>
                                        @error('email')
                                        <span class="px-4 invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                                        <input class="@error('current_password') is-invalid @enderror input100 {{$text}}" placeholder="{{__('frontEnd.current_password')}}" id="current_password" type="password" name="current_password" required="required" autocomplete="new-password" aria-autocomplete="list">
                                        <span class="focus-input100"></span>
                                        @error('current_password')
                                        <span class="px-4 invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                                        <input class="@error('new_password') is-invalid @enderror input100 {{$text}}" placeholder="{{__('frontEnd.new_password')}}" id="new_password" type="password" name="new_password" aria-autocomplete="list">
                                        <span class="focus-input100"></span>
                                        @error('new_password')
                                        <span class="px-4 invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="wrap-input100 validate-input m-b-16" data-validate="Please enter password">
                                        <input class="@error('new_password_confirmation') is-invalid @enderror input100 {{$text}}" id="new_password_confirmation" placeholder="{{__('frontEnd.new_password_confirmation')}}" type="password" name="new_password_confirmation" autocomplete="new-password" aria-autocomplete="list">

                                        <span class="focus-input100"></span>
                                        @error('new_password_confirmation')
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
            </div>
        </div>
    </div>
</div>

@endsection
