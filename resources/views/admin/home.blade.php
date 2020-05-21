@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
    $offset_1= str_replace('_', '-', app()->getLocale()) =='ar' ? 'margin-right:8.3%' : 'margin-left:8.3%';
@endphp
@extends('admin.layout.auth')

@section('content')
    <div class="main-bg-safary">
        <div class="container bg-glass">
            <div dir="ltr" class="row">
                <div class="col-md-10 offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="font-weight-bolder text-center py-5">
                                <strong>
                                    {{Auth::guard('admin')->user()->name}}</strong> {{__('frontEnd.dashboard')}}
                            </h2>
                        </div>

                        @if(session('trip_message'))
                            <div class="alert alert-success">
                                {{session('trip_message')}}
                            </div>
                        @endif
                        @if(session('status'))
                            <div class="alert alert-success">
                                status now : <strong>{{session('status')}}</strong>
                            </div>
                        @endif
                        <div class="panel-body">
                            <h3 class="font-weight-bolder text-center">
                                {{__('frontEnd.partners')}}
                            </a></h3>
                            <div dir="{{$dir}}" class="row">
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/partners/')}}" class="text-dark">
                                            {{__('frontEnd.all_partners')}} [{{$partners}}]
                                        </a>
                                    </h3>
                                </div>
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/partners/')}}" class="text-dark">
                                            {{__('frontEnd.active_partners')}} [{{$active_partners}}]
                                        </a>
                                    </h3>
                                </div>
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/partners/')}}" class="text-dark">
                                            {{__('frontEnd.blocked_partners')}} [{{$blocked_partners}}]
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            <hr>

                            <h3 class="font-weight-bolder text-center">
                                {{__('frontEnd.users')}}
                            </a></h3>
                            <div dir="{{$dir}}" class="row">
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/users/')}}" class="text-dark">
                                            {{__('frontEnd.all_users')}} [{{$users}}]
                                        </a>
                                    </h3>
                                </div>
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/users/')}}" class="text-dark">
                                            {{__('frontEnd.active_users')}} [{{$active_users}}]
                                        </a>
                                    </h3>
                                </div>
                                <div class="border col-md-4">
                                    <h3 class="text-center font-weight-bolder">
                                        <a href="{{url('/admin/users/')}}" class="text-dark">
                                            {{__('frontEnd.blocked_users')}} [{{$blocked_users}}]
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            <hr>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
