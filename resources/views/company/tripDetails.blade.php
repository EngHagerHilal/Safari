@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@extends('company.layout.auth')
@section('content')
    <div class="padding-top-0 first-main-container" style="min-height: 600px;">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('alert'))
            <div class="alert alert-info" role="alert">
                {{ session('alert') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-8 col-12 post-details-container py-2">
                <div class="post-details bg-light box-shadow">
                    <div class="{{$text}} post-header">
                        <div class="text-center creater-logo d-inline-block">
                            <i class="far fa-compass d-block m-auto main-text-green fa-3x"></i>
                        </div>
                        <div class="creater-text d-inline-block">
                            <a class="d-block" href="#">
                                <strong class="text-uppercase text-dark">{{$trip->comapny}}</strong>
                            </a>
                            <span class="d-block">{{$trip->created_at}}</span>
                        </div>
                    </div>
                    <div class="post-body">
                        <div class="image-container full-images">
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner" {{$active='active'}}>
                                    @if(count($trip->img)>0)

                                        @foreach($trip->img as $img)
                                            <div class="carousel-item {{$active}}" {{$active=''}}>
                                                <img class="d-block w-100" height="640" src="{{asset($img->img_url)}}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item {{$active='active'}}" {{$active=''}}>
                                            <img class="d-block w-100" height="640" src="{{asset('img/no-img.png')}}">
                                        </div>
                                    @endif

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="more-details">
                            <h3 class="d-none d-md-block font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-4 col-12 panner-right post-full-details py-2">
                <div class="panner bg-light box-shadow">
                    <h3 class="py-3 text-uppercase text-center font-weight-bolder">{{$trip->title}}</h3>
                    <div class="{{$text}} full-details">
                        <p class="text-dark">{{$trip->description}}</p>

                        <p>
                            <i class="fas fa-location-arrow font-1-2 main-text-green"></i>
                            {{__('frontEnd.from')}}
                            <strong class="text-uppercase">{{$trip->trip_from}}</strong>
                            {{__('frontEnd.to')}}
                            <strong class="text-uppercase">{{$trip->trip_to}}</strong>
                        </p>

                        <p>
                            <i class="fas fa-money-bill-wave font-1-2 main-text-green"></i>
                            {{__('frontEnd.price')}} <strong class="text-uppercase">{{$trip->price}}</strong> $
                        </p>
                        <p>
                            <i class="fas fa-calendar-alt font-1-2 main-text-green"></i>
                            {{__('frontEnd.duration_from')}} <strong class="text-uppercase">{{$trip->start_at}}</strong> {{__('frontEnd.to')}} <strong>{{$trip->end_at}}</strong>
                        </p>
                        <p>
                            <i class="fas fa-user-check font-1-2 main-text-green"></i>
                            {{__('frontEnd.joiners')}} : <strong>{{$joinersNumber}}</strong>
                        </p>




                    </div>
                    <div class="aply-now">
                        <a href="!#" class="btn btn-success input-group aply-button" data-toggle="modal" data-target="#checkQRCode">
                            {{__('frontEnd.check_QR_user')}}
                        </a>
                        @switch($trip->status)
                            @case('active')
                            <a href="!#" class="btn btn-success input-group aply-button" data-toggle="modal" data-target="#modalRegisterForm">
                                {{__('frontEnd.add_voucher')}}
                            </a>
                            <a href="{{route('company.trips.control',['action'=>'disabled','trip_id'=>$trip->id])}}" class="btn btn-danger input-group aply-button">
                                <i class="fas fa-eye-slash font-1-2"></i> {{__('frontEnd.mark_disabled')}}
                            </a>
                            <a href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}" class="btn btn-primary input-group aply-button">
                                <i class="fas fa-check-circle font-1-2"></i> {{__('frontEnd.mark_completed')}}
                            </a>
                            @break
                            @case('disabled')
                            <a href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}" class="btn btn-success input-group aply-button">
                                <i class="fas fa-eye"></i> {{__('frontEnd.mark_active')}}
                            </a>
                            <a href="{{route('company.trips.control',['action'=>'completed','trip_id'=>$trip->id])}}" class="btn btn-primary input-group aply-button">
                                <i class="fas fa-check-circle font-1-2"></i> {{__('frontEnd.mark_completed')}}
                            </a>
                            @break
                            @case('completed')
                            <a href="{{route('company.trips.control',['action'=>'active','trip_id'=>$trip->id])}}" class="btn btn-success input-group aply-button">
                                <i class="fas fa-eye font-1-2"></i> {{__('frontEnd.mark_available')}}
                            </a>

                            @break

                            @default


                        @endswitch

                    </div>
                </div>

            </div>
        </div>
        <ul class="nav nav-tabs text-center" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link active" id="joiners-tab" data-toggle="tab" href="#joiners" role="tab" aria-controls="joiners" aria-selected="false">
                    {{__('frontEnd.joiners')}} [ <strong>{{$joinersNumber}}</strong> ]
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="active-tab" data-toggle="tab" href="#active" role="tab" aria-controls="active" aria-selected="false">
                    {{__('frontEnd.active_voucher')}} [ <strong>{{count($activeVoucher)}}</strong> ]
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired" role="tab" aria-controls="expired" aria-selected="false">
                    {{__('frontEnd.expired_voucher')}} [ <strong>{{count($expiredVoucher)}}</strong> ]
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="disabled-tab" data-toggle="tab" href="#disabled" role="tab" aria-controls="disabled" aria-selected="false">
                    {{__('frontEnd.disabled_voucher')}} [ <strong>{{count($disabledVoucher)}} </strong> ]
                </a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="joiners" role="tabpanel" aria-labelledby="joiners-tab">
                <div class="joined_users p-3 overflow-auto">
                    <table id="joined_users_table" dir="{{$dir}}" class="table table-success table-striped">
                        <thead>
                        <tr dir="{{$dir}}">
                            <th class="font-1-2"><i class="fas fa-ad  main-text-green"></i> user name </th>
                            <th class="font-1-2"><i class="fas fa-envelope main-text-green"></i> Email </th>
                            <th class="font-1-2"><i class="fas fa-phone main-text-green"></i> phone </th>
                            <th class="font-1-2"><i class="fas fa-list-ol main-text-green"></i> join Code </th>
                            <th class="font-1-2"><i class="fas fa-qrcode main-text-green"></i> QR code </th>
                            <th class="font-1-2"><i class="fas fa-calendar-alt main-text-green"></i> join date </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($joinersArray as $joiner)
                            <tr>
                                <td>{{$joiner->name}}</td>
                                <td>{{$joiner->email}}</td>
                                <td>{{$joiner->phone}}</td>
                                <td>{{$joiner->joinCode}}</td>
                                <td><img src="{{asset($joiner->QR_code)}}" width="50" height="50"> </td>
                                <td>{{$joiner->join_date}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="tab-pane fade " id="active" role="tabpanel" aria-labelledby="active-tab">
                <div dir="{{$dir}}" class="row">
                    @foreach($activeVoucher as $voucher)
                        <div class="{{$text}} col-md-4 border">
                            <p>{{__('frontEnd.code')}} : <strong>{{$voucher->code}}</strong></p>
                            <p>{{__('frontEnd.discount')}} : <strong>{{$voucher->discount}} %</strong></p>
                            <p>{{__('frontEnd.created_at')}} : {{$voucher->created_at}}</p>
                            <p>{{__('frontEnd.expire_at')}} : {{$voucher->expire_at}}</p>
                            <p>{{__('frontEnd.times_use')}} : {{$voucher->times_use}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade " id="expired" role="tabpanel" aria-labelledby="expired-tab">
                <div class="row">
                    @foreach($expiredVoucher as $voucher)
                        <div class="{{$text}} col-md-4 border">
                            <p>{{__('frontEnd.code')}} : <strong>{{$voucher->code}}</strong></p>
                            <p>{{__('frontEnd.discount')}} : <strong>{{$voucher->discount}} %</strong></p>
                            <p>{{__('frontEnd.created_at')}} : {{$voucher->created_at}}</p>
                            <p>{{__('frontEnd.expire_at')}} : {{$voucher->expire_at}}</p>
                            <p>{{__('frontEnd.times_use')}} : {{$voucher->times_use}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade " id="disabled" role="tabpanel" aria-labelledby="disabled-tab">
                <div class="row">
                    @foreach($disabledVoucher as $voucher)
                        <div class="{{$text}} col-md-4 border">
                            <p>{{__('frontEnd.code')}} : <strong>{{$voucher->code}}</strong></p>
                            <p>{{__('frontEnd.discount')}} : <strong>{{$voucher->discount}} %</strong></p>
                            <p>{{__('frontEnd.created_at')}} : {{$voucher->created_at}}</p>
                            <p>{{__('frontEnd.expire_at')}} : {{$voucher->expire_at}}</p>
                            <p>{{__('frontEnd.times_use')}} : {{$voucher->times_use}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">{{__('frontEnd.new_voucher')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{route('company.trips.newVoucher')}}">
                        @csrf
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5 row">
                                <div class="col-2 text-center">
                                    <i class="fas fa-money-bill-alt font-1-6 main-text-green"></i>
                                </div>
                                <input required name="discount" placeholder="{{__('frontEnd.discount_percent')}}" type="number" class="col-10 form-control @error('discount') is-invalid @enderror" min="1" max="99">
                                <input required name="trip_id"type="hidden" value="{{$trip->id}}">
                            </div>
                            <div class="md-form mb-5 row">
                                <div class="col-2 text-center">
                                    <i class="fas fa-calendar-check font-1-6 main-text-green"></i>
                                </div>
                                <input required name="expire_at" placeholder="{{__('frontEnd.expire_at')}}" type="date" class="col-10 form-control @error('expire_at') is-invalid @enderror">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="btn btn-success">{{__('frontEnd.add')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="checkQRCode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">{{__('frontEnd.check_QR_user')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="checkQR" method="post" action="{{route('company.checkQRCode')}}">
                        @csrf
                        <div class="modal-body mx-3">
                            <div class="md-form mb-5 row">
                                <div class="col-2 text-center">
                                    <i class="fas fa-qr-code font-1-6 main-text-green"></i>
                                </div>
                                <input id="QR_code" placeholder="{{__('frontEnd.upload_QR_img')}}" type="file" class="col-10 form-control">
                                <input type="hidden" value="{{$trip->id}}" name="trip_id">
                                <input id="QR_CODE" type="hidden" value="" name="QR_code">
                            </div>
                            <div class="md-form mb-5 row">
                                <div class="col-2 text-center">
                                    <i class="fas fa-qr-code font-1-6 main-text-green"></i>
                                </div>
                                <input id="content" name="code" type="text" placeholder="{{__('frontEnd.join_code')}}" class="col-10 form-control">
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button id="form-sub" type="submit" class="btn btn-success">{{__('frontEnd.check')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('ajaxCode')
    <script>
        $('#joined_users_table').DataTable();

        $( "#content" ).change(function() {
            $('#QR_CODE').val($( "#content" ).val());
        });
        $(document).on('submit','#checkQR',function (event) {
            event.preventDefault();
            var token   = '{{csrf_token()}}';
            $.ajax({
                    type: "POST",
                    url: "{{route('company.checkQRCode')}}" ,
                    data: {'QR_code': $( "#content" ).val(), '_token': token,'trip_id' : {{$trip->id}} },
                    dataType: "json",
                    success: function (data) {
                        document.getElementById("checkQR").reset();

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'user joined to this trip',
                                text: 'User name : '+data.user_name,
                            });
                        }
                        else{
                            Swal.fire({
                                icon: 'error',
                                title: 'code incorrect',
                                text: 'this code invalid ',
                            });
                        }
                    }
                });

        });
    </script>
@endsection
