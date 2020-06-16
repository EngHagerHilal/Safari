@extends('layouts.app')
@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@section('content')
    <div class="main-bg-safary row">
        <div style="border-radius: 10px;" class="container bg-glass col-lg-8 offset-lg-2 my-3">
            <div style="padding-top: 100px" dir="ltr" class="row {{$text}}">
                <div class="col-md-10 offset-md-1">
                    <div class="panel panel-default">
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
                        <div class="panel-heading">
                            <div class="panel-heading text-center">
                                <h3 dir="{{$dir}}"><strong>sorry !</strong></h3>
                            </div>
                        </div>
                        <div style="border-radius: 10px" class="panel-body text-center bg-white m-lg-3 p-2 p-lg-5">
                            <p dir="{{$dir}}" class="font-1-2 text-center">
                                error happened <br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
