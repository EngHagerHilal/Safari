@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
    $offset_1= str_replace('_', '-', app()->getLocale()) =='ar' ? 'margin-right:8.3%' : 'margin-left:8.3%';
    $currentLang= str_replace('_', '-', app()->getLocale()) =='ar' ? 'ar' : 'en';

@endphp
@extends('layouts.app')
@section('content')
    <div class="main-bg-safary row">
        <div style="border-radius: 10px;" class="container bg-glass col-lg-8 offset-lg-2 my-3">
            <div style="padding-top: 100px" dir="ltr" class="row {{$text}}">
                <div class="col-md-10 offset-md-1">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-heading text-center">
                                <h3 dir="{{$dir}}"><strong>{{__('frontEnd.about_text_head',[],$currentLang)}}</strong></h3>
                            </div>
                        </div>
                        <div style="border-radius: 10px" class="panel-body text-center bg-white m-lg-3 p-2 p-lg-5">
                            <p dir="{{$dir}}" class="font-1-2">
                                {{__('frontEnd.about_text',[],$currentLang)}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
