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
            <h2 class="text-center py-2">{{__('frontEnd.search')}}</h2>
        <div class="row">
            <div class="col panner-left">
                <div class="panner bg-light box-shadow">
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
                        type: "POST",
                        url: "{{url('/tripDetails/rate')}}/"+trip_id+"/"+rate,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                data.newRate;
                                $('#rate-trip-id_' + trip_id).removeClass('rate-it');

                                $('#rate-trip-id_' + trip_id ).children('i').removeClass('fa').addClass('far');
                                $('#rate-trip-id_' + trip_id + ' i:nth-child(' + 3 + ')').attr('data-micron','').siblings().attr('data-micron','');


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
                        url: "{!! url()->full() !!}&page="+page,
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
