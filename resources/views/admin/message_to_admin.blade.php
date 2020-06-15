@extends('layouts.app')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">

        <div class="limiter">
            <div class="container notification py-3">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-info" role="alert">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="container-login100">

                <div class="wrap-login100">
                    {!! Form::open(['url'=>route('insert.new_message'),'class'=>'login100-form validate-form p-l-55 p-r-55 p-t-178 text-center arabicFont','method'=>'POST']) !!}
                        <span class="login100-form-title text-capitalize">
                        {{__('frontEnd.new_message')}}
                        </span>
                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label  ">
                            {{__('frontEnd.name')}}
                        </label>
                        <div class="wrap-input100 validate-input m-b-16 col-md-8">
                            <input id="name" type="text" class=" input-100 form-control @error('name') is-invalid @enderror" name="name" required value="{{old('name')}}" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label  ">
                            {{__('frontEnd.email')}}
                        </label>
                        <div class="wrap-input100 validate-input m-b-16 col-md-8">
                            <input id="email" type="text" class=" input-100 form-control @error('email') is-invalid @enderror" name="email" required value="{{old('email')}}" >
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="message" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.message')}}
                            </label>

                            <div class="overflow-hidden wrap-input100 validate-input m-b-16 col-md-8">
                                <textarea id="message" rows="5"
                                          style="resize: none;border: none;" class=" input-100 form-control @error('message') is-invalid @enderror" name="message" required >{{old('message')}}</textarea>

                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="container-login100-form-btn">
                            <button type="submit" class="login100-form-btn">
                                {{ __('frontEnd.send') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


