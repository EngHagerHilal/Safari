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
    @yield('homePageSlider')
    <nav style="background-color: #00AA6C;box-shadow: 0 0 8px rgba(0,0,0,.6)" class="navbar navbar-expand-sm sticky-top navbar-light ">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase" href="@guest('admin'){{url('/')}}@else{{url('/admin/home/')}}@endguest"><img src="{{asset('img/logo.png')}}" width="140" height="75" alt="safare"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar1">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar1">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a class="nav-link" href="{{url('/admin/partners')}}">{{__('frontEnd.partners')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/users/')}}">{{__('frontEnd.users')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('admin/advertisement/')}}">{{__('frontEnd.ads')}}</a>
                    </li>
                </ul>
                <ul class="navbar-nav {{$margin}}">

                    <!-- Authentication Links -->
                    @yield('account_type')
                    @guest('admin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.login') }}">admin {{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <!--li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.register') }}">admin {{ __('Register') }}</a>
                            </li -->
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
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
<footer>
    <div style="background-color: rgb(0,170,108)" class="footer">
        <div class="row py-5">
            <div class="col-12 col-md-6">
                <img style="height: 100px" class="pl-3 pr-3 img-fluid" src="{{asset('img/logo.png')}}">
            </div>
            <div class="col-12 col-md-3">
                <h4>user terms</h4>
            </div>
            <div class="col-12 col-md-3">
                <h4>partner terms</h4>
            </div>
        </div>
    </div>
</footer>

<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('js/qrReader.js') }}" ></script>
<script src="{{ asset('js/main.js') }}" ></script>
<script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>
</body>
</html>
