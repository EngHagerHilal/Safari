@extends('company.layout.auth')

@section('content')
    <div class="padding-top-0 first-main-container login-bg" style="min-height: 600px;">
        <div class="limiter">
            <div class="container-login100">
                <div class="notification py-3">
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

                <div class="wrap-login100">
                    {!! Form::open(['url'=>route('admin.insert.new.ads'),'files' => true,'class'=>'login100-form validate-form p-l-55 p-r-55 p-t-178 text-center arabicFont','method'=>'POST']) !!}
                        <span class="login100-form-title text-capitalize">
                        {{__('frontEnd.new_ads')}}
                        </span>
                        <div class="form-group row">
                            <label for="title" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.ads_title')}}
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
                                          style="resize: none;border: none;" class=" input-100 form-control @error('desc') is-invalid @enderror" name="desc" required >{{old('desc')}}</textarea>

                                @error('desc')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_name" class="col-md-3 col-form-label  ">
                                {{__('frontEnd.ads_company')}}
                            </label>
                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="company_name" type="text" class=" input-100 form-control @error('company_name') is-invalid @enderror" name="company_name" required value="{{old('company_name')}}" >
                                @error('company_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="link" class="col-md-3 col-form-label  ">
                                {{ __('frontEnd.ads_link') }}
                            </label>

                            <div class="wrap-input100 validate-input m-b-16 col-md-8">
                                <input id="link" type="text" class=" input-100 form-control @error('link') is-invalid @enderror" name="link"  value="{{old('link')}}" >
                                @error('link')
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
                                {!! Form::file('img',["class"=>"form-control","required"=>"required" , "placeholder"=>"images","id"=>"img_url"]) !!}

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


