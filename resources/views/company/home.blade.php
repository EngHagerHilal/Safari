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
                        my trips
                    </h4>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">active [{{$active->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="disabled-tab" data-toggle="tab" href="#disabled" role="tab" aria-controls="disabled" aria-selected="false">disabled [{{$disabled->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab" aria-controls="completed" aria-selected="false">completed [{{$completed->count()}}]</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="row">
                            @foreach($active as $trip)
                                    <div class="col-md-4 border">
                                        <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}"><h4 class="text-center" >{{$trip->title}}</h4></a>
                                        <p class="font-weight-bolder">{{$trip->description}}</p>
                                        <p>status: <strong>{{$trip->status}}</strong></p>
                                        <p class="font-weight-bolder">new Join Request [{{$trip->newJoinRequest}}]</p>
                                        <p class="font-weight-bolder">resolved Join Request [{{$trip->resolvedJoinRequest}}]</p>
                                        <p class="font-weight-bolder">rejected Join Request [{{$trip->rejectedJoinRequest}}]</p>
                                        <p class="font-weight-bolder">confirmed Traveler [{{$trip->confirmedTraveler}}]</p>

                                        @switch($trip->status)
                                            @case('active')
                                            <a class="btn btn-secondary" href="{{route('company.trips.control',['action'=>'disabled','trip_id'=>$trip->id])}}">disable this trip</a>
                                            <a class="btn btn-primary" href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}">mark as completed</a>
                                            @break

                                            @case('disabled')
                                            <a class="btn btn-success" href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}">active this trip</a>
                                            @break

                                            @default
                                            this trip completed
                                        @endswitch
                                    </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="tab-pane fade " id="disabled" role="tabpanel" aria-labelledby="disabled-tab">
                            <div class="row">
                            @foreach($disabled as $trip)
                                    <div class="col-md-4 border">
                                        <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}"><h4 class="text-center" >{{$trip->title}}</h4></a>
                                        <p class="font-weight-bolder">{{$trip->description}}</p>
                                        <p>status: <strong>{{$trip->status}}</strong></p>
                                        <p class="font-weight-bolder">new Join Request [{{$trip->newJoinRequest}}]</p>
                                        <p class="font-weight-bolder">resolved Join Request [{{$trip->resolvedJoinRequest}}]</p>
                                        <p class="font-weight-bolder">rejected Join Request [{{$trip->rejectedJoinRequest}}]</p>
                                        <p class="font-weight-bolder">confirmed Traveler [{{$trip->confirmedTraveler}}]</p>

                                        @switch($trip->status)
                                            @case('active')
                                            <a class="btn btn-secondary" href="{{route('company.trips.control',['action'=>'disabled','trip_id'=>$trip->id])}}">disable this trip</a>
                                            <a class="btn btn-primary" href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}">mark as completed</a>
                                            @break

                                            @case('disabled')
                                            <a class="btn btn-success" href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}">active this trip</a>
                                            @break

                                            @default
                                            this trip completed
                                        @endswitch
                                    </div>
                            @endforeach
                        </div>
                        </div>
                        <div class="tab-pane fade " id="completed" role="tabpanel" aria-labelledby="completed-tab">
                            <div class="row">
                            @foreach($completed as $trip)
                            <div class="col-md-4 border">
                                <a href="{{route('company.trips.details',['trip_id'=>$trip->id])}}"><h4 class="text-center" >{{$trip->title}}</h4></a>
                                <p class="font-weight-bolder">{{$trip->description}}</p>
                                <p>status: <strong>{{$trip->status}}</strong></p>
                                <p class="font-weight-bolder">new Join Request [{{$trip->newJoinRequest}}]</p>
                                <p class="font-weight-bolder">resolved Join Request [{{$trip->resolvedJoinRequest}}]</p>
                                <p class="font-weight-bolder">rejected Join Request [{{$trip->rejectedJoinRequest}}]</p>
                                <p class="font-weight-bolder">confirmed Traveler [{{$trip->confirmedTraveler}}]</p>

                                @switch($trip->status)
                                    @case('active')
                                    <a class="btn btn-secondary" href="{{route('company.trips.control',['action'=>'disabled','trip_id'=>$trip->id])}}">disable this trip</a>
                                    <a class="btn btn-primary" href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}">mark as completed</a>
                                    @break

                                    @case('disabled')
                                    <a class="btn btn-success" href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}">active this trip</a>
                                    @break

                                    @default
                                    this trip completed
                                @endswitch
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
