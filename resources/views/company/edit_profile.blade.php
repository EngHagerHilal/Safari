@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="text-center">edit profile <strong>{{Auth::guard('company')->user()->name}}</strong></h3></div>

                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/company/profile/update') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">name</label>

                            <div class="col-md-6">
                                <input id="name" required type="name" class="form-control" name="name" value="{{ Auth::guard('company')->user()->name }}" autofocus>
                                <input required type="hidden" name="current_email" value="{{$user->email}}" >

                                @if ($errors->has('name'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ Auth::guard('company')->user()->email }}">

                                @if ($errors->has('email'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                            <label for="old_password" class="col-md-4 control-label">current Password</label>
                            <div class="col-md-6">
                                <input id="old_password" type="password" class="form-control" required name="old_password">
                                @if ($errors->has('old_password'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                            <label for="new_password" class="col-md-4 control-label">new Password</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control"  name="new_password">
                                @if ($errors->has('new_password'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                            <label for="confirm_password" class="col-md-4 control-label">confirm new Password</label>
                            <div class="col-md-6">
                                <input id="confirm_password" type="password" class="form-control" name="confirm_password">
                                @if ($errors->has('confirm_password'))
                                    <span class="help-block alert-danger">
                                            <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    update
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
