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
            <div class="col-6 posts-container"  id="posts-container">
                <h3 class="text-center">{{__('frontEnd.my_joined_trips')}} [{{$allCount}}]</h3>
            @foreach($myTrips as $trip)
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

                                @if($trip->rated==false)
                                    @php
                                        $rated='rate-it';
                                    @endphp
                                @else
                                    @php
                                        $rated='';
                                    @endphp
                                @endif
                                <div id="rate-trip-id_{{$trip->id}}" class="{{$text}} main-rate {{$rated}}">
                                    <div {{$animate='pop'}}></div>
                                    @for($i=1;$i<=$trip->rate;$i++)
                                        <i trip-id="{{$trip->id}}" data-micron="{{$animate=''}}" class="fa fa-star gold-color font-1-6" rate-value={{$i}}></i>
                                    @endfor
                                    @for($y=1;$y<=(5 - $trip->rate);$y++)
                                        <i trip-id="{{$trip->id}}" data-micron="{{$animate}}" class="far fa-star gold-color font-1-6" rate-value="{{$y+$trip->rate}}"></i>
                                    @endfor

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="col-3 panner-right ">
                <div class="panner bg-light box-shadow" >
                    <h3 class="text-uppercase text-center">{{__('frontEnd.special_trips')}}</h3>
                    <div class="special-posts" style="overflow: auto;max-height: 475px">
                        @foreach($specialTrips as $trip)
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
            <div class="ajax-load text-center" style="display:none;position: fixed; left: 0;right: 0;bottom: 30%;z-index: 1000">
                <p class="d-inline-block text-center rounded-circle bg-glass"><img src="{{asset('img/loading.gif')}}" height="100" width="100" class="d-block m-auto"></p>
            </div>

    </div>

@endsection


@section('ajaxCode')
    <script>
        $(document).ready(function() {
            $('.rate-it>i').click(function(e){
                var trip_id = $(this).attr('trip-id');
                var rate    = $(this).attr('rate-value');
                var token   = '{{csrf_token()}}';
                var newHTML ='';
                $(this).parent('.main-rate').hasClass('rate-it')
                {
                    $.ajax({
                        type: "GET",
                                        url: "{{url('/tripDetails/rate')}}/"+trip_id+"/"+rate,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                data.newRate;
                                $('#rate-trip-id_' + trip_id).removeClass('rate-it');

                                $('#rate-trip-id_' + trip_id).children('i').removeClass('fa').addClass('far');
                                $('#rate-trip-id_' + trip_id + ' i:nth-child(' + 3 + ')').attr('data-micron', '').siblings().attr('data-micron', '');
                                /*if(!data.already){
                                    $('<audio id="chatAudio"> ' +
                                        '<source src="{{asset('sounds/star1.mp3')}}" type="audio/mpeg"> ' +
                                '</audio>').appendTo('body');
                            // play sound
                            $('#chatAudio')[0].play();
                        }*/
                                for (var i = 1; i <= (data.newRate + 1); i++) {
                                    $('#rate-trip-id_' + trip_id + ' i:nth-child(' + i + ')').addClass('fa');
                                }


                            } else {

                            }
                        }
                    });
                }

            });

            //lod more posts
            var page = 1;
            $(function() {
                /* this is only for demonstration purpose */
                scroll_enabled = true;
                function loadMoreData(page){
                    $('.ajax-load').show();

                    $.ajax({
                        type: "GET",
                                        url: "{{url('/tripDetails/rate')}}/"+trip_id+"/"+rate,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                data.newRate;
                                $('#rate-trip-id_' + trip_id).removeClass('rate-it');

                                $('#rate-trip-id_' + trip_id).children('i').removeClass('fa').addClass('far');
                                $('#rate-trip-id_' + trip_id + ' i:nth-child(' + 3 + ')').attr('data-micron', '').siblings().attr('data-micron', '');
                                /*if(!data.already){
                                    $('<audio id="chatAudio"> ' +
                                        '<source src="{{asset('sounds/star1.mp3')}}" type="audio/mpeg"> ' +
                                '</audio>').appendTo('body');
                            // play sound
                            $('#chatAudio')[0].play();
                        }*/
                                for (var i = 1; i <= (data.newRate + 1); i++) {
                                    $('#rate-trip-id_' + trip_id + ' i:nth-child(' + i + ')').addClass('fa');
                                }


                            } else {

                            }
                        }
                    });
                }

                $(window).bind('scroll', function() {
                    if (scroll_enabled) {

                        /* if 90% scrolled */
                        if($(window).scrollTop() >= ($('#posts-container').offset().top + $('#posts-container').outerHeight()-window.innerHeight)*0.9) {

                            /* load ajax content */
                            scroll_enabled = false;
                            page++;
                            loadMoreData(page);

                        }
                    }

                });

            });
        });
    </script>
@endsection
