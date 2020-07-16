@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="with safaregy explore wonderful egypt, enjoy your time and charge your life">
    <meta name="keywords" content="safari, egypt, land trips, air flight, hotel, tourism, explore">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('img/logo.png')}}" type="image/x-icon">

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
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link href="https://unpkg.com/webkul-micron@1.1.6/dist/css/micron.min.css" type="text/css" rel="stylesheet">

</head>
<body dir="{{$dir}}" style="overflow-x: hidden">
<div id="app">
    <nav style="background-color: #00AA6C;box-shadow: 0 0 8px rgba(0,0,0,.6)" class="navbar navbar-expand-sm sticky-top navbar-light ">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase" href="{{url('/')}}"><img src="{{asset('img/logo.png')}}" width="140" height="75" alt="safare"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar1">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar1">
                    <ul class="navbar-nav {{$margin}}">

                        @if(! \Illuminate\Support\Facades\Auth::check())
                            @if(! \Illuminate\Support\Facades\Auth::guard('company')->check())

                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/company/login/')}}">{{__('frontEnd.travel_partner')}}</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('frontEnd.login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/register') }}">{{ __('frontEnd.register') }}</a>
                            </li>
                            @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('company')->user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('company.editProfile') }}">
                                            {{ __('frontEnd.Edit_profile') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('company.logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
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
                                        {{ __('frontEnd.logout') }}
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
            <iframe style="width: 100%;min-height: 600px" src="{{$url}}" title="test payment">
            </iframe>
        </main>
    </div>
<!-- Footer -->
<footer class="page-footer font-small blue pt-4">

    <!-- Footer Links -->
    <div class="container-fluid text-center text-md-left">

        <!-- Grid row -->
        <div class="row {{$text}}">

            <!-- Grid column -->
            <div class="img-container col-md-6 mt-md-0 mt-3 text-center">

                <!-- Content -->
                <img src="{{asset('img/logo.png')}}" style="width: 150px;height: 120px;">
                <p class="text-uppercase font-1-2">SAFAREGY CHARGE YOUR LIVE</p>

            </div>
            <!-- Grid column -->

            <hr class="clearfix w-100 d-md-none pb-3">

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase font-weight-bolder">{{__('frontEnd.support')}}</h5>

                <ul dir="ltr" class="list-unstyled">
                    <li>
                        <a href="{{route('about-us')}}">{{__('frontEnd.about_us')}}</a>
                    </li>
                    <li>
                        <a href="{{route('new-message')}}">{{__('frontEnd.message_admin')}}</a>
                    </li>
                    <li>
                        <a target="_blank" href="https://wa.me/201001494049">{{__('frontEnd.message_whats')}}</a>
                    </li>
                </ul>

            </div>
            <!-- Grid column -->

            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">

                <!-- Links -->
                <h5 class="text-uppercase font-weight-bolder">{{__('frontEnd.customers_and_partners')}}</h5>

                <ul dir="ltr" class="list-unstyled">
                    <li>
                        <a href="{{route('terms')}}">{{__('frontEnd.customer_terms')}}</a>
                    </li>
                    <li>
                        <a href="{{route('terms')}}">{{__('frontEnd.partner_terms')}}</a>
                    </li>
                    <li>
                        <a href="{{url('/register')}}">{{__('frontEnd.sign_as_customer')}}</a>
                    </li>
                    <li>
                        <a href="{{url('/company/register')}}">{{__('frontEnd.sign_as_partner')}}</a>
                    </li>
                </ul>

            </div>
            <!-- Grid column -->

        </div>
        <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div style="background-color: #eee" class="footer-copyright text-center py-3">
        powered by <a target="_blank" href="https://leen.com.eg/">leen.com.eg </a><br> © Copyright
        {{date("Y")}} <a href="{{url('/')}}">{{env('APP_NAME')}}</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
@yield('ajaxCode')
<script src="{{ asset('js/bootstrap.min.js')}}" ></script>
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
