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
                            <div class="panel-heading text-center">
                                <strong>{{__('frontEnd.all_users')}}</strong>
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
                                    <div class="col-4 border">
                                        <img src="{{asset('/img/user.png')}}" class="img-fluid">
                                        <a class="d-block" href="#"> {{$user->name}}</a>
                                        <span>
                                        <i class="far fa-calendar-check font-1-2"></i>
                                        {{$user->created_at}}
                                            <div class="">
                                                @if($user->status=='active')
                                                    <a class="btn btn-danger " href="{{route('users.control',['control'=>'blocked','user_id'=>$user->id])}}">
                                                       <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.block_user')}}
                                                    </a>
                                                @else
                                                    <a class="btn btn-success " href="{{route('users.control',['control'=>'active','user_id'=>$user->id])}}">
                                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.active_user')}}
                                                    </a>
                                                @endif
                                            </div>
                                        <span/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="blocked" role="tabpanel" aria-labelledby="blocked-tab">
                            <div dir="{{$dir}}" class="py-3 row">
                                @foreach($blocked as $user)
                                    <div class="col-4 border">
                                        <img src="{{asset('/img/user.png')}}" class="img-fluid">
                                        <a class="d-block" href="#"> {{$user->name}}</a>
                                        <span>
                                        <i class="far fa-calendar-check font-1-2"></i>
                                        {{$user->created_at}}
                                            <div class="">
                                                @if($user->status=='active')
                                                    <a class="btn btn-danger " href="{{route('users.control',['control'=>'blocked','user_id'=>$user->id])}}">
                                                       <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.block_user')}}
                                                    </a>
                                                @else
                                                    <a class="btn btn-success " href="{{route('users.control',['control'=>'active','user_id'=>$user->id])}}">
                                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.active_user')}}
                                                    </a>
                                                @endif
                                            </div>
                                        <span/>
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
