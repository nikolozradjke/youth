@extends('layouts.master')
@section('content')

@if ($success)
    <div class="query-completed query-success active">
        <div class="wrapper text-center">
            <p class="query-heading query-heading--primary">გილოცავთ!</p>
            <p class="query-heading query-heading--secondary">თქვენ წარმატებით დაასრულეთ კითხვარის შევსება!</p>
            <p class="paragraph--query">გადადით <a href="/" class="underlined">მთავარ გვერდზე</a> ან ნახეთ ახალი შესაძლებლობები</p>
            <div class="query-img-container">
                <img src="{{ asset('img/icons/gilocavt.svg') }}" alt="success page img which failed to get loaded">
            </div>
            <div class="d-flex justify-content-center">
                <a href="/events" class="link-fancy mt-5 mb-8">
                    <div class="title">ნახე ყველა შესაძლებლობა</div>
                    <div class="attribute">
                        <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="arrow">
                    </div>
                </a>
            </div>
        </div>
    </div>
@else
    <div class="query-completed query-failed active">
        <div class="wrapper text-center">
            <p class="query-heading query-heading--primary">შეცდომა!</p>
            <p class="query-heading query-heading--secondary">{{$error_msg}}</p>
            <p class="paragraph--query">გადადით <a href="/" class="underlined">მთავარ გვერდზე</a> ან ნახეთ ახალი შესაძლებლობები</p>
            <div class="query-img-container">
                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="success page img which failed to get loaded">
            </div>
            <div class="d-flex justify-content-center">
                <a href="/events" class="link-fancy mt-5 mb-8">
                    <div class="title">ნახე ყველა შესაძლებლობა</div>
                    <div class="attribute">
                        <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="arrow">
                    </div>
                </a>
            </div>
        </div>
    </div>
@endif
@endsection