@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}" ></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/sweetalert2@9.js') }}" ></script>

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
            <a class="navbar-brand font-weight-bold text-uppercase"
               href="@guest('company'){{url('/')}}@else{{url('/company/home/')}}@endguest">Safari</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar1">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav">
                    @guest('company')@else
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('company.trips.new')}}">{{__('frontEnd.new_trip')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('/company/home/')}}">{{__('frontEnd.my_trips')}}</a>
                    </li>
                    @endguest
                </ul>
                <ul class="navbar-nav {{$margin}}">

                    <!-- Authentication Links -->
                    @yield('account_type')
                    @guest('company')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('company.login') }}"> {{ __('frontEnd.login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('company.register') }}"> {{ __('frontEnd.register') }}</a>
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

<script src="{{ asset('js/qrReader.js') }}" ></script>

@yield('ajaxCode')
<script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>
</body>
</html>
