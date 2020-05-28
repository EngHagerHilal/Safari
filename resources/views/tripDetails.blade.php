@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@extends('layouts.app')
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
                                <strong class="text-uppercase text-dark">{{$trip->comapnyName}}</strong>
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

                        </div>
                    </div>

                </div>

            </div>
            <div class="col-4 panner-right post-full-details">
                <div class="panner bg-light box-shadow">
                    <h3 style="padding-top: 70px" class="text-uppercase text-center font-weight-bolder">{{$trip->title}}</h3>
                    <div class="{{$text}} full-details">
                        <p class="text-dark font-weight-bold">{{$trip->description}}</p>

                        <p>
                            <i class="fas fa-location-arrow font-1-2 main-text-green"></i>
                            {{__('frontEnd.from')}}
                            <strong class="text-uppercase">{{$trip->trip_from}}</strong>
                            {{__('frontEnd.to')}}
                            <strong class="text-uppercase">{{$trip->trip_to}}</strong>
                        </p>

                        <p>
                            <i class="fas fa-money-bill-wave font-1-2 main-text-green"></i>
                            {{__('frontEnd.price')}} <strong class="text-uppercase">{{$trip->price}}</strong> $
                        </p>
                        <p>
                            <i class="fas fa-calendar-alt font-1-2 main-text-green"></i>
                            {{__('frontEnd.duration_from')}} <strong class="text-uppercase">{{$trip->start_at}}</strong> {{__('frontEnd.to')}} <strong>{{$trip->end_at}}</strong>
                        </p>
                        @if($trip->joined ==true)

                        <p>
                            <i class="fas fa-suitcase-rolling font-1-2 main-text-green"></i> {{__('frontEnd.you_are_joined')}}
                        </p>
                        @endif

                    </div>
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
                    <div class="aply-now">
                        @if($trip->joined ==true)
                        <a href="{{route('users.cancleTrip',['trip_id'=>$trip->id])}}" class="btn btn-danger input-group aply-button"><i class="fas fa-window-close"></i>
                            {{__('frontEnd.cancel_trip')}}
                        </a>
                        @else
                         <a href="{{route('users.joinTrip',['trip_id'=>$trip->id])}}" class="btn btn-success input-group aply-button"><i class="fas fa-user-plus"></i>
                             {{__('frontEnd.join_trip')}}</a>
                        @endif
                    </div>
                </div>

            </div>
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
                        url: "{{route('users.RateTrip')}}",
                        dataType: "json",
                        data: {'trip_id': trip_id, 'rate': rate, '_token': token},
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
        });
    </script>
@endsection

