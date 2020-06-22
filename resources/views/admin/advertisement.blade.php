@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
    $offset_1= str_replace('_', '-', app()->getLocale()) =='ar' ? 'margin-right:8.3%' : 'margin-left:8.3%';
@endphp
@extends('admin.layout.auth')
@section('content')
    <div class="main-bg-safary">
        <div class="container bg-glass">
            <div class="notification py-3">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-info" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div dir="ltr" class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="panel panel-default position-relative">
                        <a href="{{route('ads.new')}}" class="btn btn-success"><i class="fa fa-plus"></i> </a>
                        <div class="panel-heading">
                            <div class="panel-heading text-center">
                                <h3><strong>{{__('frontEnd.advertisement')}}</strong></h3>
                            </div>
                        </div>
                        <div class="panel-body text-center">
                            <ul dir="{{$dir}}" class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">
                                        {{__('frontEnd.active_ads')}} [{{$active->count()}}]
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="disactive-tab" data-toggle="tab" href="#disactive" role="tab" aria-controls="disactive" aria-selected="false">
                                        {{__('frontEnd.disactive_ads')}} [{{$disactive->count()}}]
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                                    <div dir="{{$dir}}" class="py-3 row">
                                        @foreach($active as $ads_item)
                                            <div class="col-md-4 col-sm-6 col-12  py-3">
                                                <div style="border-radius: 10px" class="bg-white border">
                                                    <img style="height: 130px!important;" src="{{asset($ads_item->img)}}" class="img-fluid py-2">
                                                    <a class="d-block" href="#"><h4> {{$ads_item->title}} </h4></a>
                                                    <div class="card bg-transparent {{$text}}">
                                                        <ul class="list-group list-group-flush bg-transparent">
                                                            <li class="list-group-item bg-transparent"><i class="fab fa-discourse font-1-2 main-text-green"></i>
                                                                {{$ads_item->desc}}</li>
                                                            <li class="list-group-item bg-transparent"><i class="fas fa-sitemap font-1-2 main-text-green"></i> {{$ads_item->company_name}}</li>
                                                                                                                        <li class="list-group-item bg-transparent"><a href="{{$ads_item->link}}" target="_blank"><i class="fas fa-globe font-1-2 main-text-green"></i> {{$ads_item->link}}</a></li>
                                                            <li class="list-group-item bg-transparent"><i class="far fa-calendar-check font-1-2 main-text-green"></i>
                                                                {{date('d-m-Y',strtotime($ads_item->created_at))}}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="">
                                                        <a class="btn my-2 btn-danger " href="{{route('ads.control',['control'=>'hide','ads_id'=>$ads_item->id])}}">
                                                            <i class="fas fa-eye-slash font-1-6"></i> {{__('frontEnd.hide_ads')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="disactive" role="tabpanel" aria-labelledby="disactive-tab">
                                    <div dir="{{$dir}}" class="py-3 row">
                                        @foreach($disactive as $ads_item)
                                            <div class="col-md-4 col-sm-6 col-12  py-3">
                                                <div style="border-radius: 10px" class="bg-white border">
                                                    <img style="height: 130px!important;" src="{{asset($ads_item->img)}}" class="img-fluid py-2">
                                                    <a class="d-block" href="#"><h4> {{$ads_item->title}} </h4></a>
                                                    <div class="card bg-transparent {{$text}}">
                                                        <ul class="list-group list-group-flush bg-transparent">
                                                            <li class="list-group-item bg-transparent"><i class="fab fa-discourse font-1-2 main-text-green"></i>
                                                                {{$ads_item->desc}}</li>
                                                            <li class="list-group-item bg-transparent"><i class="fas fa-sitemap font-1-2 main-text-green"></i> {{$ads_item->company_name}}</li>
                                                            <li class="list-group-item bg-transparent"><a href="{{$ads_item->link}}" target="_blank"><i class="fas fa-globe font-1-2 main-text-green"></i> {{$ads_item->link}}</a></li>
                                                            <li class="list-group-item bg-transparent"><i class="far fa-calendar-check font-1-2 main-text-green"></i>
                                                                {{date('d-m-Y',strtotime($ads_item->created_at))}}</li>
                                                        </ul>
                                                    </div>
                                                    <div class="">
                                                        <a class="btn my-2 btn-success " href="{{route('ads.control',['control'=>'show','ads_id'=>$ads_item->id])}}">
                                                            <i class="fas fa-eye font-1-6"></i> {{__('frontEnd.show_ads')}}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

