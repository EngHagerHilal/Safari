@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@extends('company.layout.auth')
@section('content')
    <div class="padding-top-0 first-main-container" style="min-height: 600px;">
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
        <div class="row">
            <div class="col-8 post-details-container">
                <div class="post-details bg-light box-shadow">
                    <div class="{{$text}} post-header">
                        <div class="text-center creater-logo d-inline-block">
                            <i class="far fa-compass d-block m-auto main-text-green fa-3x"></i>
                        </div>
                        <div class="creater-text d-inline-block">
                            <a class="d-block" href="#">
                                <strong class="text-uppercase text-dark">{{$trip->comapny}}</strong>
                            </a>
                            <span class="d-block">{{$trip->created_at}}</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <div class="image-container full-images">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" {{$active='active'}}>
                                    @if(count($trip->img)>0)

                                        @foreach($trip->img as $img)
                                            <div class="carousel-item {{$active}}" {{$active=''}}>
                                                <img class="d-block w-100" height="640" src="{{asset($img->img_url)}}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item {{$active='active'}}" {{$active=''}}>
                                            <img class="d-block w-100" height="640" src="{{asset('img/no-img.png')}}">
                                        </div>
                                    @endif

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="more-details">
                            <a href="#"><h3 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3></a>
                            <p class="text-dark">{{$trip->description}}</p>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-4 panner-right post-full-details">
                <div class="panner bg-light box-shadow">
                    <h3 class="text-uppercase text-center">{{$trip->title}}</h3>
                    <div class="{{$text}} full-details">
                        <p>
                            <i class="fas fa-location-arrow font-1-2 main-text-green"></i>
                            {{__('frontEnd.from')}}
                            <strong class="text-uppercase">{{$trip->trip_from}}</strong>
                            {{__('frontEnd.to')}}
                            <strong class="text-uppercase">{{$trip->trip_to}}</strong>
                        </p>
                        <p>
                            <i class="fas fa-user font-1-2 main-text-green"></i>
                            {{__('frontEnd.age_from')}}
                            <strong class="text-uppercase">12</strong>
                            {{__('frontEnd.to')}} <strong class="text-uppercase">45</strong>
                            {{__('frontEnd.years')}}
                        </p>
                        <p>
                            <i class="fas fa-users font-1-2 main-text-green"></i>
                            {{__('frontEnd.available_places')}} : <strong class="text-uppercase">45</strong> {{__('frontEnd.persons')}}
                        </p>
                        <p>
                            <i class="fas fa-money-bill-wave font-1-2 main-text-green"></i>
                            {{__('frontEnd.price')}} <strong class="text-uppercase">{{$trip->price}}</strong> $
                        </p>
                        <p>
                            <i class="fas fa-calendar-alt font-1-2 main-text-green"></i>
                            {{__('frontEnd.duration_from')}} <strong class="text-uppercase">{{$trip->start_at}}</strong> {{__('frontEnd.to')}} <strong>{{$trip->end_at}}</strong>
                        </p>
                        <p>
                            <i class="fas fa-user-clock font-1-2 main-text-green"></i>
                            {{__('frontEnd.new_join_req')}} : <strong>{{count($newJoinRequest)}}</strong></p>
                        <p>
                            <i class="fas fa-user-check font-1-2 main-text-green"></i>
                            {{__('frontEnd.resolved_join_req')}} : <strong>{{count($resolvedJoinRequest)}}</strong>
                        </p>
                        <p>
                            <i class="fas fa-user-times font-1-2 main-text-green"></i>
                            {{__('frontEnd.rejected_join_req')}} : <strong>{{count($rejectedJoinRequest)}} </strong>
                        </p>
                        <p>
                            <i class="fas fa-users font-1-2 main-text-green"></i>
                            {{__('frontEnd.confirmed_join_req')}} : <strong>{{count($confirmedTraveler)}} </strong>
                        </p>
                    </div>
                    <div class="aply-now">
                        @switch($trip->status)
                            @case('active')
                            <a href="{{route('company.trips.control',['action'=>'disabled','trip_id'=>$trip->id])}}" class="btn btn-danger input-group aply-button">
                                <i class="fas fa-eye-slash font-1-2"></i> {{__('frontEnd.mark_disabled')}}
                            </a>
                            <a href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}" class="btn btn-primary input-group aply-button">
                                <i class="fas fa-check-circle font-1-2"></i> {{__('frontEnd.mark_completed')}}
                            </a>
                            @break
                            @case('disabled')
                            <a href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}" class="btn btn-success input-group aply-button">
                                <i class="fas fa-eye"></i> {{__('frontEnd.mark_active')}}
                            </a>
                            <a href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}" class="btn btn-primary input-group aply-button">
                                <i class="fas fa-check-circle font-1-2"></i> {{__('frontEnd.mark_completed')}}
                            </a>
                            @break
                            @case('completed')
                            <a href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}" class="btn btn-success input-group aply-button">
                                <i class="fas fa-eye font-1-2"></i> {{__('frontEnd.mark_available')}}
                            </a>

                            @break

                            @default


                        @endswitch

                    </div>
                </div>

            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">

                <li class="nav-item">
                    <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">
                        <i class="fas fa-user-clock font-1-2 main-text-green"></i>
                        {{__('frontEnd.new_join_req')}} : <strong>{{count($newJoinRequest)}}</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="resolved-tab" data-toggle="tab" href="#resolved" role="tab" aria-controls="resolved" aria-selected="false">
                        <i class="fas fa-user-check font-1-2 main-text-green"></i>
                        {{__('frontEnd.resolved_join_req')}} : <strong>{{count($resolvedJoinRequest)}}</strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">
                        <i class="fas fa-user-times font-1-2 main-text-green"></i>
                        {{__('frontEnd.rejected_join_req')}} : <strong>{{count($rejectedJoinRequest)}} </strong>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="confirmedTraveler-tab" data-toggle="tab" href="#confirmedTraveler" role="tab" aria-controls="confirmedTraveler" aria-selected="false">
                        <i class="fas fa-users font-1-2 main-text-green"></i>
                        {{__('frontEnd.confirmed_join_req')}} : <strong>{{count($confirmedTraveler)}} </strong>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    <div dir="{{$dir}}" class="row">
                        @foreach($newJoinRequest as $user)
                            <div class="{{$text}} col-md-4 border">
                                <a href="#"><h4 class="text-center" >{{$user->name}}</h4></a>
                                <p class="font-weight-bolder">{{__('frontEnd.email')}} : {{$user->email}}</p>
                                <p>{{__('frontEnd.status')}} : <strong>{{$user->status}}</strong></p>
                                <p>{{__('frontEnd.req_date')}} : {{$user->created_at}}</p>
                                @if(in_array($user->status,['pending','resolved']))
                                    <a class="btn btn-success " href="{{route('company.trip.control.joiner',['action'=>'resolved','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.resolve_request')}}
                                    </a>
                                    <a class="btn btn-danger " href="{{route('company.trip.control.joiner',['action'=>'rejected','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.reject_request')}}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade " id="resolved" role="tabpanel" aria-labelledby="resolved-tab">
                    <div class="row">
                        @foreach($resolvedJoinRequest as $user)
                            <div class="{{$text}} col-md-4 border">
                                <a href="#"><h4 class="text-center" >{{$user->name}}</h4></a>
                                <p class="font-weight-bolder">{{__('frontEnd.email')}} : {{$user->email}}</p>
                                <p>{{__('frontEnd.status')}} : <strong>{{$user->status}}</strong></p>
                                <p>{{__('frontEnd.req_date')}} : {{$user->created_at}}</p>
                                @if(in_array($user->status,['pending','resolved']))
                                    <a class="btn btn-success " href="{{route('company.trip.control.joiner',['action'=>'resolved','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.resolve_request')}}
                                    </a>
                                    <a class="btn btn-danger " href="{{route('company.trip.control.joiner',['action'=>'rejected','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.reject_request')}}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade " id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                    <div class="row">
                        @foreach($rejectedJoinRequest as $user)
                            <div class="{{$text}} col-md-4 border">
                                <a href="#"><h4 class="text-center" >{{$user->name}}</h4></a>
                                <p class="font-weight-bolder">{{__('frontEnd.email')}} : {{$user->email}}</p>
                                <p>{{__('frontEnd.status')}} : <strong>{{$user->status}}</strong></p>
                                <p>{{__('frontEnd.req_date')}} : {{$user->created_at}}</p>
                                @if(in_array($user->status,['pending','resolved']))
                                    <a class="btn btn-success " href="{{route('company.trip.control.joiner',['action'=>'resolved','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.resolve_request')}}
                                    </a>
                                    <a class="btn btn-danger " href="{{route('company.trip.control.joiner',['action'=>'rejected','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.reject_request')}}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade " id="confirmedTraveler" role="tabpanel" aria-labelledby="confirmedTraveler-tab">
                    <div class="row">
                        @foreach($confirmedTraveler as $user)
                            <div class="{{$text}} col-md-4 border">
                                <a href="#"><h4 class="text-center" >{{$user->name}}</h4></a>
                                <p class="font-weight-bolder">{{__('frontEnd.email')}} : {{$user->email}}</p>
                                <p>{{__('frontEnd.status')}} : <strong>{{$user->status}}</strong></p>
                                <p>{{__('frontEnd.req_date')}} : {{$user->created_at}}</p>
                                @if(in_array($user->status,['pending','resolved']))
                                    <a class="btn btn-success " href="{{route('company.trip.control.joiner',['action'=>'resolved','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-check-square font-1-6"></i> {{__('frontEnd.resolve_request')}}
                                    </a>
                                    <a class="btn btn-danger " href="{{route('company.trip.control.joiner',['action'=>'rejected','trip_id'=>$trip->id,'user_id'=>$user->id])}}">
                                        <i class="fas fa-window-close font-1-6"></i> {{__('frontEnd.reject_request')}}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

    </div>
@endsection

