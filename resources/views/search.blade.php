@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@extends('layouts.app')
@section('content')
    <div class="first-main-container" style="min-height: 600px;">
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
            <h2 class="text-center py-2">{{__('frontEnd.search_for_trip')}}</h2>
            <h4 class="text-center py-2">[{{$available->count()}}] {{__('frontEnd.trip_founded')}}</h4>
        <div class="row">
            <div class="col-3 panner-left ">
                <div class="panner bg-light box-shadow">
                    <h3 class="text-uppercase text-center">{{__('frontEnd.search')}}</h3>
                    <form method="get" action="{{route('user.trips.search')}}">
                        <div class="form-control  filter-input">
                            <input type="text" class="input-group" id="search_for" name="text" placeholder="{{__('frontEnd.search_for')}}">
                        </div>
                        <div class="form-control  filter-input">
                            <input type="text" class="input-group" id="city" name="city" placeholder="{{__('frontEnd.city')}}">
                        </div>
                        <div class="form-control filter-input">
                            <label class="d-block {{$text.' '.$margin}}" for="filter">{{__('frontEnd.filter_by')}} </label>

                            <select id="category" class="input-group" name="category" value="{{old('category')}}" >
                                <option selected disabled value="">{{__('frontEnd.category')}}</option>
                                <option value="air flights">{{__('frontEnd.air_flights')}}</option>
                                <option value="land trips">{{__('frontEnd.land_trips')}}</option>
                                <option value="sea trips">{{__('frontEnd.sea_trips')}}</option>
                            </select>
                        </div>

                        <div class="form-control filter-input">
                            <label class="d-block {{$text.' '.$margin}}" for="date">{{__('frontEnd.departure_date')}} </label>
                            <input type="date" class="input-group" name="date" id="date" placeholder="{{__('frontEnd.date')}}">
                        </div>

                        <input class="btn main-border-green main-text-green " type="submit" value="{{__('frontEnd.search')}}">
                    </form>
                </div>
            </div>
            <div class="col-6 posts-container">
                @foreach($available as $trip)
                    <div class="post-item bg-light box-shadow">
                        <div class="post-header {{$text}}">
                            <div class="text-center creater-logo d-inline-block">
                                <i class="far fa-compass d-block m-auto main-text-green fa-3x"></i>
                            </div>
                            <div class="creater-text d-inline-block">
                                <a class="d-block" href="#">
                                    <strong class="text-uppercase text-dark">{{$trip->companyName}}</strong>
                                </a>
                                <span class="d-block">{{$trip->created_at}}</span>

                            </div>
                        </div>
                        <div class="post-body">
                            <div class="image-container">
                                <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
                            </div>
                            <div class="px-2 more-details {{$text}}">
                                <a href="{{route('users.tripDetails',['trip_id'=>$trip->id])}}">
                                    <h3 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>
                                </a>
                                <p class="text-dark">{{$trip->description}}</p>
                                <p >
                                    {{__('frontEnd.rate')}}  : <strong>{{$trip->rate}}</strong>
                                </p>
                                <form method="post" action="{{route('users.RateTrip')}}">
                                    @csrf
                                    <input type="number" min="1" max="5" value="5" name="rate">
                                    <input type="hidden" value="{{$trip->id}}" name="trip_id">
                                    <input type="submit" value="rate">
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="col-3 panner-right ">
                <div class="panner bg-light box-shadow" >
                    <h3 class="text-uppercase text-center">{{__('frontEnd.special_trips')}}</h3>
                    <div class="special-posts" style="overflow: auto;max-height: 475px">
                        @foreach($myTrips as $trip)
                            <div class="post-item bg-light box-shadow">
                                <div class="post-body">
                                    <div class="image-container">
                                        <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
                                    </div>
                                    <div class="px-2 more-details {{$text}}">
                                        <a href="{{route('users.tripDetails',['trip_id'=>$trip->id])}}">
                                            <h3 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>
                                        </a>
                                        <p class="text-dark">
                                            <i class="fas fa-calendar-alt font-1-2 main-text-green"></i>
                                            {{__('frontEnd.travel_day')}} : {{$trip->start_at}}
                                        </p>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                    @guest
                    @else
                    <div class=" position-relative">
                        <a href="{{route('myJoinedTrips')}}" style="bottom: 0;width: 80%; left: 0;right: 0" class="btn btn-success d-block m-auto position-absolute">
                            <i class="fas fa-suitcase-rolling"></i> {{__('frontEnd.my_joined_trips')}}
                        </a>
                    </div>
                    @endguest
                </div>

            </div>
        </div>
    </div>

@endsection
