@extends('layouts.master')

@section('content')
<div class="wrapper login-page-wrapper">
    @include('templates.userAreaNav')
    <div class="blue-container blue-container--inner authentication align-items-center blue-layout-md">
        
        <div class="login-container">
            <form action="/post-login" method="POST" class="form-login" autocomplete="false">
                {{ csrf_field() }}
                <div class="heading heading--fancy heading--fancy-white heading--normal">ავტორიზაცია</div>
                <div class="form__group">
                    <label for="email" class="form__label">ელ.ფოსტა</label>
                    <input type="text" class="form__input" id="email" name="email" autocomplete="none" readonly value="@if(old('email')){{old('email')}}@endif" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" placeholder="შეიყვანეთ ელ. ფოსტა">
                    
                </div>

                <div class="form__group">
                    <label for="password" class="form__label">პაროლი</label>
                    <input type="password" class="form__input" id="password" name="password" pattern=".{8,}" autocomplete="off" placeholder="*******">
                   
                    <div class="password-visible">
                        <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                    </div>
                </div>

                <input type="submit" style="display: none;" autocomplete="off">
                
                @if($errors->has('password') || $errors->has('email'))
                <div class="warning warning--md mb-3 visible">
                    <!-- <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false"> -->
                    <div>{{ trans($errors->first()) }}</div>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4 mt-1">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span class="checkmark"></span>
                        <span class="firago firago--xs firago--normal firago--ls--xs">დამახსოვრება</span>
                    </label>
                    <a href="{{ url('/' . app()->getLocale() . '/password-reset/email-form') }}" class="firago  firago--xs no-underline firago--normal firago--ls--sm">დაგავიწყდა პაროლი?</a>
                </div>
                <div class="button button--red d-flex align-items-center justify-content-center ">
                  ავტორიზაცია 
                  <!-- <img src="{{ asset('img/icons/exit.svg') }}" alt="login"> -->
                </div>
            </form>
            <div class="login-socials margin-h-auto">
                <div class="firago firago--xs mb-3 mt-2 firago--normal d-flex align-items-center justify-content-between">ან</div>
                <div class="">
                    <a href="{{ url('/login/social/facebook') }}" target=_blank class="button button--red">
                      <img src="{{ asset('img/icons/fb-Vector.svg') }}" alt="">
                      Continue with facebook
                    </a>
                    <a href="{{ url('/login/social/google') }}" target=_blank class="button button--red button--soc button--soc-red">
                      <img src="{{ asset('img/icons/google 1.svg') }}" alt="">

                      Continue with google
                    </a>
                </div>
            </div>
        </div>
        <div class="right d-flex align-items-center">
            <div class="registration-links blue-layout-md">
                <div class="firago firago--md firago--normal mb-2 mt-2 line-height-1-3">არ ხარ დარეგისტრირებული? გაიარე რეგისტრაცია</div>
                <a href="{{ url('/' . app()->getLocale() . '/org-registration') }}" class="button button--red">ორგანიზაციისთვის</a>
                <a href="{{ url('/' . app()->getLocale() . '/user-registration') }}" class="button button--red">მომხმარებლისთვის</a>
                <a href="{{ url('/' . app()->getLocale() . '/user-worker-registration') }}" class="button button--red"> ახალგაზრდული მუშაკისთვის</a>
            </div>
        </div>
        <!-- <div class="d-flex-md justify-content-center flex-shink-0">
            <div class="link-fancy mt-2 open-registration-links">
                <div class="title">არ გაქვს არსებული ექაუნთი?</div>
                <div class="attribute">
                    <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection