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

                                <h3 dir="{{$dir}}"><strong>{{__('frontEnd.terms',[],$currentLang)}}</strong></h3>
                            </div>
                        </div>
                        <div style="border-radius: 10px" class="panel-body text-center bg-white m-lg-3 p-2 p-lg-5">
                                <ol dir="{{$dir}}">
                                    <h3>
                                        <li>{{__('frontEnd.terms_intro',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.terms_intro_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.info_colection',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.info_colection_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.using_info',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.using_info_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.detect_your_info',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.detect_your_info_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.transfer_data',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.transfer_data_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.saving_your_data',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.saving_your_data_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.safe_of_data',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.safe_of_data_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.editing',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.editing_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.your_law',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.your_law_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.third_part',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.third_part_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.updating_data',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.updating_data_text',[],$currentLang)}}</p>

                                    <h3>
                                        <li>{{__('frontEnd.cookies_files',[],$currentLang)}}</li>
                                    </h3>
                                    <p class="line-height-1-9 multiline {{$text}}">{{__('frontEnd.cookies_files_text',[],$currentLang)}}</p>

                                </ol>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
