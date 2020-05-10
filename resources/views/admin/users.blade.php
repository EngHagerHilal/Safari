@extends('admin.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong>{{Auth::guard('admin')->user()->name}}</strong> Dashboard</div>

                <div class="panel-body text-center">
                    All users [{{$users}}]
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">active [{{$active->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="blocked-tab" data-toggle="tab" href="#blocked" role="tab" aria-controls="blocked" aria-selected="false">blocked [{{$blocked->count()}}]</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="row">
                                @foreach($active as $user)
                                    <div class="col-4 border">
                                        <a href="#"> {{$user->name}}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="blocked" role="tabpanel" aria-labelledby="blocked-tab">
                            <div class="row">
                                @foreach($blocked as $user)
                                    <div class="col-4 border">
                                        <a href="#"> {{$user->name}}</a>
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
