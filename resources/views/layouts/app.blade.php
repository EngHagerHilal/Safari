@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'safari') }}</title>

<!-- Scripts -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&family=Cairo&display=swap" rel="stylesheet">
<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}"></head>
    <link href="https://unpkg.com/webkul-micron@1.1.6/dist/css/micron.min.css" type="text/css" rel="stylesheet">
<body dir="{{$dir}}">
<div id="app">
    @yield('homePageSlider')
    <nav style="background-color: #00AA6C;box-shadow: 0 0 8px rgba(0,0,0,.6)" class="navbar navbar-expand-sm sticky-top navbar-light ">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase" href="{{url('/')}}">Safari</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{url('/trips/search?category=air+flights')}}">{{__('frontEnd.air_flights')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/trips/search?category=sea+trips')}}">{{__('frontEnd.sea_trips')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/trips/search?category=land+trips')}}">{{__('frontEnd.land_trips')}}</a>
                        </li>
                        @guest()
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('/company/login/')}}">{{__('frontEnd.travel_partner')}}</a>
                        </li>
                        @endguest
                    </ul>
                    <ul class="navbar-nav {{$margin}}">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('frontEnd.login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/register') }}">{{ __('frontEnd.register') }}</a>
                            </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('myJoinedTrips')}}">{{__('frontEnd.my_​​trips')}}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('users.editProfile') }}">
                                        {{ __('frontEnd.Edit_profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        @endguest
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{__('frontEnd.'.str_replace('_', '-', app()->getLocale()))}}
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('locale/ar') }}" >{{__('frontEnd.ar')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/en') }}" >{{__('frontEnd.en')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/fr') }}" >{{__('frontEnd.fr')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/es') }}" >{{__('frontEnd.es')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/it') }}" >{{__('frontEnd.it')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/de') }}" >{{__('frontEnd.de')}}</a>
                                    <a class="dropdown-item" href="{{ url('locale/ru') }}" >{{__('frontEnd.ru')}}</a>
                                </div>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main >
            @yield('content')
        </main>
    </div>
@yield('ajaxCode')
<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('js/main.js') }}" ></script>

<script>
    function rateIt(trip_id,value){

        var token   = '{{csrf_token()}}';
        var newHTML ='';
        $(this).parent('.main-rate').hasClass('rate-it')
        {
            $.ajax({
                type: "GET",
                url: "{{url('/tripDetails/rate')}}/"+trip_id+"/"+value,
                dataType: "json",
                data: {'trip_id': trip_id, 'rate': value, '_token': token},
                success: function (data) {
                    if (data.success) {
                        $('#rate-trip-id_' + trip_id).removeClass('rate-it');

                        $('#rate-trip-id_' + trip_id ).children('i').removeClass('fa').addClass('far');
                        $('#rate-trip-id_' + trip_id + ' i:nth-child(' + 3 + ')').attr('data-micron','').siblings().attr('data-micron','');

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

    }

    $('.main-rate>i').click(function(e){
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

</script>
<script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/webkul-micron@1.1.6/dist/script/micron.min.js" type="text/javascript"></script>


</body>
</html>
