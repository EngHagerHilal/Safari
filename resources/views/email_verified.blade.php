@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>wellcome {{$username}}</strong></div>

                <div class="card-body">
                    {{$message}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
