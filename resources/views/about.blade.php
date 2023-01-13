@extends('layouts.master')

@section('content')

<div class="wrapper no-padding-md">
    <div class="blue-container about-page-block">
        <div class="about-main">
            <div class="about-info">
                <div class="heading heading--md heading--200 heading--italic">{{ $staticData->about_us_title }}</div>
                <h2 class="heading heading--lgg">{{ $staticData->about_us_subtitle }}</h2>
                <div class="paragraph paragraph--md">
                    {!! $staticData->about_us_text !!}
                </div>
            </div> 
            
            <img src="{{ asset('img/axalgazrdoba-img-lg.svg') }}" alt="youth agency" class="about-img">
        </div>
    </div>
</div>

@endsection