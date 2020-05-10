@extends('layouts.app')

@section('content')
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{Auth::guard('company')->user()->name}}</strong> Dashboard</div>

                <div class="panel-body">
                    You are logged in as Company!<br>
                    <div class="btn-group ">
                        <a href="{{route('company.trips.new')}}" class="btn btn-success">new trip</a>
                    </div>
                    @if(session('trip_message'))
                        <div class="alert alert-success">
                            {{session('trip_message')}}
                        </div>
                    @endif
                    @if(session('status'))
                        <div class="alert alert-success">
                           status now : <strong>{{session('status')}}</strong>
                        </div>
                    @endif
                    <h4 class="text-center">
                        {{$trip->title}}
                    </h4>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="false">trip details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="joiners-tab" data-toggle="tab" href="#joiners" role="tab" aria-controls="joiners" aria-selected="false">joiners [{{count($joiners)}}]</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <div class="trip-details">
                                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner" {{$active='active'}}>
                                        @foreach($trip->img as $img)
                                        <div class="carousel-item {{$active}}">
                                            <img class="d-block w-100" {{$active=''}} height="640" src="{{asset($img->img_url)}}" alt="First slide">
                                        </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                                <h3 class="text-center">{{$trip->title}}</h3>
                                <textarea disabled>{{$trip->description}}</textarea>
                                <p>trip from : {{$trip->trip_from}}</p>
                                <p>trip to : {{$trip->trip_to}}</p>
                                <p>status : {{$trip->status}}</p>
                                <p>category : {{$trip->category}}</p>
                                <p>phone : {{$trip->phone}}</p>
                                <p>price : {{$trip->price}}</p>
                                <p>trip start : {{$trip->start_at}}</p>
                                <p>trip end : {{$trip->end_at}}</p>
                                <p><strong>joiners : [{{count($joiners)}}]</strong></p>

                            </div>
                        </div>
                        <div class="tab-pane fade " id="joiners" role="tabpanel" aria-labelledby="joiners-tab">
                            <div class="row">
                            @foreach($joiners as $user)
                            <div class="col-md-4 border">
                                <a href="#"><h4 class="text-center" >{{$user->name}}</h4></a>
                                <p class="font-weight-bolder">{{$user->email}}</p>
                                <p>status: <strong>{{$user->status}}</strong></p>
                                <p>date: {{$user->created_at}}</p>

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
@endsection
