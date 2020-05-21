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
                                <strong>{{__('frontEnd.all_partners')}}</strong>
                            </div>

                            <div class="panel-body text-center">
                                <ul dir="{{$dir}}" class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">
                                            {{__('frontEnd.pending_partners')}} [{{$pending->count()}}]
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">
                                            {{__('frontEnd.active_partners')}} [{{$active->count()}}]
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="blocked-tab" data-toggle="tab" href="#blocked" role="tab" aria-controls="blocked" aria-selected="false">
                                            {{__('frontEnd.blocked_partners')}} [{{$blocked->count()}}]
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="blocked-tab" data-toggle="tab" href="#blocked" role="tab" aria-controls="blocked" aria-selected="false">
                                            {{__('frontEnd.rejected_partners')}} [{{$rejected->count()}}]
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                        <div dir="{{$dir}}" class="py-3 row">
                                            @foreach($pending as $user)
                                                <div class="col-4 border">
                                                    <img src="{{asset('/img/partners.png')}}" class="img-fluid">
                                                    <a class="d-block" href="#"> {{$user->name}}</a>
                                                    <span>
                                                        <i class="far fa-calendar-check font-1-2"></i>
                                                        {{$user->created_at}}
                                                    </span>
                                                    <div class="">
                                                        <a class="btn my-2 btn-success " href="{{route('admin.accept.partner',['partner_id'=>$user->id])}}">
                                                            <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.accept_partner')}}
                                                        </a>
                                                        <a class="btn my-2 btn-danger " href="{{route('admin.reject.partner',['partner_id'=>$user->id])}}">
                                                            <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.reject_partner')}}
                                                        </a>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="active-tab"`>
                                        <div dir="{{$dir}}" class="py-3 row">
                                            @foreach($active as $user)
                                                <div class="col-4 border">
                                                    <img src="{{asset('/img/partners.png')}}" class="img-fluid">
                                                    <a class="d-block" href="#"> {{$user->name}}</a>
                                                    <span>
                                                        <i class="far fa-calendar-check font-1-2"></i>
                                                        {{$user->created_at}}
                                                    </span>
                                                    <div class="">
                                                        <a class="btn my-2 btn-danger " href="{{route('admin.active.partner',['partner_id'=>$user->id])}}">
                                                            <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.block_partner')}}
                                                        </a>

                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="blocked" role="tabpanel" aria-labelledby="blocked-tab">
                                        <div dir="{{$dir}}" class="py-3 row">
                                            @foreach($blocked as $user)
                                                <div class="col-4 border">
                                                    <img src="{{asset('/img/partners.png')}}" class="img-fluid">
                                                    <a class="d-block" href="#"> {{$user->name}}</a>
                                                    <span>
                                                        <i class="far fa-calendar-check font-1-2"></i>
                                                        {{$user->created_at}}
                                                    </span>
                                                    <div class="">
                                            <a class="btn my-2 btn-success " href="{{route('admin.active.partner',['partner_id'=>$user->id])}}">
                                                <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.active_partner')}}
                                            </a>
                                        </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                        <div dir="{{$dir}}" class="py-3 row">
                                            @foreach($rejected as $user)
                                                <div class="col-4 border">
                                                    <img src="{{asset('/img/partners.png')}}" class="img-fluid">
                                                    <a class="d-block" href="#"> {{$user->name}}</a>
                                                    <span>
                                                        <i class="far fa-calendar-check font-1-2"></i>
                                                        {{$user->created_at}}

                                                    </span>
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
