@extends('admin.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center"><strong>{{Auth::guard('admin')->user()->name}}</strong> Dashboard</div>

                <div class="panel-body text-center">
                    All partners [{{$patrners}}]
                    @if(session('partner_message_success'))
                    <div class="alert alert-success">
                        {{session('partner_message_success')}}
                    </div>
                    @endif
                    @if(session('partner_message_error'))
                    <div class="alert alert-success">
                        {{session('partner_message_error')}}
                    </div>
                    @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="true">pending [{{$pending->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">active [{{$active->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="blocked-tab" data-toggle="tab" href="#blocked" role="tab" aria-controls="blocked" aria-selected="false">blocked [{{$blocked->count()}}]</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="rejected-tab" data-toggle="tab" href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">rejected [{{$rejected->count()}}]</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <div class="row">
                                @foreach($pending as $partner)
                                <div class="col-4 border">
                                    <a href="#"> {{$partner->name}}</a>
                                    <div class="row">
                                        <a class="col" href="{{route('admin.accept.partner',['partner_id'=>$partner->id])}}">accept</a>
                                        <a class="col" href="{{route('admin.reject.partner',['partner_id'=>$partner->id])}}">reject</a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="active" role="tabpanel" aria-labelledby="active-tab">
                            <div class="row">
                                @foreach($active as $partner)
                                    <div class="col-4 border">
                                        <a href="#"> {{$partner->name}}</a>
                                        <div class="row">
                                            @if($partner->status=='blocked')
                                                <a class="col btn btn-success" href="{{route('admin.active.partner',['partner_id'=>$partner->id])}}">active</a>
                                            @else
                                                <a class="col btn btn-danger" href="{{route('admin.active.partner',['partner_id'=>$partner->id])}}">block</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="blocked" role="tabpanel" aria-labelledby="blocked-tab">
                            <div class="row">
                                @foreach($blocked as $partner)
                                    <div class="col-4 border">
                                        <a href="#"> {{$partner->name}}</a>
                                        <div class="row">
                                            @if($partner->status=='blocked')
                                                <a class="col btn btn-success" href="{{route('admin.active.partner',['partner_id'=>$partner->id])}}">active</a>
                                            @else
                                                <a class="col btn btn-danger" href="{{route('admin.active.partner',['partner_id'=>$partner->id])}}">block</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                            <div class="row">
                                @foreach($rejected as $partner)
                                    <div class="col-4 border">
                                        <a href="#"> {{$partner->name}}</a>
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
