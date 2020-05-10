@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>{{Auth::guard('company')->user()->name}}</strong> new trip</div>

                <div class="panel-body">
                        {!! Form::open(['url'=>route('company.trips.insert'),'files' => true,'class'=>' text-center arabicFont','method'=>'POST']) !!}

                        <div class="form-group row">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required >{{old('description')}}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="trip_from" class="col-md-4 col-form-label text-md-right">{{ __('trip_from') }}</label>

                            <div class="col-md-6">
                                <input id="trip_from" type="text" class="form-control @error('trip_from') is-invalid @enderror" name="trip_from" required value="{{old('trip_from')}}" >

                                @error('trip_from')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="trip_to" class="col-md-4 col-form-label text-md-right">{{ __('trip_to') }}</label>

                            <div class="col-md-6">
                                <input id="trip_to" type="text" class="form-control @error('trip_to') is-invalid @enderror" name="trip_to" required value="{{old('trip_to')}}" >

                                @error('trip_to')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required value="{{old('description')}}" >

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right">{{ __('price') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('price') is-invalid @enderror" name="price" required value="{{old('price')}}" >

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-4 col-form-label text-md-right">{{ __('category') }}</label>

                            <div class="col-md-6">
                                <select id="category"class="form-control @error('category') is-invalid @enderror" name="category" required value="{{old('category')}}" >
                                    <option selected disabled value="">category</option>
                                    <option value="air flights">air flights</option>
                                    <option value="land trips">land trips</option>
                                    <option value="sea trips">sea trips</option>
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_at" class="col-md-4 col-form-label text-md-right">{{ __('start_at') }}</label>

                            <div class="col-md-6">
                                <input id="start_at" type="date" class="form-control @error('start_at') is-invalid @enderror" name="start_at" required value="{{old('start_at')}}" >

                                @error('start_at')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_at" class="col-md-4 col-form-label text-md-right">{{ __('end_at') }}</label>

                            <div class="col-md-6">
                                <input id="end_at" type="date" class="form-control @error('end_at') is-invalid @enderror" name="end_at" required value="{{old('end_at')}}" >

                                @error('end_at')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-md-4 col-form-label text-md-right">{{ __('img') }}</label>

                            <div class="col-md-6">
                                {!! Form::file('img[]',["class"=>"form-control","multiple","required" , "placeholder"=>"images","id"=>"img_url"]) !!}

                                @error('img')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('save') }}
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
