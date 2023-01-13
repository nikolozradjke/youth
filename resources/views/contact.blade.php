@extends('layouts.master')

@section('content')

<div class="wrapper no-padding-md">
    <div class="blue-container contact-page-block">
        <div class="contact-main">
            <div class="bordered-container contact-info">
                <div class="heading heading--xl">საკონტაქტო ინფორმაცია</div>
                <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $staticData->latitude . ',' . $staticData->longitude }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/subscribe-grey.svg') }}" alt="marker">
                    </div>
                    <span>{!! $staticData->address !!}</span>
                </a>
                <a href="tel:{{ $staticData->phone }}" class="link">
                    <div class="icon"><img src="{{ asset('img/icons/whatsapp.svg') }}" alt="tel"></div>
                    <span>{{ $staticData->phone }}</span>
                </a>
                @if(isset($staticData->fb_link))
                <a href="{{ $staticData->fb_link }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/facebook-new.svg') }}" alt="facebook">
                    </div>
                    <span>{{ $staticData->fb_link }}</span>
                </a>
                @endif
                @if(isset($staticData->twitter_link))
                <a href="{{ $staticData->twitter_link }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/twitter-green.svg') }}" alt="twitter">
                    </div>
                    <span>{{ $staticData->twitter_link }}</span>
                </a>
                @endif
                @if(isset($staticData->insta_link))
                <a href="{{ $staticData->insta_link }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/instagram-green.svg') }}" alt="instagram">
                    </div>
                    <span>{{ $staticData->insta_link }}</span>
                </a>
                @endif
            </div>
            <div class="map-container" id="map-container">
                <!-- <a style="width: 100%; height: 100%; display: block" href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $staticData->latitude . ',' . $staticData->longitude }}" target="_blank">
                    <img src="{{ asset('img/map.png') }}" alt="map" draggable="false">
                </a> -->
                <iframe
                 
                  src="https://maps.google.com/maps?q={{$staticData->latitude}},{{$staticData->longitude}}&hl=ge&z=14&amp;output=embed"
                  width="100%"
                  height="100%"
                  style="border: 0"
                  allowfullscreen=""
                  loading="lazy"
                ></iframe>
            </div>
        </div>
    </div>
</div>

@endsection