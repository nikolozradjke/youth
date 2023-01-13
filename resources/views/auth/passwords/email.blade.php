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
@if(session('status') && session('message') && session('status') == 'success')
<div class="popup popup-password popup-password-success popup-active">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="content-box content-box--green mb-6 firago firago--normal firago--md text-blue">
            {{ trans(session('message')) }}
        </div>
        <div class="button button--red popup__close">
            დახურვა
        </div>
    </div>
</div>
@endif

<div class="wrapper">
    @include('templates.userAreaNav')
    <div class="blue-container blue-container--inner authentication blue-layout-md reset-1">
        <div class="login-container authentication">
            <form action="{{ url('/' . app()->getLocale() . '/password-reset/email') }}" method="POST" class="form-login">
                @csrf
                <div class="heading heading--normal heading--fancy heading--fancy-white mb-2">დაგავიწყდა პაროლი?</div>
                <div class="enter-email-text firago firago--normal firago--sm mb-5">შეიყვანეთ ელ-ფოსტა, რომელზეც მოგივათ პაროლის აღდგენის ინსტრუქცია</div>
                <div class="form__group mb-5">
                    <label for="email" class="form__label">ელ-ფოსტა</label>
                    <input type="text" class="form__input" id="email" name="email" value="@if(old('email')){{old('email')}}@endif" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
                    
                    @if($errors->has('email'))
                    <div class="warning warning--md mb-3 mt-3 visible">
                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                        <div>{{ trans($errors->first()) }}</div>
                    </div>
                    @endif
                </div>
                <button type="submit" class="button button--red send-link justify-content-center">გაგზავნა <img src="{{ asset('img/icons/send-white.svg') }}" alt="send"></button>
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
        <!-- <div class="d-flex-md justify-content-center">
            <div class="link-fancy open-registration-links">
                <div class="title">არ გაქვს არსებული ექაუნთი?</div>
                <div class="attribute">
                    <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                </div>
            </div>
        </div> -->
    </div>
</div>

<!--<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>-->
@endsection