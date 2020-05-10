@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>search</strong></div>
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
                        <form method="get" action="{{route('user.trips.search')}}">
                            <div class="form-group">
                                <label for="search_for">search for</label>
                                <input type="text" class="form-control" id="search_for" name="text" placeholder="search for ...">
                            </div>
                            <div class="form-group">
                                <label for="city">city</label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="city">
                            </div>

                            <div class="form-group">
                                <label for="category" >{{ __('category') }}</label>
                                <select id="category"class="form-control " name="category" value="{{old('category')}}" >
                                    <option selected disabled value="">category</option>
                                    <option value="air flights">air flights</option>
                                    <option value="land trips">land trips</option>
                                    <option value="sea trips">sea trips</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="city">start date</label>
                                <input type="date" class="form-control" name="date" id="date" placeholder="date">
                            </div>

                            <button type="submit" class="btn btn-primary">search</button>
                        </form>
                </div>
            </div>
            <div class="container">
                @if(count($available)>0)
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
