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
            <div class="col-lg-8 col-12 post-details-container py-2">
                <div class="post-details bg-light box-shadow">
                    <div class="{{$text}} post-header">
                        <div class="text-center creater-logo d-inline-block">
                            <i class="far fa-compass d-block m-auto main-text-green fa-3x"></i>
                        </div>
                        <div class="creater-text d-inline-block">
                            <a class="d-block" href="#">
                                <strong class="text-uppercase text-dark">{{$trip->comapnyName}}</strong>
                            </a>
                            <span class="d-block">{{date('d/m/Y',strtotime($trip->created_at))}}</span>

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
                            <h3 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>

                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-4 col-12 panner-right post-full-details py-2">
                <div style="max-height: 900px" class="panner bg-light box-shadow">
                    <form method="POST" action="{{route('users.joinTrip')}}">
                        @csrf
                        <input type="hidden" name="trip_id" value="{{$trip->id}}">
                        <h3 style="padding-top: 20px" class="text-center d-none d-md-block font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>

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
                                {{__('frontEnd.price')}} <strong class="text-uppercase" id="tripPrice">{{$trip->price}}</strong> $
                            </p>
                            <p>
                                <i class="fas fa-calendar-alt font-1-2 main-text-green"></i>
                                {{__('frontEnd.duration_from')}} <strong class="text-uppercase">{{$trip->start_at}}</strong> {{__('frontEnd.to')}} <strong>{{$trip->end_at}}</strong>
                            </p>
                            @if($trip->joined ==true)

                            <p>
                                <i class="fas fa-suitcase-rolling font-1-2 main-text-green"></i> {{__('frontEnd.you_are_joined')}}
                            </p>
                            <p>
                                <i class="fas fa-ad font-1-2 main-text-green"></i>
                                {{__('frontEnd.join_code')}} : {{$trip->joined->joinCode}}
                            </p>
                            <div class="trip_code">
                                <img width="130" height="130" src="{{asset($trip->joined->QR_code) }}" class="d-block m-auto img-fluid">
                            </div>
                            @else
                                <p>
                                    <i aria-hidden="true" class="fas fa-money-bill-alt font-1-2 main-text-green"></i>
                                    <input type="text" name="code" placeholder="{{__('frontEnd.enter_voucher')}}" id="voucherCode">
                                <p class="alert alert-danger text-danger" style="display: none" id="codeInvalid"><i class="fas fa-ban text-danger font-1-6"></i>  {{__('frontEnd.code_invalid')}}</p>
                                <p class="alert alert-success " style="display: none" id="codeValid"><i class="fas fa-check-circle main-text-green font-1-6"></i> {{__('frontEnd.code_valid')}}</p>
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
                        <div rate="{{$trip->rate}}" id="rate-trip-id_{{$trip->id}}" class="{{$text}} main-rate {{$rated}}">
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
                             <button type="submit" id="join-trip" class="btn btn-success input-group aply-button"><i class="fas fa-user-plus"></i>
                                 {{__('frontEnd.join_trip')}}</button>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('ajaxCode')
    <script>
        $(document).ready(function() {
            var originalPrice={{$trip->price}};
            var originalLink='{{route('users.joinTrip',['trip_id'=>$trip->id])}}';
            //check voucher
            $("#voucherCode").on("input", function(e) {
                $('#codeInvalid').hide();
                $('#codeValid').hide();

                var input = $(this);
                var code = input.val();
                if( $(this).val().trim() == '' ) {
                    $('#codeInvalid').hide();
                    $('#tripPrice').text(originalPrice );

                }
                else{
                    $.ajax({
                        type: "GET",
                        url: "{{route('users.check.voucher')}}/?code=" + code +'&trip_id={{$trip->id}}' ,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                if(data.valid){
                                    $('#tripPrice').text(originalPrice * (data.discount/100) );
                                    $('#InputTripPrice').val(originalPrice * (data.discount/100) );
                                    $('#codeValid').show();
                                    var newLink=$('#join-trip').attr('href')+'?code='+code;
                                    $('#join-trip').attr('href',newLink);originalLink
                                }
                                else{
                                    $('#codeInvalid').show();
                                    $('#tripPrice').text(originalPrice );
                                    $('#InputTripPrice').val(originalPrice );
                                    $('#join-trip').attr('href',originalLink);
                                }
                            }
                            else{
                                $('#codeInvalid').show();
                                $('#tripPrice').text(originalPrice );
                                $('#InputTripPrice').val(originalPrice );

                                $('#join-trip').attr('href',originalLink);

                            }
                        }
                    });
                }

            });

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
                                if(!data.already){
                                    $('<audio id="chatAudio"> ' +
                                        '<source src="{{asset('sounds/star1.mp3')}}" type="audio/mpeg"> ' +
                                '</audio>').appendTo('body');
                                    // play sound
                                    $('#chatAudio')[0].play();
                                }
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

