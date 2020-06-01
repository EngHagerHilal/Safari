@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
    $offset_1= str_replace('_', '-', app()->getLocale()) =='ar' ? 'margin-right:8.3%' : 'margin-left:8.3%';
@endphp
@extends('company.layout.auth')

@section('content')
<div class="main-bg-safary">
    <div class="container bg-glass">
        <div dir="ltr" class="row">
            <div class="col-md-10 offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="font-weight-bolder text-center py-5">
                            <strong>
                                {{Auth::guard('company')->user()->name}}</strong> {{__('frontEnd.dashboard')}}
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
                            {{__('frontEnd.my_trips')}}
                        </h3>
                        <ul dir="{{$dir}}" class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="text-dark font-weight-bolder nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">
                                    {{__('frontEnd.active_trips')}} [{{$active->count()}}]
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="text-dark font-weight-bolder nav-link" id="disabled-tab" data-toggle="tab" href="#disabled" role="tab" aria-controls="disabled" aria-selected="false">
                                    {{__('frontEnd.disabled_trips')}} [{{$disabled->count()}}]
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="text-dark font-weight-bolder nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">
                                    {{__('frontEnd.completed_trips')}} [{{$completed->count()}}]
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                                <div dir="{{$dir}}" class="row py-3">
                                @foreach($active as $trip)
                                    <div style="{{$offset_1}}" class="col-md-3 post-item bg-light box-shadow">
                                            <div class="post-body">
                                                <div class="image-container">
                                                    <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
                                                </div>
                                                <div class="{{$text}} px-2 more-details">
                                                    <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}">
                                                        <h4 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h4>
                                                    </a>
                                                    <p>{{__('frontEnd.status')}}: <strong>{{$trip->status}}</strong></p>
                                                    <p class="font-weight-bolder">
                                                        <i class="fas fa-user-check font-1-2 main-text-green"></i>
                                                        {{__('frontEnd.joiners')}} [{{$trip->joinersNumber}}]
                                                    </p>
                                                     </div>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                            </div>
                            <div class="tab-pane fade " id="disabled" role="tabpanel" aria-labelledby="disabled-tab">
                                <div dir="{{$dir}}" class="row py-3">
                                    @foreach($disabled as $trip)
                                    <div style="{{$offset_1}}" class="col-md-3 post-item bg-light box-shadow">
                                        <div class="post-body">
                                            <div class="image-container">
                                                <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
                                            </div>
                                            <div class="{{$text}} px-2 more-details">
                                                <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}">
                                                    <h4 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h4>
                                                </a>
                                                <p>{{__('frontEnd.status')}}: <strong>{{$trip->status}}</strong></p>
                                                <p class="font-weight-bolder">
                                                    <i class="fas fa-user-check font-1-2 main-text-green"></i>
                                                    {{__('frontEnd.joiners')}} [{{$trip->joinersNumber}}]
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="tab-pane fade " id="completed" role="tabpanel" aria-labelledby="completed-tab">
                                <div dir="{{$dir}}" class="row">
                                    @foreach($completed as $trip)

                                        <div style="{{$offset_1}}" class="col-md-3 post-item bg-light box-shadow">
                                            <div class="post-body">
                                                <div class="image-container">
                                                    <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
                                                </div>
                                                <div class="{{$text}} px-2 more-details">
                                                    <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}">
                                                        <h4 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h4>
                                                    </a>
                                                    <p>{{__('frontEnd.status')}}: <strong>{{$trip->status}}</strong></p>
                                                    <p class="font-weight-bolder">
                                                        <i class="fas fa-user-check font-1-2 main-text-green"></i>
                                                        {{__('frontEnd.joiners')}} [{{$trip->joinersNumber}}]
                                                    </p>
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
</div>

@endsection
