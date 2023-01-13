@extends('layouts.master')

@section('content')


@php
if($user && $user->place_of_residence)
$residence = $user->place_of_residence
@endphp

<div class="popup popup-profile-pic">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="popup__close d-flex align-items-center">
            <span class="firago firago--normal firago--smm firago--dark mr-1">დახურვა</span>
            <img src="{{ asset('img/icons/x-dark.svg') }}" alt="close">
        </div>
        <div class="firago firago--smm firago--blue mb-9">ატვირთე ფოტო</div>
        <form action="{{ url('/update-profile-picture') }}" method="POST" enctype="multipart/form-data" class="profile-img-upload">
            @csrf
            <div class="uploader-container file-uploader">
                <label class="upload-button firago" for="inputFile">
                    <div class="file-name mw-100">
                        <span class="lg">ატვირთვა</span>
                        <span class="md">+</span>
                    </div>
                    <input type="file" id="inputFile" style="display: none;" name="image" accept=".jpg, .png, .jpeg">
                </label>
                <div class="img-src">no file chosen</div>
                <div class="img-src--filled">
                    <div class="file-name"></div>
                    <img src="{{ asset('img/icons/x-blue.svg') }}" alt="delete" class="delete-img">
                </div>
            </div>
            <p class="firago firago--normal firago--sm firago--blue mt-1">ფოტოს ზომა არ უნდა აღემატებოდეს 20 MB-ს</p>
            <button disabled type="submit" class="button button--red img-save disabled">
                <span class="mr-2">მიმაგრება</span>
                <img src="{{ asset('img/icons/save-img.svg') }}" alt="save">
            </button>
        </form>
    </div>
</div>

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
@if(session('update_status') && session('message') && session('update_status') == 'success')
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
@if(session('password_status') && session('message') && session('password_status') == 'success')
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

@php
$pageTitle = 'პროფილი';
$className = 'profile-nav-mobile';
@endphp


