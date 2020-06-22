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
    <meta name="description" content="with safaregy explore wonderful egypt, enjoy your time and charge your life">
    <meta name="keywords" content="safari, egypt, land trips, air flight, hotel, tourism, explore">
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
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link href="https://unpkg.com/webkul-micron@1.1.6/dist/css/micron.min.css" type="text/css" rel="stylesheet">

</head>
<body dir="{{$dir}}" style="overflow-x: hidden">
<div id="app">
    @yield('homePageSlider')
    <nav style="background-color: #00AA6C;box-shadow: 0 0 8px rgba(0,0,0,.6)" class="navbar navbar-expand-sm sticky-top navbar-light ">
        <div class="container">
            <a class="navbar-brand font-weight-bold text-uppercase"
               href="@guest('company'){{url('/')}}@else{{url('/company/home/')}}@endguest"><img src="{{asset('img/logo.png')}}" width="140" height="75" alt="safare"></a>
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
                                    {{ __('frontEnd.logout') }}
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
                        <a class="" href="{{route('about-us')}}">{{__('frontEnd.about_us')}}</a>
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
    <div style="background-color: #eee" class="footer-copyright text-center py-3"><a target="_blank" href="https://leen.com.eg/">© 2020 Copyright: leen.com.eg</a>

    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
<script src="{{ asset('js/qrReader.js') }}" ></script>
<script src="{{ asset('js/main.js') }}" ></script>
<script src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

@yield('ajaxCode')
<script src="https://kit.fontawesome.com/8aaad534d4.js" crossorigin="anonymous"></script>
</body>
</html>
