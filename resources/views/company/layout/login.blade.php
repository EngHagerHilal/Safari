@extends('company.layout.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('admin.company.login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <p>Email</p>
                            <input class="form-control" name="email" type="email" required value="">
                        </div>

                        <div class="form-group">
                            <p>Password</p>
                            <input class="form-control" name="password" type="password" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
