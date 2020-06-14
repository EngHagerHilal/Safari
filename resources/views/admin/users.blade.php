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
                <div class="col-md-10 offset-md-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-heading text-center">
                                <h3><strong>{{__('frontEnd.all_users')}}</strong></h3>
                            </div>

                <div class="panel-body text-center">
                    <ul dir="{{$dir}}" class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">
                                {{__('frontEnd.active_users')}} [{{$active->count()}}]
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="blocked-tab" data-toggle="tab" href="#blocked" role="tab" aria-controls="blocked" aria-selected="false">
                                {{__('frontEnd.blocked_users')}} [{{$blocked->count()}}]
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div dir="{{$dir}}" class="py-3 row">
                                @foreach($active as $user)
                                    <div class="col-md-4 col-sm-6 col-12 py-3">
                                        <div style="border-radius: 10px" class="bg-white border">
                                            <img style="height: 130px!important;" src="{{asset('/img/user.png')}}" class="img-fluid py-2">
                                            <a class="d-block" href="#"><h4> {{$user->name}} </h4></a>
                                            <div class="card bg-transparent {{$text}}">
                                                <ul class="list-group list-group-flush bg-transparent">
                                                    <li class="list-group-item bg-transparent"><i class="fas fa-envelope font-1-2 main-text-green"></i>
                                                        {{$user->email}}</li>
                                                    <li class="list-group-item bg-transparent"><i class="fas fa-phone font-1-2 main-text-green"></i> {{$user->phone}}</li>
                                                    <li class="list-group-item bg-transparent"><i class="far fa-calendar-check font-1-2 main-text-green"></i>
                                                        {{date('d-m-Y',strtotime($user->created_at))}}</li>
                                                </ul>
                                            </div>
                                            <div class="">
                                                <a class="btn my-2 btn-danger " href="{{route('users.control',['control'=>'blocked','user_id'=>$user->id])}}">
                                                    <i class="fas fa-user-slash font-1-6"></i> {{__('frontEnd.block_user')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="blocked" role="tabpanel" aria-labelledby="blocked-tab">
                            <div dir="{{$dir}}" class="py-3 row">
                                @foreach($blocked as $user)
                                    <div class="col-md-4 col-sm-6 col-12 py-3">
                                        <div style="border-radius: 10px" class="bg-white border">
                                            <img style="height: 130px!important;" src="{{asset('/img/user.png')}}" class="img-fluid py-2">
                                            <a class="d-block" href="#"><h4> {{$user->name}} </h4></a>
                                            <div class="card bg-transparent {{$text}}">
                                                <ul class="list-group list-group-flush bg-transparent">
                                                    <li class="list-group-item bg-transparent"><i class="fas fa-envelope font-1-2 main-text-green"></i>
                                                        {{$user->email}}</li>
                                                    <li class="list-group-item bg-transparent"><i class="fas fa-phone font-1-2 main-text-green"></i> {{$user->phone}}</li>
                                                    <li class="list-group-item bg-transparent"><i class="far fa-calendar-check font-1-2 main-text-green"></i>
                                                        {{date('d-m-Y',strtotime($user->created_at))}}</li>
                                                </ul>
                                            </div>
                                            <div class="">
                                                <a class="btn my-2 btn-success " href="{{route('users.control',['control'=>'active','user_id'=>$user->id])}}">
                                                    <i class="fas fa-user-check font-1-6"></i> {{__('frontEnd.active_user')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
