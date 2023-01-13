@php
$url = url('/' . app()->getLocale() . '/organization/' . $company->id);
@endphp
<div class="event organization-card">
    <div class="event__share" data-url={{$company->getShortURL()}}>
        <img src="{{ asset('img/icons/share-red.svg') }}" alt="share button">
    </div>
    <a href="{{$url}}" class="event__img">
        <img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization image">
    </a>
    <a href="{{$url}}" class="organization__title">
        <h3>{{$company->name}}</h3>
    </a>
    <div class="event__bottom">
        
        <div class="organization__fields-container">
            <div class="firago firago--normal firago firago--sm firago--500 mb-2">საქმიანობა:</div>
            @if ($company->companyWorkingTypes)
                <div class="organization__fields">
                    @foreach ($company->companyWorkingTypes as $type)  
                        <h4>#{{$type->name}}</h4>
                    @endforeach
                </div>
            @endif
            <div class="d-flex align-items-center org-card-location">
            <a href="#" target=_blank class="event__location organization__location ">
                <!-- <img src="{{ asset('img/icons/location.svg') }}" alt="marker" class="marker"> -->
                @include('svg.location-marker')
                <p>{!! $company->address !!}</p>
            </a>
            <a href="{{$url}}" class="event__view organization__view">
              <!-- ნახე მეტი -->
               <img src="{{ asset('img/icons/arrow-right.svg') }}" alt="see more">
              </a>
            </div>
        </div>
    </div>
</div>