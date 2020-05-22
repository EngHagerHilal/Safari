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
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" defer></script>

<!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@800&family=Cairo&display=swap" rel="stylesheet">
<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}"></head>
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
                            <a class="nav-link" href="#">{{__('frontEnd.air_flights')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{__('frontEnd.sea_trips')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">{{__('frontEnd.land_trips')}}</a>
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
                        @if(str_replace('_', '-', app()->getLocale()) == 'en')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('locale/ar') }}" >عربي</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('locale/en') }}" >English</a>
                            </li>
                        @endif

                    </ul>
                </div>
            </div>
        </nav>

        <main >
            @yield('content')
        </main>
    </div>

<script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>
</body>
</html>
