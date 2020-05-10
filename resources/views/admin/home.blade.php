@extends('admin.layout.auth')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{Auth::guard('admin')->user()->name}}</strong> Dashboard</div>

                <div class="panel-body">
                    You are logged in as Admin!
                    <div class="row">
                        <div class="col-4 border">
                            <a href="{{url('/admin/users')}}" >users [{{$users}}]</a>
                            <div class="row">
                                <div class="col">active []</div>
                                <div class="col">blocked []</div>
                            </div>
                        </div>
                        <div class="col-4 border">
                            <a href="{{url('/admin/partners')}}" >partners [{{$companies}}]</a>
                            <div class="row">
                                <div class="col">pendind []</div>
                                <div class="col">active []</div>
                                <div class="col">blocked []</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
