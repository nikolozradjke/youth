@extends('layouts.master')

@section('content')

@if($errors->any())
<div class="popup popup-password popup-active">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="content-box mb-6 firago firago--normal firago--md text-blue">
            {{ trans($errors->first()) }}
        </div>
        <div class="button button--red popup__close">
            დახურვა
        </div>
    </div>
</div>
@endif
<div class="popup popup-password popup-password-success">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="content-box content-box--green mb-6 firago firago--normal firago--md text-blue">
            დაფიქსირდა შეცდომა
        </div>
        <div class="button button--red popup__close">
            დახურვა
        </div>
    </div>
</div>

<div class="wrapper login-page-wrapper">
    @include('templates.userAreaNav')
    <div class="blue-container blue-container--inner authentication blue-layout-md reset-2 reset-password-link ">
        <div class="login-container border-none d-flex align-items-center justify-content-center">
            <form action="{{ url('/' . app()->getLocale() . '/password-reset/reset') }}" method="POST" class="form-login form-password-recovery">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="heading heading--fancy heading--normal heading--fancy-white mb-3">პაროლის აღდგენა</div>
                <div class="form__group">
                  <label for="email" class="form__label">ელექტრონული მეილი</label>
                    <input type="text" class="form__input" id="email" name="email" autocomplete="off" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" value="@if(old('email')){{old('email')}}@endif">
                    
                    <div class="form__tooltip form__tooltip--light">
                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                        <div>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                    </div>
                </div>
                <div class="firago firago--sm mb-4 firago--normal"></div>
                <!-- <div class="firago firago--sm mb-4 firago--normal">შეარჩიე ახალი პაროლი</div> -->
                <div class="form__group">
                    <label for="password" class="form__label">პაროლი</label>
                    <input type="password" class="form__input" id="password" autocomplete="off" name="password">
                    
                    <div class="password-visible">
                        <img src="{{ asset('img/icons/eye-white.svg') }}" alt="eye" draggable="false">
                    </div>
                    <div class="form__tooltip form__tooltip--light">
                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false" pattern=".{8,}">
                        <div>პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>
                    </div>
                </div>
                <div class="form__group">
                    <label for="password_confirmation" class="form__label">გაიმეორე პაროლი</label>
                    <input type="password" class="form__input" id="password_confirmation" autocomplete="off" name="password_confirmation" pattern=".{8,}">
                    
                    <div class="password-visible">
                        <img src="{{ asset('img/icons/eye-white.svg') }}" alt="eye" draggable="false">
                    </div>
                    <div class="form__tooltip form__tooltip--error">
                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false" pattern=".{8,}">
                        <div>პაროლები არ ემთხვევა</div>
                    </div>
                </div>

                @if($errors->any())
                <div class="warning warning--md mb-3 mt-3 visible">
                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                    <div>{{ trans($errors->first()) }}</div>
                </div>
                @endif

                <button type="submit" class="button button--red mb-9 disabled justify-content-center" disabled>შეცვლა 
                  <!-- <img src="{{ asset('img/icons/save-img.svg') }}" alt="save"> -->
                </button>
            </form>
        </div>
        <div class="right d-flex align-items-center">
            <div class="registration-links blue-layout-md">
                <div class="firago firago--md firago--normal mb-2 mt-2 line-height-1-3">არ ხარ დარეგისტრირებული? გაიარე რეგისტრაცია</div>
                <a href="{{ url('/' . app()->getLocale() . '/org-registration') }}" class="button button--red">ორგანიზაციისთვის</a>
                <a href="{{ url('/' . app()->getLocale() . '/user-registration') }}" class="button button--red">მომხმარებლისთვის</a>
                <a href="{{ url('/' . app()->getLocale() . '/user-worker-registration') }}" class="button button--red">ახალგაზრდა მუშაკებისთვის</a>
            </div>
        </div>
    </div>
</div>
@endsection