<div class="wrapper profile-page-wrapper">


    <div class="blue-container blue-container--inner blue-container--profile blue-layout-md">
        <div class="heading heading--fancy  my-profile-main-title">ჩემი პროფილი</div>
        <div class="profile-page-user-area">
        @include('templates.userAreaNav')
        </div>
        <div class="profile">
            <div class="profile-left-side">
              <div class="profile__top">

                  <div class="profile-pic">
                      <div class="pic-container">
                          <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="profile-picture">
                      </div>
                      <div class="profile-pic-upload">
                          <img src="{{ asset('img/icons/edit-white.svg') }}" alt="img upload">
                          <div class="firago firago--xs firago--normal">ატვირთე ფოტო</div>
                      </div>
                  </div>
                  @if($guard == 'web')
                  <div class="firago firago--mdd  user-full-name">{{ $user->first_name . ' ' . $user->last_name }}</div>
                  @else
                  <div class="firago firago--mdd  user-full-name">{{ $user->name }}</div>
                  @endif
                  <b class="line line--inner light mb-4"></b>
              </div>
              <ul class="profile__nav @if($guard == 'company') company @endif">
                  <!-- @if(($guard == 'web' && $user->company == 1) || $guard == 'company')
                  <div class="add-item-to-library">
                    <a href="{{ route('AddLibrary')  }}" class="button button--red">
                      <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" class="mr-1" alt="">
                      დაამატე ფაილი ბიბლიოთეკაში</a>
                  </div>
                  <div class="add-item-to-library youth-worker-add-opportunity">
                    <a href="{{ route('createOpportunity') }}" class="button button--red">
                      <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" class="mr-1" alt="">
                      დაამატე შესაძლებლობა</a>
                  </div>
                  @endif -->
                  @if($guard == 'web')
                  <li class="my-profile @if(!isset($tab) || (isset($tab) && ($tab=='private-info' || $tab=='disabilities' || $tab=='occupation' || $tab=='education' || $tab=='address'|| $tab=='password'))) active red @endif">
                      <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 6C7.38071 6 8.5 4.88071 8.5 3.5C8.5 2.11929 7.38071 1 6 1C4.61929 1 3.5 2.11929 3.5 3.5C3.5 4.88071 4.61929 6 6 6Z" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M10.2951 11C10.2951 9.065 8.37008 7.5 6.00008 7.5C3.63008 7.5 1.70508 9.065 1.70508 11" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>

                      <span>ჩემი პროფილი</span>
                      <svg class="arrow" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.93875 3.47014e-07L4.5 3.09171L1.06125 4.63887e-08L-4.17071e-08 0.954147L4.5 5L9 0.954147L7.93875 3.47014e-07Z" fill="#000" />
                      </svg>
                  </li>
                  <ul class="my-profile-nav @if(!isset($tab) || (isset($tab) && ($tab=='private-info' || $tab=='disabilities' || $tab=='occupation' || $tab=='education' || $tab=='address'|| $tab=='password'))) active @endif">
                      <li class="my-profile-button @if(!isset($tab) || isset($tab) && $tab=='private-info') active @endif"><span>პირადი ინფორმაცია</span></li>
                      <li class="my-profile-button @if(isset($tab) && $tab=='disabilities') active @endif"><span>მოკლედ ჩემს შესახებ</span></li>
                      <!-- <li class="my-profile-button @if(isset($tab) && $tab=='occupation') active @endif"><span>მიმდინარე საქმიანობა</span></li> -->
                      <li class="my-profile-button @if(isset($tab) && $tab=='education') active @endif"><span>განათლება</span></li>
                      <li class="my-profile-button @if(isset($tab) && $tab=='address') active @endif"><span>საცხოვრებელი ადგილი</span></li>
                      <li class="my-profile-button @if(isset($tab) && $tab=='password') active @endif"><span>პაროლის ცვლილება</span></li>
                  </ul>
                  @else
                  <!-- <div> -->
                      <!-- <li class="add-item-to-library">
                        <a href="#" class="button button--red">
                          <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" class="mr-1" alt="">
                          დაამატე ფაილი ბიბლიოთეკაში</a>
                      </li> -->
                      <li class="panel">
                          <a href="{{ url('/' . app()->getLocale() . '/admin') }}">
                              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.084 12.8346V6.41797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.084 4.08464V1.16797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 12.8346V9.91797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7 7.58464V1.16797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.91602 12.8346V6.41797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M2.91602 4.08464V1.16797" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M1.75 6.41797H4.08333" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.91602 6.41797H12.2493" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M5.83398 7.58203H8.16732" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg>

                              <span>მართვის პანელი</span>
                          </a>
                      </li>
                      <!-- <b class="line line--inner mb-2 white"></b> -->
                  <!-- </div> -->
                  <li class="@if(!(isset($tab)) || isset($tab) && $tab=='password') active @endif tab-button-company">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.545 2.4625C9.81836 0.741667 7.01836 0.741667 5.30336 2.4625C4.09586 3.65833 3.73419 5.37917 4.20086 6.89583L1.45919 9.6375C1.26669 9.83583 1.13253 10.2267 1.17336 10.5067L1.34836 11.7783C1.41253 12.1983 1.80336 12.595 2.22336 12.6533L3.49502 12.8283C3.77502 12.8692 4.16586 12.7408 4.36419 12.5367L4.84253 12.0583C4.95919 11.9475 4.95919 11.7608 4.84253 11.6442L3.71086 10.5125C3.54169 10.3433 3.54169 10.0633 3.71086 9.89417C3.88003 9.725 4.16003 9.725 4.32919 9.89417L5.46669 11.0317C5.57753 11.1425 5.76419 11.1425 5.87502 11.0317L7.11169 9.80083C8.62252 10.2733 10.3434 9.90583 11.545 8.71C13.2659 6.98917 13.2659 4.18333 11.545 2.4625ZM8.45919 7.00083C7.65419 7.00083 7.00086 6.3475 7.00086 5.5425C7.00086 4.7375 7.65419 4.08417 8.45919 4.08417C9.26419 4.08417 9.91752 4.7375 9.91752 5.5425C9.91752 6.3475 9.26419 7.00083 8.45919 7.00083Z" fill="#000"/>
                    </svg>

                      <span>პაროლის ცვლილება</span>
                  </li>
                  @endif
                  <li class="@if(isset($tab) && $tab=='organizations' ) active @endif @if($guard == 'company') tab-button-company @endif">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.01004 1.45703C4.35504 1.45703 3.01004 2.80203 3.01004 4.45703V5.90203C3.01004 6.20703 2.88004 6.67203 2.72504 6.93203L2.15004 7.88703C1.79504 8.47703 2.04004 9.13203 2.69004 9.35203C4.84504 10.072 7.17004 10.072 9.32504 9.35203C9.93004 9.15203 10.195 8.43703 9.86504 7.88703L9.29004 6.93203C9.14004 6.67203 9.01004 6.20703 9.01004 5.90203V4.45703C9.01004 2.80703 7.66004 1.45703 6.01004 1.45703Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round"/>
                      <path d="M6.93496 1.59875C6.77996 1.55375 6.61996 1.51875 6.45496 1.49875C5.97496 1.43875 5.51496 1.47375 5.08496 1.59875C5.22996 1.22875 5.58996 0.96875 6.00996 0.96875C6.42996 0.96875 6.78996 1.22875 6.93496 1.59875Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M7.51001 9.53125C7.51001 10.3562 6.83501 11.0312 6.01001 11.0312C5.60001 11.0312 5.22001 10.8613 4.95001 10.5913C4.68001 10.3213 4.51001 9.94125 4.51001 9.53125" stroke="#000" stroke-width="0.875" stroke-miterlimit="10"/>
                    </svg>
                      <span>გამოწერილი ორგანიზაციები</span>
                  </li>
                  <li class="@if(isset($tab) && $tab=='categories' ) active @endif @if($guard == 'company') tab-button-company @endif">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2.5 5H3.5C4.5 5 5 4.5 5 3.5V2.5C5 1.5 4.5 1 3.5 1H2.5C1.5 1 1 1.5 1 2.5V3.5C1 4.5 1.5 5 2.5 5Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8.5 5H9.5C10.5 5 11 4.5 11 3.5V2.5C11 1.5 10.5 1 9.5 1H8.5C7.5 1 7 1.5 7 2.5V3.5C7 4.5 7.5 5 8.5 5Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M8.5 11H9.5C10.5 11 11 10.5 11 9.5V8.5C11 7.5 10.5 7 9.5 7H8.5C7.5 7 7 7.5 7 8.5V9.5C7 10.5 7.5 11 8.5 11Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M2.5 11H3.5C4.5 11 5 10.5 5 9.5V8.5C5 7.5 4.5 7 3.5 7H2.5C1.5 7 1 7.5 1 8.5V9.5C1 10.5 1.5 11 2.5 11Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                      <span>გამოწერილი კატეგორიები</span>
                  </li>
                  <li @if(isset($tab) && $tab=='fav-events' ) class="active" @endif>
                    <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6.31 9.40578C6.14 9.46578 5.86 9.46578 5.69 9.40578C4.24 8.91078 1 6.84578 1 3.34578C1 1.80078 2.245 0.550781 3.78 0.550781C4.69 0.550781 5.495 0.990781 6 1.67078C6.505 0.990781 7.315 0.550781 8.22 0.550781C9.755 0.550781 11 1.80078 11 3.34578C11 6.84578 7.76 8.91078 6.31 9.40578Z" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                      <span>რჩეული შესაძლებლობები</span>
                  </li>
                  <li @if(isset($tab) && $tab=='going-events' ) class="active" @endif>
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M6 6C7.38071 6 8.5 4.88071 8.5 3.5C8.5 2.11929 7.38071 1 6 1C4.61929 1 3.5 2.11929 3.5 3.5C3.5 4.88071 4.61929 6 6 6Z" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.60503 7.86855L7.83501 9.63856C7.76501 9.70856 7.70002 9.83855 7.68502 9.93355L7.59002 10.6085C7.55502 10.8535 7.72502 11.0235 7.97002 10.9885L8.64501 10.8935C8.74001 10.8785 8.87502 10.8135 8.94002 10.7435L10.71 8.97356C11.015 8.66856 11.16 8.31354 10.71 7.86354C10.265 7.41854 9.91003 7.56354 9.60503 7.86855Z" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M9.3501 8.125C9.5001 8.665 9.92008 9.08499 10.4601 9.23499" stroke="#000" stroke-width="0.875" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M1.70508 11C1.70508 9.065 3.63009 7.5 6.00009 7.5C6.52009 7.5 7.02008 7.575 7.48508 7.715" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                      <span>რაზე დავრეგისტრირდი</span>
                  </li>
                  <li @if(isset($tab) && $tab=='completed-events' ) class="active" @endif>
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8.25 4.75L6.15 6.85L5.35 5.65L3.75 7.25" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M7.25 4.75H8.25V5.75" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                      <path d="M4.5 11H7.5C10 11 11 10 11 7.5V4.5C11 2 10 1 7.5 1H4.5C2 1 1 2 1 4.5V7.5C1 10 2 11 4.5 11Z" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                      <span>დასრულებული შესაძლებლობები</span>
                  </li>
                  <b class="line line--inner light"></b>
                  <li class="pt-2">
                      <a href="{{ url('/' . app()->getLocale() . '/logout') }}">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M4.44995 3.77719C4.60495 1.97719 5.52995 1.24219 7.55495 1.24219H7.61995C9.85495 1.24219 10.75 2.13719 10.75 4.37219V7.63219C10.75 9.86719 9.85495 10.7622 7.61995 10.7622H7.55495C5.54495 10.7622 4.61995 10.0372 4.45495 8.26719" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M7.50006 6H1.81006" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                          <path d="M2.925 4.32422L1.25 5.99922L2.925 7.67422" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                          <span>გამოსვლა</span>
                      </a>
                  </li>

                  @if(($guard == 'web' && $user->company == 1) || $guard == 'company')
                  <div class="add-item-to-library">
                    <a href="{{ route('AddLibrary')  }}" class="button button--red">
                      <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" class="mr-1" alt="">
                      დაამატე ფაილი ბიბლიოთეკაში</a>
                  </div>
                  <div class="add-item-to-library youth-worker-add-opportunity">
                    <a href="{{ route('createOpportunity') }}" class="button button--red">
                      <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" class="mr-1" alt="">
                      დაამატე შესაძლებლობა</a>
                  </div>
                  @endif
              </ul>
            </div>
            <div class="profile__right">
                @if($guard == 'web')
                <div class="my-profile-tab user-profile blue-layout-md @if(!isset($tab)) active-lg @endif @if(isset($tab) && $tab=='private-info') active @endif">
                    <form action="/edit-user-info" method="POST" class="form-edit-user">
                        {{ csrf_field() }}
                        <input name="update_type" value="profile" hidden />
                        <div class="d-flex flex-wrap justify-content-between">
                            <div class="profile-tab-title">
                                <span>პირადი ინფორმაცია</span>
                            </div>
                            <div class="form__group ">
                                <input type="text" class="form__input" id="first-name" value="{{ $user->first_name }}" name="first_name" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                <label for="first-name" class="form__label">სახელი
                                    <span class="required">
                                        <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                    </span>
                                </label>
                                <div class="form__tooltip form__tooltip--error">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>აუცილებელი ველი</div>
                                </div>
                            </div>
                            <div class="form__group ">
                                <input type="text" class="form__input" id="last-name" value="{{ $user->last_name }}" name="last_name" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                <label for="last-name" class="form__label">გვარი
                                    <span class="required">
                                        <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                    </span>
                                </label>
                                <div class="form__tooltip form__tooltip--error">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>აუცილებელი ველი</div>
                                </div>
                            </div>
                            <div class="form__group ">
                                <input readonly type="text" class="form__input input-bg bdate" id="birth-date" value="@if($user->birth_date){{\Carbon\Carbon::parse($user->birth_date)->format('d.m.Y')}}@endif" name="birth_date" bg-url="url(/img/icons/bdate.svg)" bg-url-active="url(/img/icons/bdate-blue.svg)">
                                <label for="birth-date" class="form__label">დაბადების თარიღი</label>
                            </div>
                            <div class="form__group ">
                                <input type="text" class="form__input" id="private-number" maxlength="11" pattern="^[0-9]{11}|^$" value="{{ $user->private_number }}" name="private_number">
                                <label for="private-number" class="form__label">პირადი ნომერი</label>
                                <div class="form__tooltip form__tooltip--light">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>გთხოვთ მიუთითოთ 11 ნიშნა კოდი (გამოიყენეთ მხოლოდ ციფრები)</div>
                                </div>
                            </div>
                            <div class="form__group ">
                                <!-- <select disabled name="gender" id="gender" class="form__input input-bg" pattern="[a-zA-Z0-9]+|[ა-ჰ]|^$" bg-url="url(/img/icons/arrow-down-select.svg)" bg-url-active="url(/img/icons/arrow-down-select-blue.svg)">
                                        <option value=""></option>
                                        <option value="female" @if($user->gender == 'female') selected @endif>მდედრობითი</option>
                                        <option value="male" @if($user->gender == 'male') selected @endif>მამრობითი</option>
                                    </select> -->
                                <!-- <div class="custom-select"> -->
                                <!-- <select name="gender">
                                        <option value="">აირჩიეთ სქესი</option>
                                        <option value="female" @if($user->gender == 'female') selected @endif>მდედრობითი</option>
                                        <option value="male" @if($user->gender == 'male') selected @endif>მამრობითი</option>
                                    </select> -->
                                <input type="text" class="form__input" id="gender" value="{{$user->gender}}" name="gender">
                                <label for="gender" class="form__label">სქესი</label>
                                <!-- </div> -->
                                <!-- <label for="gender" class="form__label">სქესი</label> -->
                            </div>
                            <div class="form__group ">
                                <input type="tel" class="form__input" id="number" pattern="^[0-9]{9}|^$" value="{{ $user->phone }}" name="phone">
                                <label for="number" class="form__label">საკონტაქტო ნომერი</label>
                                <div class="form__tooltip form__tooltip--light">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>გთხოვთ მიუთითოთ 9 ნიშნა რიცხვი</div>
                                </div>
                            </div>
                            <div class="form__group">
                                <input type="email" class="form__input" id="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" value="{{ $user->email }}" name="email">
                                <label for="email" class="form__label">ელ. ფოსტა
                                    <span class="required">
                                        <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                    </span>
                                </label>
                                <div class="form__tooltip form__tooltip--light">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                                </div>
                            </div>
                            <div class="form__group empty-fields-message">
                              <p>შეავსეთ წითლად მონიშნული ველები რომ პროფილის ინფორმაცია იყოს სრულყოფილი</p>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <button class="button button--red">
                                <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                            </button>
                        </div>
                    </form>
                </div>
                <div class="my-profile-tab disabilities @if((isset($tab) && $tab=='disabilities') || (!isset($tab) && $guard == 'company')) active @endif">
                    <div class="profile-tab-title">
                        <span>მოკლედ ჩემ შესახებ</span>
                    </div>
                    <div class="user-info-boxes">
                        @foreach ($userDisabilities as $disability)
                        <div class="user-info-box {{$user->userDisabilities->contains($disability->id) ? 'active' : ''}}" data-id-value='{{$disability->id}}'>
                            <span>{{$disability->name}}</span>
                            <img src="{{ asset('/storage/' . $disability->getImagePath()) }}" alt="sign-lang" draggable="false">
                        </div>
                        @endforeach
                    </div>
                    <form action="/edit-user-info-disabilities" method="POST" class="edit-user-disabilities">
                        @csrf

                        <div class="user-disablities-wrapper">
                            <div class="firago firago--normal firago--sm my-profile-title">გაქვთ თუ არა რაიმე ტიპის შეზღუდვა</div>
                            @foreach ($userDisabilities as $disability)
                            <div class="user-disability disability ">
                                <label class="checkbox-container">
                                    <input name="disabilities[]" type="checkbox" value="{{$disability->id}}" {{$user->userDisabilities->contains($disability->id) ? 'checked' : ''}}>
                                    <div class="firago firago--normal firago--sm">{{$disability->name}}</div>
                                    <span class="checkmark"></span>
                                </label>

                                <div class="disability-details">
                                    <label for="disability-{{$disability->id}}" class="firago firago--normal firago--sm">დააზუსტეთ შეზღუდვა</label>
                                    <div class="form__group form__group--half">
                                        <input id="disability-{{$disability->id}}" disabled autocomplete="off" type="text" class="form__input" placeholder="ფიზიკური შეზღუდვის ტიპი">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="user-disability no-disability mt-1">
                                <label class="checkbox-container">
                                    <input type="checkbox" value="0" {{(!$user->userDisabilities || sizeof($user->userDisabilities) == 0) ? 'checked' : ''}}>
                                    <div class="firago firago--normal firago--sm">არ მაქვს შეზღუდვა</div>
                                    <span class="checkmark radio"></span>
                                </label>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <button class="button button--red">
                                <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                            </button>
                        </div>
                    </form>
                </div>
                <!-- <div class="my-profile-tab occupation @if((isset($tab) && $tab=='occupation') || (!isset($tab) && $guard == 'company')) active @endif">
                    <div class="profile-tab-title">
                        <span>მიმდინარე საქმიანობა</span>
                    </div>
                    <div class="user-info-boxes occupation">
                        <div class="user-info-box user-studying {{$user->userOcupationStudy ? 'active' : ''}}">
                            <span>{{$user->userOcupationStudy ? $user->userOcupationStudy->name : ''}} </span>
                        </div>
                        <div class="user-info-box user-working {{$user->userOcupationWork ? 'active' : ''}}">
                            <span>{{$user->userOcupationWork ? $user->userOcupationWork->name : ''}}</span>
                        </div>
                        <div class="user-info-box user-i-am {{$user->userOccupation ? 'active' : ''}}">
                            <span>{{$user->userOccupation ? $user->userOccupation->name : ''}}</span>
                        </div>
                        <div class="user-info-box user-other {{$user->ocupation_description ? 'active' : ''}}">
                            <span>{{$user->ocupation_description ? $user->ocupation_description : ''}}</span>
                        </div>
                    </div>
                    <div class="occupation-wrapper">
                        <div class="firago firago--normal firago--sm mb-4 my-profile-title">თქვენი მიმდინარე საქმიანობა <span class="additional-info firago--xs">
                                <img src="{{ asset('img/icons/info-white.svg') }}" alt="info" draggable="false">
                                <span>დასაშვებია რამდენიმე პასუხის არჩევა</span>
                            </span>
                        </div>
                        <form action="edit-user-info-occupations" method="POST" class="occupation-form">
                            @csrf
                            <div class="address-dropdowns">
                                <div class="form__group form__group--dropdown mb-3">
                                    <div class="firago firago--normal firago--sm">ვსწავლობ</div>
                                    <div class="input-wrapper">
                                        @if ($user->userOcupationStudy)
                                        <input value="{{$user->userOcupationStudy->name}}" disabled type="text" class="form__input readonly" placeholder="აირჩიეთ განათლება" readonly>
                                        @else
                                        <input disabled type="text" class="form__input readonly" placeholder="აირჩიეთ განათლება" readonly>
                                        @endif
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                    <div class="dropdown-right dropdown-regions select-studying active">
                                        <div class="dropdown-right__content">
                                            @foreach ($userOcupationStudy as $study)
                                            <label class="no-checkmark radio {{$user->userOcupationStudy && $user->userOcupationStudy->id == $study->id ? 'active' : ''}} ">
                                                <input name='userOcupationStudy' {{$user->userOcupationStudy && $user->userOcupationStudy->id == $study->id ? "checked" : ""}}type="radio" value="{{$study->id}}">
                                                <span>{{$study->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form__group form__group--dropdown mb-3">
                                    <div class="firago firago--normal firago--sm">ვმუშაობ</div>
                                    <div class="input-wrapper">
                                        @if ($user->userOcupationWork)
                                        <input value="{{$user->userOcupationWork->name}}" disabled type="text" class="form__input readonly" placeholder="აირჩიეთ" readonly>
                                        @else
                                        <input disabled type="text" class="form__input readonly" placeholder="აირჩიეთ" readonly>
                                        @endif
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                    <div class="dropdown-right dropdown-regions select-working active">
                                        <div class="dropdown-right__content">
                                            @foreach ($userOcupationWork as $work)
                                            <label class="no-checkmark radio" {{$user->userOcupationWork && $user->userOcupationWork->id == $work->id ? "active" : ""}}>
                                                <input name='userOcupationWork' {{$user->userOcupationWork && $user->userOcupationWork->id == $work->id ? "checked" : ""}} type="radio" value="{{$work->id}}">
                                                <span>{{$work->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="form__group form__group--dropdown mb-3">
                                    <div class="firago firago--normal firago--sm">ვარ</div>
                                    <div class="input-wrapper">
                                        @if ($user->userOccupation)
                                        <input value="{{$user->userOccupation->name}}" disabled type="text" class="form__input readonly" placeholder="აირჩიეთ" readonly>
                                        @else
                                        <input disabled type="text" class="form__input readonly" placeholder="აირჩიეთ" readonly>
                                        @endif
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                    <div class="dropdown-right dropdown-regions select-i-am active">
                                        <div class="dropdown-right__content">
                                            @foreach ($userOccupation as $occupation)
                                            <label class="no-checkmark radio" {{$user->userOccupation && $user->userOccupation->id == $work->id ? "active" : ""}}>
                                                <input name="userOccupation" {{$user->userOccupation && $user->userOccupation->id == $work->id ? "checked" : ""}} type="radio" value="{{$occupation->id}}">
                                                <span>{{$occupation->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="other-education select-other">
                                    <div class="firago firago--normal firago--sm">სხვა</div>
                                    <div class="form__group form__group--half">
                                        @if ($user->ocupation_description)
                                        <input value="{{$user->ocupation_description}}" name="ocupation_description" autocomplete="off" type="text" maxlength="58" class="form__input" placeholder="ჩაწერეთ თქვენი საქმიანობის შესახებ">
                                        @else
                                        <input name="ocupation_description" autocomplete="off" type="text" maxlength="58" class="form__input" placeholder="ჩაწერეთ თქვენი საქმიანობის შესახებ">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="button-wrapper">
                                <button class="button button--red">
                                    <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div> -->
                <div class="my-profile-tab education @if((isset($tab) && $tab=='education') || (!isset($tab) && $guard == 'company')) active @endif">
                    <div class="profile-tab-title">
                        <span>განათლება</span>
                    </div>
                    <div class="user-info-boxes education">
                        <div class="user-info-box user-education {{$user->userEducations && sizeof($user->userEducations) > 0 ? 'active' : ''}}">
                            <span>{{$user->userEducations && sizeof($user->userEducations) > 0 ? $user->userEducations[0]->name: ''}} </span>
                        </div>
                        <div class="user-info-box user-other {{$user->currently_studying ? 'active' : ''}}">
                            <span>{{$user->currently_studying ? $user->currently_studying : ''}} </span>
                        </div>
                    </div>
                    <div class="occupation-wrapper education-wrapper">
                        <div class="firago firago--normal firago--sm mb-4 my-profile-title">რა განათლება გაქვთ მიღებული?</div>
                        <form action="/edit-user-info-education" method="POST" class="user-education-form">
                            @csrf
                            <div class="address-dropdowns">
                                <div class="form__group form__group--dropdown mb-3">
                                    <div class="firago firago--normal firago--sm">თქვენი განათლება</div>
                                    <div class="input-wrapper">

                                        @if ($user->userEducations && sizeof($user->userEducations)>0)
                                        <input value="{{$user->userEducations[0]->name}}" disabled type="text" class="form__input readonly" placeholder="აირჩიეთ განათლება" readonly>
                                        @else
                                        <input disabled type="text" class="form__input readonly" placeholder="აირჩიეთ განათლება" readonly>
                                        @endif
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                    <div class="dropdown-right dropdown-regions select-education active">
                                        <div class="dropdown-right__content">
                                            @foreach ($userEducation as $education)
                                            <label class="no-checkmark radio {{$user->userEducations && sizeof($user->userEducations)>0 && $user->userEducations[0]->id == $education->id? 'active' : ''}}">
                                                <input {{$user->userEducations && sizeof($user->userEducations)>0 && $user->userEducations[0]->id == $education->id? "checked" : ""}} name="education_id" type="radio" value="{{$education->id}}">
                                                <span>{{$education->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="other-education select-other">
                                    <div class="firago firago--normal firago--sm">ჯერ კიდევ ვსწავლობ</div>
                                    <div class="form__group form__group--half">
                                        @if ($user->currently_studying)
                                        <input value="{{$user->currently_studying}}" name="user_education_description" autocomplete="off" type="text" maxlength="58" class="form__input" placeholder="სკოლა, პროფესიული, უმაღლესი">
                                        @else
                                        <input name="user_education_description" autocomplete="off" type="text" maxlength="58" class="form__input" placeholder="სკოლა, პროფესიული, უმაღლესი">
                                        @endif
                                    </div>
                                </div>

                                <div class="user-disability no-disability mt-5">
                                    <label class="checkbox-container">
                                        <input name="no_study" type="checkbox" value="true" {{(!$user->userEducations || (sizeof($user->userEducations)==0)) && (!$user->currently_studying) ? "checked" :""  }}>
                                        <div class="firago firago--normal firago--sm">არანაირი განათლება არ მაქვს მიღებული</div>
                                        <span class="checkmark radio"></span>
                                    </label>
                                </div>
                            </div>
                            <div class="button-wrapper">
                                <button class="button button--red">
                                    <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                    <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="my-profile-tab address @if((isset($tab) && $tab=='address') || (!isset($tab) && $guard == 'company')) active @endif">
                    <div class="profile-tab-title">
                        <span>საცხოვრებელი ადგილი</span>
                    </div>
                    <div class="user-info-boxes">
                        @if($user->place_of_residence)
                        <div class="user-info-box user-region {{$residence->region ? 'active' : ''}}">
                            <span>{{$residence->region ? $residence->region->name : ""}}</span>
                        </div>
                        <div class="user-info-box user-municipality {{$residence->municipality ? 'active' : ''}}">
                            <span>{{$residence->municipality ? $residence->municipality->name : ""}}</span>
                        </div>
                        <div class="user-info-box user-other user-exact-address {{$residence->address_text && $residence->is_georgia ? 'active' : ''}}">
                            <span>{{$residence->address_text && $residence->is_georgia ? $residence->address_text : ""}}</span>
                        </div>
                        <div class="user-info-box user-other user-foreign-address {{$residence->address_text && !$residence->is_georgia ? 'active' : ''}}">
                            <span>{{$residence->address_text && !$residence->is_georgia ? $residence->address_text : ""}}</span>
                        </div>
                        @endif
                    </div>
                    <form action="/edit-user-info-residence" method="POST" class="user-address-form">
                        @csrf
                        <div class="wizard__tab wizard__tab--registration-place">
                            <div class="left country">
                                <div class="firago firago--normal firago--sm my-profile-title">მომხმარებლის საცხოვრებელი ადგილი</div>
                                <label class="checkbox-container">
                                    <input type="radio" name="is_georgia" value="1" {{($residence && !$residence->is_georgia) ? "":"checked"}}>
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--normal firago--sm">საქართველო</div>
                                </label>
                                <label class="checkbox-container">
                                    <input type="radio" name="is_georgia" value="0" {{$residence && !$residence->is_georgia ? "checked":""}}>
                                    <input type="hidden" name="region_id" value="">
                                    <input type="hidden" name="municipality_id" value="">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--normal firago--sm">სხვა</div>
                                </label>
                                <div class="form__group {{$residence && !$residence->is_georgia ? '':'disabled'}} mt-5 select-other select-foreign-address">
                                    @if ($residence && !$residence->is_georgia && $residence->address_text)
                                    <input value="{{$residence->address_text}}" type="text" class="form__input" id="foreign-address" name="address_text" {{$residence && !$residence->is_georgia ? "":"disabled"}}>
                                    @else
                                    <input type="text" class="form__input" id="foreign-address" name="address_text" {{$residence && !$residence->is_georgia ? "":"disabled"}}>
                                    @endif
                                    <label for="foreign-address" class="form__label">ქვეყანა, ქალაქი, მისამართი</label>
                                </div>
                            </div>
                            <div class="right address-dropdowns {{$residence && !$residence->is_georgia ? '':'active'}}">
                                <div class="inputs">
                                    <div class="form__group form__group--dropdown linked">
                                        <div class="firago firago--normal firago--sm">რეგიონი</div>
                                        <div class="dropdown-right-trigger">
                                            @if ($residence && $residence->region)
                                            <input value="{{$residence->region->name}}" type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ რეგიონი" readonly disabled>
                                            @else
                                            <input type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ რეგიონი" readonly disabled>
                                            @endif
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions select-region active selected">
                                            <div class="dropdown-right__content">
                                                @foreach ($regions as $region)
                                                <label class="no-checkmark radio {{$residence->region && $residence->region_id == $region->id ? 'active' : ''}}">
                                                    <input {{$residence->region && $residence->region_id == $region->id ? "checked" : ""}} type="radio" name="region_id" value="{{$region->id}}">
                                                    <span>{{$region->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group form__group--dropdown {{$residence && $residence->region ? '' : 'disabled' }} select-municipality linked">
                                        <div class="firago firago--normal firago--sm">მუნიციპალიტეტი</div>
                                        <div class="dropdown-right-trigger">
                                            @if ($residence->municipality_id)
                                            <input value="{{$residence->municipality->name}}" type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ მუნიციპალიტეტი" readonly disabled>
                                            @else
                                            <input type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ მუნიციპალიტეტი" readonly disabled>
                                            @endif
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        @foreach ($regions as $region)
                                        <div class="dropdown-right dropdown-regions {{$residence && $residence->region_id == $region->id ? 'selected' : ''}}" data-region-id="{{$region->id}}">
                                            <div class="dropdown-right__content">
                                                @foreach ($region->municipalities as $municipality)
                                                <label class="no-checkmark radio  {{$residence->municipality && $residence->municipality_id == $municipality->id ? 'active' : ''}}">
                                                    <input {{$residence->municipality && $residence->municipality_id == $municipality->id ? "checked" : ""}} type="radio" name="municipality_id" value="{{$municipality->id}}">
                                                    <span>{{$municipality->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="form__group {{$residence && $residence->municipality ? '' : 'disabled' }} select-exact-address select-other">
                                    <div class="firago firago--normal firago--sm">ქალაქი ან სოფელი</div>
                                    @if ($residence && $residence->address_text)
                                    <input value="{{$residence->address_text}}" type="text" class="form__input user-input" name="address_text" disabled>
                                    @else
                                    <input type="text" class="form__input user-input" name="address_text" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="button-wrapper">
                            <button class="button button--red">
                                <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                            </button>
                        </div>
                    </form>
                </div>
            <!--</div>-->
                <div class="my-profile-tab blue-layout-md password @if((isset($tab) && $tab=='password') || (!isset($tab) && $guard == 'company')) active @endif">
                    <div class="profile-tab-title">
                        <span>პაროლის ცვლილება</span>
                    </div>
                    <div class="my-profile-title firago firago--normal firago--sm">პაროლის ცვლილება</div>
                    <form action="/edit-user-password" method="POST" class="edit-user-password">
                        {{ csrf_field() }}
                        <div class="form__group ">
                            <input type="password" class="form__input" id="old-password" name="old_password">
                            <label for="old-password" class="form__label">მიმდინარე პაროლი</label>
                            <div class="password-visible">
                                <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                            </div>
                            <div class="form__tooltip form__tooltip--error">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>მიმდინარე პაროლი არასწორია</div>
                            </div>
                        </div>
                        <div class="form__group ">
                            <input type="password" class="form__input" id="password" name="password" pattern=".{8,}">
                            <label for="password" class="form__label">ახალი პაროლი</label>
                            <div class="password-visible">
                                <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                            </div>
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>
                            </div>
                        </div>
                        <div class="form__group">
                            <input type="password" class="form__input" id="password_confirmation" name="password_confirmation" pattern=".{8,}">
                            <label for="password_confirmation" class="form__label">გაიმეორეთ ახალი პაროლი</label>
                            <div class="password-visible">
                                <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                            </div>
                            <div class="form__tooltip form__tooltip--error">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>პაროლები არ ემთხვევა</div>
                            </div>
                        </div>

                        @if($errors->any())
                        <div class="warning warning--md visible" style="width: 100%">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>{{ trans($errors->first()) }}</div>
                        </div>
                        @endif

                        <div class="button-wrapper">
                            <button class="button button--red">
                                <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                            </button>
                        </div>
                    </form>
                </div>
                @else
                <div></div>
                @endif
                <div class="profile-tabs">
                    @if($guard == 'company')
                    <div class="profile-tab my-profile-tab blue-layout-md password @if(!isset($tab)) active-lg @endif @if(isset($tab) && $tab=='password')) active @endif">
                        <div class="profile-tab-title">
                            <span>პაროლის ცვლილება</span>
                        </div>
                        <div class="my-profile-title firago firago--normal firago--sm">პაროლის ცვლილება</div>
                        <form action="/edit-user-password" method="POST" class="edit-company-password">
                            {{ csrf_field() }}
                            <div class="form__group ">
                                <input type="password" class="form__input" id="old-password" name="old_password">
                                <label for="old-password" class="form__label">მიმდინარე პაროლი</label>
                                <div class="password-visible">
                                    <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                </div>
                                <div class="form__tooltip form__tooltip--error">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>მიმდინარე პაროლი არასწორია</div>
                                </div>
                            </div>
                            <div class="form__group ">
                                <input type="password" class="form__input" id="password" name="password" pattern=".{8,}">
                                <label for="password" class="form__label">ახალი პაროლი</label>
                                <div class="password-visible">
                                    <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                </div>
                                <div class="form__tooltip form__tooltip--light">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>
                                </div>
                            </div>
                            <div class="form__group ">
                                <input type="password" class="form__input" id="password_confirmation" name="password_confirmation" pattern=".{8,}">
                                <label for="password_confirmation" class="form__label">გაიმეორეთ ახალი პაროლი</label>
                                <div class="password-visible">
                                    <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                </div>
                                <div class="form__tooltip form__tooltip--error">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div>პაროლები არ ემთხვევა</div>
                                </div>
                            </div>

                            @if($errors->any())
                            <div class="warning warning--md visible" style="width: 100%">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>{{ trans($errors->first()) }}</div>
                            </div>
                            @endif

                            <div class="button-wrapper">
                                <button class="button button--red">
                                    <span class="d-inline-block save-text">ცვლილებების შენახვა</span>
                                    <!-- <img src="{{ asset('img/icons/edit-icon-profile.svg') }}" alt="edit" class="d-inline-block ml-2"> -->
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                    <div class="profile-tab subscribed-organizations blue-layout-md @if(isset($tab) && $tab == 'organizations') active @endif">
                        <div class="profile-tab-title">
                            <span>გამოწერილი ორგანიზაციები</span>
                        </div>
                        @if(count($userCompanies) == 0)
                        <div class="firago firago--md">შენ არ გაქვს გამოწერილი არც ერთი ორგანიზაცია</div>
                        @endif
                        <div class="profile-grid">
                            @foreach($userCompanies as $company)
                            <div class="subscibed-organization bordered-container" href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}">
                                <div class="organization-img">
                                    <img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img">
                                </div>
                                <div class="organization-title">
                                    <h4 class="heading heading--md mb-1 ">{{ $company->name }}</h4>
                                    <div class="subs-amount">{{ $company->users_count + $company->subscriberCompanies_count }} გამომწერი</div>
                                </div>
                                <div class="delete subs-delete" data-company-id="{{ $company->id }}">
                                    <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                    <div class="subs-delete__img"><img src="{{ asset('img/icons/close-img-new.svg') }}" alt="delete"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($companyCount > $companiesPerPage)
                        <nav class="pagination-container profile-pagination" url="/ajax-load-more-subscribed-companies" page="1" number-per-page="{{$companiesPerPage}}">

                            @if($companyCount)
                            <ul class="pagination">
                                <li class="page-item prev disabled">
                                    <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                $companiesNumPages = intval($companyCount/$companiesPerPage);
                                if($companyCount%$companiesPerPage > 0) {
                                $companiesNumPages += 1;
                                }
                                @endphp
                                @for($i = 1; $i <= $companiesNumPages; $i++) <li class="page-item @if($i == 1) active @endif @if($i == $companiesNumPages) last @endif">
                                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                                    </li>
                                    @endfor
                                    <li class="page-item next @if($companiesNumPages == 1) disabled @endif">
                                        <p class="page-link" data-new-page="{{ 2 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
                                    </li>
                            </ul>
                            @endif
                        </nav>
                        @endif
                    </div>

                    <div class="profile-tab subscribed-categories blue-layout-md @if(isset($tab) && $tab == 'categories') active @endif">
                        <div class="profile-tab-title">
                            <svg viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.5 10H10V7.5H7.5V10ZM7.5 6.25H10V3.75H7.5V6.25ZM3.75 2.5H6.25V0H3.75V2.5ZM7.5 2.5H10V0H7.5V2.5ZM3.75 6.25H6.25V3.75H3.75V6.25ZM0 6.25H2.5V3.75H0V6.25ZM0 10H2.5V7.5H0V10ZM3.75 10H6.25V7.5H3.75V10ZM0 2.5H2.5V0H0V2.5Z" fill="white" />
                            </svg>
                            <span>გამოწერილი კატეგორიები</span>
                        </div>
                        @if(count($categories) == 0)
                        <div class="firago firago--md">შენ არ გაქვს გამოწერილი არც ერთი კატეგორია</div>
                        @endif
                        <div class="profile-grid">
                            @foreach($categories as $category)
                            <div class="subscibed-category" href="{{ url('/' . app()->getLocale() . '/category/' . $category->id) }}">
                                <div class="title">{{ $category->name }}</div>
                                <div class="d-flex align-items-center">
                                    <div class="amount">{{ $category->getOpportunityCount() }}</div>
                                    <div class="opp">შესაძლებლობა</div>
                                </div>
                                <div class="delete subs-delete" data-category-id="{{ $category->id }}">
                                    <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                    <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($categoryCount > $categoriesPerPage)
                        <nav class="pagination-container profile-pagination" url="/ajax-load-more-subscribed-categories" page="1" number-per-page="{{$categoriesPerPage}}">
                            @if($categoryCount)
                            <ul class="pagination">
                                <li class="page-item prev disabled">
                                    <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                $categoriesNumPages = intval($categoryCount/$categoriesPerPage);
                                if($categoryCount%$categoriesPerPage > 0) {
                                $categoriesNumPages += 1;
                                }
                                @endphp
                                @for($i = 1; $i <= $categoriesNumPages; $i++) <li class="page-item @if($i == 1) active @endif @if($i == $categoriesNumPages) last @endif">
                                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                                    </li>
                                    @endfor
                                    <li class="page-item next @if($categoriesNumPages == 1) disabled @endif">
                                        <p class="page-link" data-new-page="{{ 2 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
                                    </li>
                            </ul>
                            @endif
                        </nav>
                        @endif
                    </div>
                    @if($favoriteOpportunities)
                    <div class="profile-tab favorite-opportunities profile-tab-events fav-events blue-layout-md @if(isset($tab) && $tab == 'fav-events') active @endif">
                        <div class="profile-tab-title">
                            <svg viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.99904 10.5L5.20154 9.78068C2.36903 7.23571 0.499023 5.55179 0.499023 3.49728C0.499023 1.81336 1.83003 0.5 3.52403 0.5C4.48103 0.5 5.39954 0.941418 5.99904 1.63352C6.59854 0.941418 7.51704 0.5 8.47405 0.5C10.1681 0.5 11.4991 1.81336 11.4991 3.49728C11.4991 5.55179 9.62905 7.23571 6.79654 9.78068L5.99904 10.5Z" fill="white" />
                            </svg>
                            <span>რჩეული შესაძლებლობები</span>
                        </div>
                        @if(count($favoriteOpportunities) == 0)
                        <div class="firago firago--md">შენ არ გაქვს რჩეული შესაძლებლობები</div>
                        @endif
                        <div class="profile-events events">
                            @foreach($favoriteOpportunities as $opportunity)

                            <div class="single-card">

                              <a class="card-image-wrapper" href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                  <div class="card-img" style="background-image: url({{ asset('/storage/' . $opportunity -> getImagePath()) }})"></div>
                              </a>
                              <div class="card-info">
                                  <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                      <div class="info-title" title="{{ $opportunity->name }}">
                                              {{ $opportunity->name }}
                                      </div>
                                  </a>
                                  <div class="d-flex align-items-start justify-content-between card-info-add-block">
                                    @if(is_null($opportunity->company_id))
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->user->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name }}">
                                                {{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name }}
                                            </div>
                                        </div>
                                    @else
                                    <a class="card-info-and-fav" href="{!! route('organization', ['id' => $opportunity->company->id]) !!}">
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->company->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->company->name }}">
                                                {{ $opportunity->company->name }}
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                    <div action="{{ $opportunity->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($opportunity -> favorite) selected @endif" data-opportunity-id="{{ $opportunity->id }}">
                                        @include('svg.heart-black')
                                    </div>

                                  </div>
                                  <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                                    <div class="location-wrapper">
                                        <div class="icon-pin">
                                            @include('svg.location-marker')
                                        </div>
                                        <div class="info-location">
                                            @if($opportunity->address)
                                            {!! $opportunity->address !!}
                                            @else
                                            <div>ონლაინ ღონისძიება</div>
                                            @endif
                                        </div>
                                    </div>

                                      <div class="d-flex align-items-center justify-content-center info-date">{{ $opportunity->getDateString() }}</div>

                                  </div>

                              </div>
                            </div>

                            @endforeach
                        </div>
                        @if($favoriteOpportunitiesCount > $favoriteOpportunitiesPerPage)
                        <nav class="pagination-container profile-pagination" url="/ajax-load-more-favorites" page="1" number-per-page="{{$finishedOpportunitiesPerPage}}">
                            @if($favoriteOpportunitiesCount)
                            <ul class="pagination">
                                <li class="page-item prev disabled">
                                    <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                $favoritesNumPages = intval($favoriteOpportunitiesCount/$favoriteOpportunitiesPerPage);
                                if($favoriteOpportunitiesCount%$favoriteOpportunitiesPerPage > 0) {
                                $favoritesNumPages += 1;
                                }
                                @endphp
                                @for($i = 1; $i <= $favoritesNumPages; $i++) <li class="page-item @if($i == 1) active @endif @if($i == $favoritesNumPages) last @endif">
                                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                                    </li>
                                    @endfor
                                    <li class="page-item next @if($favoritesNumPages == 1) disabled @endif">
                                        <p class="page-link" data-new-page="{{ 2 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
                                    </li>
                            </ul>
                            @endif
                        </nav>
                        @endif
                    </div>
                    @endif
                    @if($goingOpportunities)
                    <div class="profile-tab going-opportunities profile-tab-events going-events blue-layout-md @if(isset($tab) && $tab == 'going-events') active @endif">
                        <div class="profile-tab-title">
                            <svg viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.99904 10.5L5.20154 9.78068C2.36903 7.23571 0.499023 5.55179 0.499023 3.49728C0.499023 1.81336 1.83003 0.5 3.52403 0.5C4.48103 0.5 5.39954 0.941418 5.99904 1.63352C6.59854 0.941418 7.51704 0.5 8.47405 0.5C10.1681 0.5 11.4991 1.81336 11.4991 3.49728C11.4991 5.55179 9.62905 7.23571 6.79654 9.78068L5.99904 10.5Z" fill="white" />
                            </svg>
                            <span>რაზე დავრეგისტრირდი</span>
                        </div>
                        @if(count($goingOpportunities) == 0)
                        <!-- <div class="firago firago--md">შენ არ ხარ დარეგისტრირებული შესაძლებლობებზე</div> -->

                        @endif
                        <div class="profile-events events">
                            @foreach($goingOpportunities as $opportunity)
                            <!-- <div class="event event--light">
                                <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__img">
                                    <img src="{{ url('/storage/' . $opportunity->getImagePath()) }}" alt="eventimg">
                                </a>
                                <div class="event__bottom">
                                    <div class="event__date">{!!$opportunity->getDateString()!!}</div>
                                    <div class="event__desc">
                                        <div class="top">
                                            <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__title">
                                                <h3>{{$opportunity->name}}</h3>
                                            </a>
                                            @if($opportunity->company)
                                            <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__host">
                                                <h4>{{$opportunity->company->name}}</h4>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="single-card">

                              <a class="card-image-wrapper" href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                  <div class="card-img" style="background-image: url({{ asset('/storage/' . $opportunity -> getImagePath()) }})"></div>
                              </a>
                              <div class="card-info">
                                  <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                      <div class="info-title" title="{{ $opportunity->name }}">
                                              {{ $opportunity->name }}
                                      </div>
                                  </a>
                                  <div class="d-flex align-items-start justify-content-between card-info-add-block">
                                    @if(is_null($opportunity->company_id))
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->user->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->user->first_name }}">
                                                {{ $opportunity->user->first_name }}
                                            </div>
                                        </div>
                                    @else
                                    <a class="card-info-and-fav" href="{!! route('organization', ['id' => $opportunity->company->id]) !!}">
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->company->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->company->name }}">
                                                {{ $opportunity->company->name }}
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                    <div action="{{ $opportunity->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($opportunity -> favorite) selected @endif" data-opportunity-id="{{ $opportunity->id }}">
                                        @include('svg.heart-black')
                                    </div>

                                  </div>
                                  <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                                    <div class="location-wrapper">
                                        <div class="icon-pin">
                                            @include('svg.location-marker')
                                        </div>
                                        <div class="info-location">
                                            @if($opportunity->address)
                                            {!! $opportunity->address !!}
                                            @else
                                            <div>ონლაინ ღონისძიება</div>
                                            @endif
                                        </div>
                                    </div>

                                      <div class="d-flex align-items-center justify-content-center info-date">{{ $opportunity->getDateString() }}</div>

                                  </div>

                              </div>
                            </div>
                            @endforeach
                        </div>
                        @if($goingOpportunitiesCount > $goingOpportunitiesPerPage)
                        <nav class="pagination-container profile-pagination" url="/ajax-load-more-goings" page="1" number-per-page="{{$goingOpportunitiesPerPage}}">
                            <ul class="pagination profile-pagination">
                                <li class="page-item prev disabled">
                                    <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                $goingsNumPages = intval($goingOpportunitiesCount/$goingOpportunitiesPerPage);
                                if($goingOpportunitiesCount%$goingOpportunitiesPerPage > 0) {
                                $goingsNumPages += 1;
                                }
                                @endphp
                                @for($i = 1; $i <= $goingsNumPages; $i++) <li class="page-item @if($i == 1) active @endif @if($i == $goingsNumPages) last @endif">
                                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                                    </li>
                                    @endfor
                                    <li class="page-item next @if($goingsNumPages == 1) disabled @endif">
                                        <p class="page-link" data-new-page="{{ 2 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
                                    </li>
                            </ul>
                        </nav>
                        @endif
                    </div>
                    @endif
                    @if($finishedOpportunities)
                    <div class="profile-tab finished-opportunities profile-tab-events completed-events blue-layout-md @if(isset($tab) && $tab == 'completed-events') active @endif">
                        <div class="profile-tab-title">
                            <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.49444 4.83865L2.63889 5.69421L5.38889 8.44421L11.5 2.33309L10.6444 1.47754L5.38889 6.73309L3.49444 4.83865ZM10.2778 10.2778H1.72222V1.72222H7.83333V0.5H1.72222C1.05 0.5 0.5 1.05 0.5 1.72222V10.2778C0.5 10.95 1.05 11.5 1.72222 11.5H10.2778C10.95 11.5 11.5 10.95 11.5 10.2778V5.38889H10.2778V10.2778Z" fill="white" />
                            </svg>
                            <span>დასრულებული შესაძლებლობები</span>
                        </div>
                        @if(count($finishedOpportunities) == 0)
                        <div class="firago firago--md">დასრულებული შესაძლებლობები არ მოიძებნა</div>
                        @endif
                        <div class="profile-events events">
                            @foreach($finishedOpportunities as $opportunity)
                            <!-- <div class="event event--light">
                                <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__img">
                                    <img src="{{ url('/storage/' . $opportunity->getImagePath()) }}" alt="eventimg">
                                </a>
                                <div class="event__bottom">
                                    <div class="event__date">{!!$opportunity->getDateString()!!}</div>
                                    <div class="event__desc">
                                        <div class="top">
                                            <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__title">
                                                <h3>{{$opportunity->name}}</h3>
                                            </a>
                                            @if($opportunity->company)
                                            <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__host">
                                                <h4>{{$opportunity->company->name}}</h4>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="single-card">

                              <a class="card-image-wrapper" href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                  <div class="card-img" style="background-image: url({{ asset('/storage/' . $opportunity -> getImagePath()) }})"></div>
                              </a>
                              <div class="card-info">
                                  <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}">
                                      <div class="info-title" title="{{ $opportunity->name }}">
                                              {{ $opportunity->name }}
                                      </div>
                                  </a>
                                  <div class="d-flex align-items-start justify-content-between card-info-add-block">
                                    
                                    @if(is_null($opportunity->company_id))
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->user->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name }}">
                                                {{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name }}
                                            </div>
                                        </div>
                                    @else
                                    <a class="card-info-and-fav" href="{!! route('organization', ['id' => $opportunity->company->id]) !!}">
                                        <div class="info-company">
                                            <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->company->getImagePath()) }})"></div>
                                            <div class="company-name" title="{{ $opportunity->company->name }}">
                                                {{ $opportunity->company->name }}
                                            </div>
                                        </div>
                                    </a>
                                    @endif
                                    <div action="{{ $opportunity->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($opportunity -> favorite) selected @endif" data-opportunity-id="{{ $opportunity->id }}">
                                        @include('svg.heart-black')
                                    </div>

                                  </div>
                                  <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                                    <div class="location-wrapper">
                                        <div class="icon-pin">
                                            @include('svg.location-marker')
                                        </div>
                                        <div class="info-location">
                                            @if($opportunity->address)
                                            {!! $opportunity->address !!}
                                            @else
                                            <div>ონლაინ ღონისძიება</div>
                                            @endif
                                        </div>
                                    </div>

                                      <div class="d-flex align-items-center justify-content-center info-date">{{ $opportunity->getDateString() }}</div>

                                  </div>

                              </div>
                            </div>
                            @endforeach
                        </div>
                        @if($finishedOpportunitiesCount > $finishedOpportunitiesPerPage)
                        <nav class="pagination-container profile-pagination" url="/ajax-load-more-finished" page="1" number-per-page="{{$finishedOpportunitiesPerPage}}">
                            <ul class="pagination profile-pagination">
                                <li class="page-item prev disabled">
                                    <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                $finishedsNumPages = intval($finishedOpportunitiesCount/$finishedOpportunitiesPerPage);
                                if($finishedOpportunitiesCount%$finishedOpportunitiesPerPage > 0) {
                                $finishedsNumPages += 1;
                                }
                                @endphp
                                @for($i = 1; $i <= $finishedsNumPages; $i++) <li class="page-item @if($i == 1) active @endif @if($i == $finishedsNumPages) last @endif">
                                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                                    </li>
                                    @endfor
                                    <li class="page-item next @if($finishedsNumPages == 1) disabled @endif">
                                        <p class="page-link" data-new-page="{{ 2 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
                                    </li>
                            </ul>
                        </nav>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- </div> -->
    </div>
</div>

@endsection
