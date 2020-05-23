@extends('company.layout.auth')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    {!! Form::open(['url'=>route('company.trips.insert'),'files' => true,'class'=>'login100-form validate-form p-l-55 p-r-55 p-t-178 text-center arabicFont','method'=>'POST']) !!}

                        <span class="login100-form-title text-capitalize">
                        {{__('frontEnd.new_trip')}}
                        </span>

                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.title')}}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="title" type="text" class=" input-100 form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.description')}}
                            </label>

                            <div class="overflow-hidden wrap-input100 validate-input m-b-16 col-md-8">
                                <textarea id="description" rows="5"
                                          style="resize: none;border: none;" class=" input-100 form-control @error('description') is-invalid @enderror" name="description" required >{{old('description')}}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="trip_from" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.start')}}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="trip_from" type="text" class=" input-100 form-control @error('trip_from') is-invalid @enderror" name="trip_from" required value="{{old('trip_from')}}" >

                                @error('trip_from')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="trip_to" class="col-md-3 col-form-label  ">
                                {{ __('frontEnd.destination') }}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="trip_to" type="text" class=" input-100 form-control @error('trip_to') is-invalid @enderror" name="trip_to" required value="{{old('trip_to')}}" >

                                @error('trip_to')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.phone')}}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="phone" type="text" class=" input-100 form-control @error('phone') is-invalid @enderror" name="phone" required value="{{old('description')}}" >

                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.price')}}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="price" type="number" class=" input-100 form-control @error('price') is-invalid @enderror" name="price" required value="{{old('price')}}" >

                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="category" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.category')}}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <select id="category"class="border-0 input-100 form-control @error('category') is-invalid @enderror" name="category" required value="{{old('category')}}" >
                                    <option selected disabled value="">{{__('frontEnd.category')}}</option>
                                    <option value="air flights">{{__('frontEnd.air_flights')}}</option>
                                    <option value="land trips">{{__('frontEnd.land_trips')}}</option>
                                    <option value="sea trips">{{__('frontEnd.sea_trips')}}</option>
                                </select>
                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="start_at" class="col-md-3 col-form-label  ">
                                {{ __('frontEnd.trip_start') }}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="start_at" type="date" class=" input-100 form-control @error('start_at') is-invalid @enderror" name="start_at" required value="{{old('start_at')}}" >

                                @error('start_at')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="end_at" class="col-md-3 col-form-label  ">
                                {{ __('frontEnd.trip_end') }}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="end_at" type="date" class=" input-100 form-control @error('end_at') is-invalid @enderror" name="end_at" required value="{{old('end_at')}}" >

                                @error('end_at')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="img" class="col-md-3 col-form-label  ">
                                {{ __('frontEnd.images') }}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                {!! Form::file('img[]',["class"=>"form-control","multiple","required" , "placeholder"=>"images","id"=>"img_url"]) !!}

                                @error('img')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            {{ __('frontEnd.add') }}
                        </button>
                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


