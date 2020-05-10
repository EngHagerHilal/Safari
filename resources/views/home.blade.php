@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>normal user Dashboard</strong></div>

                <div class="card-body">
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
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="avialable-tab" data-toggle="tab" href="#avialable" role="tab" aria-controls="avialable" aria-selected="false">avialable </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="joined-tab" data-toggle="tab" href="#joined" role="tab" aria-controls="joined" aria-selected="false">joined </a>
                            </li>
                        </ul>
                        <div class="tab-pane fade show active" id="avialable" role="tabpanel" aria-labelledby="avialable-tab">
                            <h3 class="text-center">avialable trips [{{count($available)}}]</h3>
                            <div class="row">
                        @foreach($available as $trip)
                            <div class="col-4">
                                <h3><a href="#"> {{$trip->title}} </a></h3>
                                {{$trip->description}}
                                <a class="btn btn-success" href="{{route('users.joinTrip',['trip_id'=>$trip->id])}}">join this trip</a>
                            </div>
                        @endforeach
                    </div>
                        </div>
                        <div class="tab-pane fade" id="joined" role="tabpanel" aria-labelledby="joined-tab">
                            <h3 class="text-center">my joined trips [{{count($myTrips)}}]</h3>
                            <div class="row">
                                @foreach($myTrips as $trip)
                                    <div class="col-4">
                                        <h3><a href="#"> {{$trip->title}} </a></h3>
                                        {{$trip->description}}
                                        <a class="btn btn-success" href="{{route('users.cancleTrip',['trip_id'=>$trip->id])}}">cancle this trip</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
