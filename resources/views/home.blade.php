@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@extends('layouts.app')
@section('homePageSlider')
    <div dir="ltr" class="mains-lider position-relative">
        <h1 class="text-center text-uppercase safari-text">safari charge your live!</h1>
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-1.jpg" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-6.webp" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-3.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-4.jpg" alt="Third slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" height="640" src="{{asset('/')}}img/slide-5.jpg" alt="Third slide">
                </div>
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
@endsection
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
                <div class="panner bg-light box-shadow">
                    <h3 class="text-uppercase text-center">{{__('frontEnd.special_trips')}}</h3>
                    <div class="special-posts">

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
