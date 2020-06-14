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
            <h3 class="text-center py-3">{{__('frontEnd.my_joined_trips')}} [{{$allCount}}]</h3>

            <div class="row">
            <div class="col-lg-3 d-none d-lg-block panner-left ">
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
            <div class="col-lg-6 col-12 posts-container"  id="posts-container">
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
                                <span class="d-block">{{date('d/m/Y',strtotime($trip->created_at))}}</span>

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
            <div class="col-lg-3 d-none d-lg-block panner-right ">
                <div class="panner bg-light box-shadow" >
                    <h3 class="text-uppercase text-center">{{__('frontEnd.ads')}}</h3>
                    <div class="special-posts" style="overflow: auto;max-height: 475px">
                        @foreach($ads as $ads_item)
                            <div class="post-item bg-light box-shadow">
                                <div class="post-body">
                                    <div class="image-container">
                                        <img src="{{asset($ads_item->img)}}" class="img-fluid" style="width: 100%!important;" height="300">
                                    </div>
                                    <div class="px-2 more-details {{$text}}">
                                        <h3 class="font-weight-bold text-dark text-uppercase">{{$ads_item->title}}</h3>
                                        <div class="card bg-transparent {{$text}}">
                                            <ul class="list-group list-group-flush bg-transparent p-0">
                                                <li class="list-group-item bg-transparent"><i class="fab fa-discourse font-1-2 main-text-green"></i>
                                                    {{$ads_item->desc}}</li>
                                                <li class="list-group-item bg-transparent"><i class="fas fa-sitemap font-1-2 main-text-green"></i> {{$ads_item->company_name}}</li>
                                                @if($ads_item->link)<li class="list-group-item bg-transparent"><a href="{{$ads_item->link}}"><i class="fas fa-globe font-1-2 main-text-green"></i>{{$ads_item->link}}</a></li>@endif
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>

            </div>
        </div>
            <div class="ajax-load text-center" >
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
                        url: "{{ route('myJoinedTrips') }}?page="+page,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                if(data.posts.length >0){
                                    $("#posts-container").append(data.posts);
                                    console.log(data.pageNumber);
                                    $('.ajax-load').hide();
                                    scroll_enabled = true;
                                    return;
                                }
                                //alert('no more');

                                $('.ajax-load').hide();

                            } else {
                                alert('server not responding...');
                                $('.ajax-load').hide();

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
