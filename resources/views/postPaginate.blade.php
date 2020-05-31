@php
    $dir= str_replace('_', '-', app()->getLocale()) =='ar' ? 'rtl' : 'ltr';
    $margin= str_replace('_', '-', app()->getLocale()) =='ar' ? 'mr-auto' : 'ml-auto';
    $text= str_replace('_', '-', app()->getLocale()) =='ar' ? 'text-right' : 'text-left';
@endphp
@foreach($availableTrips as $trip)
    <div class="post-item bg-light box-shadow">
        <div class="post-header {{$text}}">
            <div class="text-center creater-logo d-inline-block">
                <i class="far fa-compass d-block m-auto main-text-green fa-3x"></i>
            </div>
            <div class="creater-text d-inline-block">
                <a class="d-block" href="#">
                    <strong class="text-uppercase text-dark">{{$trip->companyName}}</strong>
                </a>
                <span class="d-block">{{$trip->created_at}}</span>

            </div>
        </div>
        <div class="post-body">
            <div class="image-container">
                <img src="{{asset($trip->mainIMG)}}" class="img-fluid" style="width: 100%!important;" height="500">
            </div>
            <div class="px-2 more-details {{$text}}">
                <a href="{{route('users.tripDetails',['trip_id'=>$trip->id])}}">
                    <h3 class="font-weight-bold text-dark text-uppercase">{{$trip->title}}</h3>
                </a>
                <p class="text-dark">{{$trip->description}}</p>

                @if($trip->rated==false)
                    @php
                        $rated='rate-it';
                    @endphp
                @else
                    @php
                        $rated='';
                    @endphp
                @endif
                <div rate="{{$trip->rate}}" id="rate-trip-id_{{$trip->id}}" class="{{$text}} main-rate {{$rated}}">
                    <div {{$animate='pop'}}></div>
                    @for($i=1;$i<=$trip->rate;$i++)
                        <i trip-id="{{$trip->id}}" data-micron="{{$animate=''}}" class="fa fa-star gold-color font-1-6" rate-value={{$i}} onclick="rateIt({{$trip->id}},{{$i}})"></i>
                    @endfor
                    @for($y=1;$y<=(5 - $trip->rate);$y++)
                        <i trip-id="{{$trip->id}}" data-micron="{{$animate}}" class="far fa-star gold-color font-1-6" rate-value="{{$y+$trip->rate}}" onclick="rateIt({{$trip->id}},{{$y+$trip->rate}})"></i>
                    @endfor

                </div>
            </div>
        </div>
    </div>
@endforeach
