@extends('layouts.master')

@section('content')
@php
    $tabName= request()->input('tab')
@endphp 

<!-- <div class="popup popup-profile-pic">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="popup__close d-flex align-items-center">
            <span class="firago firago--normal firago--smm firago--dark mr-1">დახურვა</span>
            <img src="{{ asset('img/icons/x-dark.svg') }}" alt="close">
        </div>
        <div class="firago firago--smm firago--blue mb-9">ატვირთე ფოტო</div>
        <form action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}" method="POST" enctype="multipart/form-data" class="profile-img-upload">
            @csrf
            @method('patch')
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
</div> -->
<div class="popup popup-resizable-pic popup-profile-pic">
    <div class="popup__content popup__content--white">
        <div class="popup-header">
            <div class="title firago firago--upp firago--style-normal firago--mdd">ატვირთე ფოტო</div>
            <div class="popup__close d-flex align-items-center">
                <span class="firago firago--style-normal firago--500 firago--smm firago--blue mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-light-blue.svg') }}" alt="close">
            </div>
        </div>
        <div class="line mb-3"></div>
        <form action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}" method="POST" enctype="multipart/form-data" class="profile-img-upload">
            @csrf
            @method('patch')
            <div class="uploader-container file-uploader">
                <label class="upload-button firago upload-tools active" for="file-input">
                    <div class="file-name mw-100">
                        <span class="lg">ატვირთვა</span>
                        <span class="md">+</span>
                    </div>
                    <input type="file" id="file-input" class='raw-file-input' style="display: none;" name="image" accept=".jpg, .png, .jpeg">
                </label>
                <div class="img-src upload-tools active">no file chosen</div>
                <div class="rendered-raw-container">
                    <div class='profile-pic-raw-container rendered-raw-wrapper'>
                        <img src="" class="profile-pic-image" id="profile-pic-raw" />
                    </div>
                    <div class='btn btn--grey crop-button' id="crop-button">
                        <span>მოჭრა</span>
                    </div>
                </div>
                <div class="profile-pic-cropped-container cropped-container" id='profile-pic-cropped'>
                    <img class="cropped-image" src="" alt="">
                    <div class='btn btn--grey' id="enable-crop">
                        <span>რედაქტირება</span>
                    </div>
                    <input type="text" name="prof_image_base64" hidden id='org-profile-image'>
                </div>
            </div>
            <div class="popup-buttons mt-7">
                <button type="button" class="button button--gray button-blue cover-image-remove non-submit active">
                    <span class="firago firago--sm firago--style-normal firago--500">გაუქმება</span>
                </button>
                <button class="button non-submit save button--red button--blue img-save ml-2">
                    <span class="firago firago--sm firago--style-normal firago--500">შენახვა</span>
                </button>
            </div>
        </form>
    </div>
</div>
<!-- BEGIN: Page Main-->
<div id="main" class="profile-page org-admin-profile-page">
    <div class="wrapper no-padding-md">
        <div class="cover-wrapper">
            <img id="cover-image" src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" original-src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" original-style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" class="cover" />
            <form id="cover-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company-cover') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cover_top_position" />
                <input type="hidden" name="cover_left_position" />
                <input type="file" id="cover-raw" name="cover_image" style="display: none;" accept=".jpg, .png, .jpeg">
                <div type="button" class="button button--gray add-cover non-submit active admin-profil-add-cover">
                    <!-- <span class="mr-2">ფოტოს ატვირთვა</span> -->
                    <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="upload cover">
                </div>
                <input type="text" id="cover-image-base64" name="cover_image_base64" hidden>
            </form>
            <div class="rendered-raw-container">
                <div class='profile-pic-raw-container rendered-raw-wrapper'>
                    <img src="" class="profile-pic-image" id="profile-pic-raw" />
                </div>
            </div>
            <div class="profile-pic-cropped-container cropped-container" id='profile-pic-cropped'>
                <img class="cropped-image" src="" alt="">
            </div>
            <div class="confirm-upload">
                <div class="cover-button cancel firago firago--sm firago--normal active">
                    გაუქმება
                </div>
                <div class="cover-button crop-button firago firago--sm firago--normal active">
                    მოჭრა
                </div>
                <div class="cover-button save firago firago--sm firago--normal">
                    შენახვა
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper no-padding-md">
        <div class="company-info">
            <div class="section">
                <div class="profile-pic">
                    <div class="pic-container">
                        <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="profile-picture">
                    </div>
                    <div class="profile-pic-upload">
                        <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="img upload">
                        <div class="firago firago--xs firago--normal">ატვირთე ფოტო</div>
                    </div>
                </div>
                <a href="{{url('/' . app()->getLocale() . '/admin/profile')}}" class="company-name firago--upp firago--mdd text-blue firago--bold">{{$user->name}}</a>
            </div>
            <!-- <div class="section">
                <div class="ongoing-wrapper">
                    <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები</p>
                    <p class="count firago firago--normal firago--md firago--500 text-blue">{{$ongoingOpportunitiesCount}}</p>
                </div>
                <div class="finished-wrapper">
                    <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები</p>
                    <p class="count firago firago--normal firago--md firago--500 text-blue">{{$finishedOpportunitiesCount}}</p>
                </div>
            </div> -->
            <div class="org-profile-action-btns">
              <a href="{{url('/' . app()->getLocale() . '/admin/opportunities')}}" class="button button--red mb-2 justify-content-center">
                <img src="{{ asset('img/icons/opportunities-white.svg') }}" alt="update profile">
                <span class="ml-1">შესაძლებლობების სია</span>
              </a>
              <a href="{{url('/' . app()->getLocale() . '/admin/opportunity/create')}}" class="button button--red justify-content-center">
                  <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" alt="add opportunity">
                  <span class="ml-1">შექმენი შესაძლებლობა</span>
              </a>
            </div>
        </div>
    </div>
    <div class="wrapper">
      <div class="section org-profile-projects-stats  d-flex align-items-center mt-8 flex-wrap">
        <div class="ongoing-wrapper d-flex align-items-center mr-3">
            <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები</p>
            <p class="count firago firago--normal firago--md firago--500 text-blue">({{$ongoingOpportunitiesCount}})</p>
        </div>
        <div class="finished-wrapper d-flex align-items-center">
            <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები</p>
            <p class="count firago firago--normal firago--md firago--500 text-blue">({{$finishedOpportunitiesCount}})</p>
        </div>
    </div>
    </div>
    <div class="wrapper">
        <div class="menu-mobile-admin">
            <div class="menu-mobile-item current">ზოგადი ინფორმაცია</div>
            <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" alt="arrow" class="icon">
            <div class="menu-mobile-dropdown">
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='' || $tabName == null) active @endif" data-tab-index="0">
                    ზოგადი ინფორმაცია
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='about') active @endif" data-tab-index="1">
                    ორგანიზაციის შესახებ
                </div>
                <div class="menu-mobile-item @if(isset($tab) && $tab=='tab=registration-place') active @endif" data-tab-index="2">
                    რეგისტრაციის ადგილი
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='organization-types') active @endif" data-tab-index="3">
                    ორგანიზაციის ტიპები
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='activity-areas') active @endif" data-tab-index="4">
                    სამოქმედო არეალი
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='activity-fields') active @endif" data-tab-index="5">
                    საქმიანობის არჩევა
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='contact') active @endif" data-tab-index="6">
                    კონტაქტი
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='password') active @endif" data-tab-index="7">
                    პაროლის ცვლილება
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='subscripted-orgs') active @endif" data-tab-index="8">
                    გამოწერილი ორგანიზაციბი
                </div>
                <div class="menu-mobile-item @if(isset($tabName) && $tabName=='subscripted-categories') active @endif" data-tab-index="9">
                    გამოწერილი კატეგორიები
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper org-profile-edit-tabs-wrapper">
        <div class="row">
            <div class="col s12">
                <div class="container">

                    <!-- Content Area Starts -->
                    <div class="content-area">
                        <div class="app-wrapper profile-wrapper mt-5">

                            <div class="sidebar">
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='' || $tabName == null) active @endif" data-tab-index="0">
                                    ზოგადი ინფორმაცია
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='about') active @endif" data-tab-index="1">
                                    ორგანიზაციის შესახებ
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='registration-place') active @endif" data-tab-index="2">
                                    რეგისტრაციის ადგილი
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='organization-types') active @endif" data-tab-index="3">
                                    ორგანიზაციის ტიპები
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='activity-areas') active @endif" data-tab-index="4">
                                    სამოქმედო არეალი
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='activity-fields') active @endif" data-tab-index="5">
                                    საქმიანობის არჩევა
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='contact') active @endif" data-tab-index="6">
                                    კონტაქტი
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='password') active @endif" data-tab-index="7">
                                    პაროლის ცვლილება
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='subscripted-orgs') active @endif" data-tab-index="8">
                                    გამოწერილი ორგანიზაციბი
                                </div>
                                <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 @if(isset($tabName) && $tabName=='subscripted-categories') active @endif" data-tab-index="9">
                                    გამოწერილი კატეგორიები
                                </div>
                            </div>

                            <div class="tab org-main-info-tab @if(isset($tabName) && $tabName=='' || $tabName == null) active @endif" data-tab-index="0">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">ზოგადი ინფორმაცია</p>

                                <form id='profile-delete-image' method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @csrf
                                    @method('patch')
                                    <input hidden type="text" name="delete_img" value="0">
                                </form>

                                <form class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @method('patch')
                                    <div class="org-profile-img">
                                        <!-- <div class="image-container">
                                            <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="img">
                                        </div> -->
                                        <div>
                                            <!-- <div class="profile-pic-upload cropper-popup-trigger">
                                                <span>ფოტოს ატვირთვა</span>
                                                <img src="{{ asset('img/icons/camera.svg') }}" alt="img upload">
                                            </div> -->
                                            <div class="btn btn--grey justify-content-center" onclick="document.getElementById('profile-delete-image').submit();">
                                                <span class="mr-1">პროფილის ფოტოს წაშლა</span>
                                                <img src="{{ asset('img/icons/bin-white.svg') }}" alt="img delete">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group  form__group--admin mb-2">
                                        <label for="name_ka" class="form__label firago firago--style-normal firago--500 firago--smm">ორგანიზაციის სახელი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" class="form__input" id="name_ka" value="{{ $user->name }}" name="name_ka" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>

                                    <div class="form__group  form__group--admin mb-2">
                                        <label for="email" class="form__label firago firago--style-normal firago--500 firago--smm">ელექტრონული მეილი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" class="form__input" id="email" value="{{ $user->email }}" name="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div alt-text='ელ-ფოსტა უკვე დარეგისტრირებულია' default-text='გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი'>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                                        </div>
                                    </div>

                                    <div class="form__group  form__group--admin mb-2">
                                        <label for="phone" class="form__label firago firago--style-normal firago--500 firago--smm">საკონტაქტო ნომერი
                                            <!-- <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span> -->
                                        </label>
                                        <input type="tel" class="form__input" id="phone" value="{{ $user->phone }}" name="phone">
                                        <!-- <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი'>გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი</div>
                                        </div> -->
                                    </div>

                                    <div class="form__group  form__group--admin mb-2">
                                        <label for="phone2" class="form__label firago firago--style-normal firago--500 firago--smm">საკონტაქტო ნომერი 2
                                            <!-- <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span> -->
                                        </label>
                                        <input type="tel" class="form__input" id="phone2" value="{{ $user->phone2 }}" name="phone2">
                                        <!-- <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი'>გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი</div>
                                        </div> -->
                                    </div>

                                    <div class="form__group  form__group--admin">
                                        <label for="registration_id" class="form__label firago firago--style-normal firago--500 firago--smm">სარეგისტრაციო კოდი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" class="form__input" id="registration_id" value="{{ $user->registration_id }}" name="registration_id" pattern="^[0-9]{9}" maxlength="9">
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითეთ 9 ციფრი'>გთხოვთ, მიუთითეთ 9 ციფრი</div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab org-description-admin @if(isset($tabName) && $tabName=='about') active @endif" data-tab-index="1">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">ორგანიზაციის აღწერა</p>

                                <form class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @method('patch')
                                    <div class="form__group form__group--admin mb-5">
                                        <label for="description1_ka" class="form__label align-left firago firago--style-normal firago--500 firago--smm">აღწერე ორგანიზაციის საქმიანობა , მისია და ა.შ. მაქსიმუმ 400 სიმბოლოთი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <textarea type="text" class="form__area limited-editor" id="description1_ka" name="description1_ka" pattern=".{1}" placeholder="აღწერე ორგანიზაციის საქმიანობა , მისია და ა.შ. მაქსიმუმ 400 სიმბოლოთი">{!! $user->description1 !!}</textarea>
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab registration-place-admin @if(isset($tabName) && $tabName=='registration-place') active @endif" data-tab-index="2">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">რეგისტრაციის ადგილი</p>

                                <form class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @method('patch')
                                    @php
                                    $isLocal = !isset($placeOfRegistration) || $placeOfRegistration->is_georgia;
                                    @endphp
                                    
                                    <div class="org-address-profile-grid">
                                      <div class="toggle-container registration-place-toggle mb-4">
                                          <label class="left checkbox-container mb-2">
                                              
                                              <div class="firago firago--normal firago--sm toggle-title @if($isLocal) active @endif">ადგილობრივი</div>
                                              <input type="radio" value="1" name="por_is_georgia" class="ignore" hidden @if($isLocal) checked @endif>
                                              <span class="checkmark radio"></span>
                                          </label>
                                          <!-- <div class="toggle @if(!$isLocal) right @endif">
                                              <span class="slider"></span>
                                          </div> -->
                                          <label class="right checkbox-container">
                                              
                                              <div class="firago firago--normal firago--sm toggle-title @if(!$isLocal)  active @endif">საერთაშორისო</div>
                                              <input type="radio" value="0" name="por_is_georgia" class="ignore" hidden @if(!$isLocal) checked @endif>
                                              <span class="checkmark radio"></span>
                                          </label>
                                      </div>
                                      <div class="is-international @if(!$isLocal) active @endif">
                                          <div class="form__group form__group--admin  toggle-right @if($isLocal) disabled @endif ">
                                              <label for="foreign-address" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ქვეყანა, ქალაქი, მისამართი</label>
                                              <input type="text" class="form__input" id="foreign-address" name="por_address_text" @if($isLocal) disabled value="" @else value="{{$placeOfRegistration->address_text}}" @endif>
                                          </div>

                                          <div class="form__group form__group--admin ">
                                              <label for="registration_date" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ორგანიზაციის რეგისტრაციის თარიღი</label>
                                              <input type="date" class="form__input ignore-input-text" id="registration_date" name="registration_date" pattern=".{1}" @if($company->registration_date) value="{{$company->registration_date->format('Y-m-d')}}" @endif>
                                          </div>
                                      </div>

                                      <div class="is-local @if($isLocal) active @endif is-local-left-address">
                                          @php
                                          $isRegionSet = isset($placeOfRegistration) && $placeOfRegistration->region_id;
                                          $isMuniSet = isset($placeOfRegistration) && $placeOfRegistration->municipality_id;
                                          @endphp
                                          
                                          @php
                                          $isSame = $placeOfRegistration && $placeOfRegistration->address_text == $company->address;
                                          @endphp

                                          <p class="firago firago--mdd firago--style-normal firago--upp firago--dark" style="flex-basis: 100%">მისამართი</p>

                                          <div class="form__group  iur-form-group-switch form__group--admin">
                                              <div class="same-address-wrapper">
                                                  <div class="form__label firago firago--style-normal firago--500 firago--smm firago--nowrap">
                                                      ფაქტობრივი მისამართი ემთხვევა თუ არა იურიდიულს
                                                  </div>
                                                  <div class="toggle-container">
                                                      <label class="left checkbox-container">
                                                          <div class="firago firago--normal firago--sm toggle-title @if($isSame) active @endif">კი</div>
                                                          <input type="radio" value="1" name="same_address" class="ignore" hidden checked>
                                                          <span class="checkmark radio"></span>

                                                      </label>
                                                      <!-- <div class="toggle @if(!$isSame) right @endif">
                                                          <span class="slider"></span>
                                                      </div> -->
                                                      <label class="right checkbox-container">
                                                          <div class="firago firago--normal firago--sm toggle-title @if(!$isSame) active @endif">არა</div>
                                                          <input type="radio" value="0" name="same_address" class="ignore" hidden>
                                                          <span class="checkmark radio"></span>

                                                      </label>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="form__group form__group--admin legal-address-wrapper">
                                              <div for="legal_address" class="form__label align-left firago firago--style-normal firago--500 firago--smm">იურიდიული მისამართი</div>
                                              <input id="legal_address" type="text" class="form__input user-input" pattern=".{1}" name="por_address_text" @if ($placeOfRegistration) value="{{$placeOfRegistration->address_text}}" @endif>
                                          </div>

                                          

                                          <div class="form__group  form__group--admin factual-address-wrapper @if($isSame) disabled @endif">
                                              <div for="factual_address" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ფაქტობრივი მისამართი</div>
                                              <input id="factual_address" type="text" class="form__input user-input ignore-input-text" name="info_address_text" @if($isSame) disabled @else value="{{$company->address}}" @endif>
                                          </div>
                                      </div>
                                      
                                      <div class="is-local @if($isLocal) active @endif">
                                          @php
                                          $isRegionSet = isset($placeOfRegistration) && $placeOfRegistration->region_id;
                                          $isMuniSet = isset($placeOfRegistration) && $placeOfRegistration->municipality_id;
                                          @endphp
                                          <div class="form__group form__group--admin form__group--dropdown linked  toggle-left">
                                              <label for="region" class="form__label align-left firago firago--style-normal firago--500 firago--smm">რეგიონი</label>
                                              <div class="dropdown-right-trigger">
                                                  <div class="form__group-arrow">
                                                      <img src="{{ asset('img/icons/chevron-down-black.svg') }}" alt="arrow" draggable="false">
                                                  </div>
                                                  <input id="region" type="text" class="form__input readonly ellipsis" pattern=".{1}" readonly @if (!$isRegionSet) disabled @else value="{{$placeOfRegistration->region->name}}" @endif placeholder="{{$isRegionSet ? $placeOfRegistration->region->name :'აირჩით რეგიონი'}}">
                                              </div>
                                              <div class="dropdown-right dropdown-regions active selected">
                                                  <div class="dropdown-right__content">
                                                      @foreach($regions as $region)
                                                      @php
                                                      $isCurRegion = $isRegionSet && $region->id == $placeOfRegistration->region_id;
                                                      @endphp
                                                      <label class="no-checkmark radio @if($isCurRegion) active @endif">
                                                          <input type="radio" name="por_region" value="{{$region->id}}" @if($isCurRegion) checked @endif>
                                                          <span>{{ $region->name }}</span>
                                                      </label>
                                                      @endforeach
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="form__group form__group--admin form__group--dropdown linked @if(!isset($placeOfRegistration) || !$placeOfRegistration->region_id) disabled @endif ">
                                              <label for="region" class="form__label align-left firago firago--style-normal firago--500 firago--smm">მუნიციპალიტეტი</label>
                                              <div class="dropdown-right-trigger">
                                                  <div class="form__group-arrow">
                                                      <img src="{{ asset('img/icons/chevron-down-black.svg') }}" alt="arrow" draggable="false">
                                                  </div>
                                                  <input id="municipality" type="text" class="form__input readonly ellipsis" pattern=".{1}" readonly @if(!isset($placeOfRegistration) || !$placeOfRegistration->region_id) disabled @else value="{{$placeOfRegistration->municipality->name}}" @endif
                                                  placeholder="{{$isMuniSet ? $placeOfRegistration->municipality->name :'აირჩით მუნიციპალიტეტი'}}">
                                              </div>
                                              <div class="dropdown-right dropdown-regions active selected">
                                                  <div class="dropdown-right__content">
                                                      @foreach($municipalities as $municipality)
                                                      @php
                                                      $isCurMuni = isset($placeOfRegistration) && $municipality->id == $placeOfRegistration->municipality_id;
                                                      @endphp
                                                      <label class="no-checkmark radio @if($isCurMuni) active @endif">
                                                          <input type="radio" name="por_municipality" value="{{$municipality->id}}" @if($isCurMuni) checked @endif>
                                                          <span>{{ $municipality->name }}</span>
                                                      </label>
                                                      @endforeach
                                                  </div>
                                              </div>
                                          </div>
                                          @php
                                          $isSame = $placeOfRegistration && $placeOfRegistration->address_text == $company->address;
                                          @endphp

                                          <!-- <p class="firago firago--mdd firago--style-normal firago--upp firago--dark mb-5" style="flex-basis: 100%">მისამართი</p>

                                          <div class="form__group form__group--half form__group--admin mb-5 legal-address-wrapper">
                                              <div for="legal_address" class="form__label align-left firago firago--style-normal firago--500 firago--smm">იურიდიული მისამართი</div>
                                              <input id="legal_address" type="text" class="form__input user-input" pattern=".{1}" name="por_address_text" @if ($placeOfRegistration) value="{{$placeOfRegistration->address_text}}" @endif>
                                          </div>

                                          <div class="form__group form__group--half form__group--admin mb-5">
                                              <div class="same-address-wrapper">
                                                  <div class="form__label firago firago--style-normal firago--500 firago--smm firago--nowrap">
                                                      ფაქტობრივი მისამართი ემთხვევა თუ არა იურიდიულს
                                                  </div>
                                                  <div class="toggle-container">
                                                      <label class="left">
                                                          <div class="firago firago--normal firago--sm toggle-title @if($isSame) active @endif">კი</div>
                                                          <input type="radio" value="1" name="same_address" class="ignore" hidden checked>
                                                      </label>
                                                      <div class="toggle @if(!$isSame) right @endif">
                                                          <span class="slider"></span>
                                                      </div>
                                                      <label class="right">
                                                          <div class="firago firago--normal firago--sm toggle-title @if(!$isSame) active @endif">არა</div>
                                                          <input type="radio" value="0" name="same_address" class="ignore" hidden>
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>

                                          <div class="form__group form__group--half form__group--admin factual-address-wrapper @if($isSame) disabled @endif">
                                              <div for="factual_address" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ფაქტობრივი მისამართი</div>
                                              <input id="factual_address" type="text" class="form__input user-input ignore-input-text" name="info_address_text" @if($isSame) disabled @else value="{{$company->address}}" @endif>
                                          </div> -->
                                      </div>

                                      
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>

                            </div>

                            <div class="tab tab--types has-option-other @if(isset($tabName) && $tabName=='organization-types') active @endif" data-tab-index="3">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">ორგანიზაციის ტიპები</p>

                                <p class="firago firago--style-normal firago--500 firago--smm firago--dark mb-3 line-height-1-3">მიუთითეთ ის კატეგორია, რომელიც ფიქრობთ რომ თქვენს შესაძლებლობას შეესაბამება</p>
                                <form method="POST" class="tab-form" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="checkboxes-wrapper">
                                        @foreach ($statuses as $type)
                                        @if (!$type->can_be_filled)
                                        <label class="checkbox-container mb-2">
                                            <input type="radio" name="status" value="{{$type->id}}" @if($companyStatus && $type->id == $companyStatus->id) checked @endif>
                                            <span class="checkmark radio"></span>
                                            <span class="firago firago--style-normal firago--500 firago--smm firago--dark">{{$type->name}}</span>
                                        </label>
                                        @else
                                        <div class="option-other">
                                            <label class="checkbox-container checkbox-container--other">
                                                <input type="checkbox" value="{{$type->id}}" name="status" class="other-checkbox" @if($companyStatus && $type->id == $companyStatus->id) checked @endif>
                                                <span class="checkmark radio"></span>
                                                <div class="firago firago--normal firago--sm">{{$type->name}}</div>
                                            </label>
                                            <div class="form__group form__group--admin skip-animation">
                                                <input type="text" class="form__input" name="status_description" @if($companyStatus && $type->id == $companyStatus->id) value="{{$companyStatus->pivot->description}}" @else disabled @endif>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab tab--coverage-areal select-section-wrapper @if(isset($tabName) && $tabName=='activity-areas') active @endif" data-tab-index="4">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">ორგანიზაციის სამოქმედო არეალი</p>
                                <form method="POST" class="tab-form" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="toggle-container mb-2">
                                        <label class="left checkbox-container">
                                            <div class="firago firago--normal firago--sm toggle-title @if($company->areal == 'local') active @endif">ადგილობრივი</div>
                                            <input type="radio" value="local" name="areal" class="ignore" hidden @if($company->areal == 'local') checked @endif>
                                            <span class="checkmark radio"></span>

                                        </label>
                                        <!-- <div class="toggle @if($company->areal != 'local') right @endif">
                                            <span class="slider"></span>
                                        </div> -->
                                        <label class="right  checkbox-container">
                                            <div class="firago firago--normal firago--sm toggle-title @if($company->areal != 'local') active @endif">საერთაშორისო</div>
                                            <input type="radio" value="international" name="areal" class="ignore" hidden @if($company->areal != 'local') checked @endif>
                                            <span class="checkmark radio"></span>

                                        </label>
                                    </div>
                                    {{-- {{dd($company->areal)}} --}}

                                    <p class="firago firago--mdd firago--style-normal firago--upp firago--dark mb-1">დაფარვის არეალი</p>

                                    <p class="firago firago--style-normal firago--500 firago--sm firago--dark mb-3 line-height-1-3">
                                        მონიშნეთ, თუ რომელ რეგიონებზე და მუნიციპალიტეტებზე გავრცელდება თქვენი შესაძლებლობა
                                    </p>
                                    <div class="select-section-wrapper">
                                        <div class="select-section select-section--admin">
                                            <div class="filter__dropdown regions">
                                                <label id="filter-by-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                    <div class="title">ყველა</div>
                                                </label>
                                                <div class="separator separator-static"></div>
                                                @foreach ($regions as $region)
                                                @php
                                                $isRegion = $company->workingRegions && $company->workingRegions->find($region->id);
                                                @endphp
                                                <label class="checkbox-container sub-item checkbox-container--red">
                                                    <input name="workingRegions[]" value="{{$region->id}}" type="checkbox" data-id="{{$region->id}}" @if($isRegion) checked @endif>
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$region->name}}</div>
                                                </label>
                                                @endforeach
                                            </div>
                                            <div class="municipalities-wrapper">
                                                <div class="municipality-sections-wrapper">
                                                    {{-- {{dd($company->workingRegions)}} --}}
                                                    @foreach ($regions as $region)
                                                    @php
                                                    $isRegion = $company->workingRegions && $company->workingRegions->find($region->id);
                                                    @endphp
                                                    <div class="municipality-section @if($isRegion) active @endif" data-region-id="{{$region->id}}">
                                                        <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                                                        <div class="filter__dropdown municipalities-dropdown">
                                                            <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                                                <input type="checkbox" @if($isRegion) checked @endif>
                                                                <span class="checkmark"></span>
                                                                <div class="title">{{$region->name}}</div>
                                                                <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" />
                                                            </label>
                                                            <label class="checkbox-container desktop checkbox-container--red all-checkmark uncheck-all">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <div class="title">ყველა</div>
                                                            </label>
                                                            <div class="separator separator-static"></div>
                                                            @foreach ($region->municipalities as $municipality)
                                                            <label id="filter-by-municipalities" class="checkbox-container sub-item checkbox-container--red">
                                                                <input name="workingMunicipalities[]" value="{{$municipality->id}}" type="checkbox" data-id="{{$municipality->id}}" @if($company->workingMunicipalities && $company->workingMunicipalities->find($municipality->id)) checked @endif>
                                                                <span class="checkmark"></span>
                                                                <div class="title">{{$municipality->name}}</div>
                                                            </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab tab--working-types @if(isset($tabName) && $tabName=='activity-fields') active @endif" data-tab-index="5">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">საქმიანობის არჩევა</p>
                                <form method="POST" class="tab-form" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @csrf
                                    @method('patch')
                                    <div class="form__group form__group--admin mb-9">
                                        <label class="form__label align-left firago firago--style-normal firago--500 firago--smm line-height-1-3">მიუთითეთ ის კატეგორია, რომელიც ფიქრობთ რომ თქვენს შესაძლებლობას შეესაბამება</label>
                                        <div class="select-section mt-1">
                                            <div class="filter__dropdown working-types">
                                                <label id="select-all-types" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                    <div class="title">ყველა</div>
                                                </label>
                                                <div class="separator separator-static"></div>
                                                @foreach ($workingTypes as $type)
                                                @if (!$type->can_be_filled)
                                                <label class="checkbox-container sub-item checkbox-container--red">
                                                    <input type="checkbox" value="{{$type->id}}" name="workingTypes[]" @if($companyTypes && $companyTypes->find($type->id)) checked @endif>
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$type->name}}</div>
                                                </label>
                                                @else
                                                <div class="option-other">
                                                    <label class="checkbox-container checkbox-container--other checkbox-container--red">
                                                        <input type="checkbox" value="{{$type->id}}" name="workingTypes[]" class="other-checkbox" @if($companyTypes && $companyTypes->find($type->id)) checked @endif>
                                                        <span class="checkmark"></span>
                                                        <div class="title">{{$type->name}}</div>
                                                    </label>
                                                    <div class="form__group skip-animation">
                                                        <input type="text" class="form__input" name="working_type_description[{{$type->id}}]" @if($companyTypes && $companyTypes->find($type->id)) value={{$companyTypes->find($type->id)->pivot->description}} checked @else disabled @endif>
                                                    </div>
                                                </div>
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <p class="firago firago--mdd firago--style-normal firago--upp firago--dark">საქმიანობის ქვეტიპები</p>

                                    <div class="form__group form__group--admin mb-9">
                                        <label class="form__label align-left firago firago--style-normal firago--500 firago--smm mb-5 line-height-1-3">ქვემოთ მოცემულია ორგანიზაციის საქმიანობის სფეროში შემავალი ქვეტიპები</label>

                                        <div class="working-subtypes">
                                            @foreach($workingTypes as $type)
                                            @foreach($type->CompanyWorkingSubtype as $subtype)
                                            <div class="subtype firago firago--smm firago--normal mb-2 @if($companyTypes->find($type->id)) active @endif" type-id="{{$type->id}}">{{$subtype->name}}</div>
                                            @endforeach
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab org-page-contact-tab @if(isset($tabName) && $tabName=='contact') active @endif" data-tab-index="6">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">კონტაქტი</p>

                                <form class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @method('patch')
                                    <!--<div class="form__group form__group--half form__group--admin mb-5">
                                        <label for="email" class="form__label firago firago--style-normal firago--500 firago--smm">ელ. ფოსტა
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" class="form__input" id="email" value="{{ $user->email }}" name="email" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>

                                    <div class="form__group form__group--half form__group--admin mb5">
                                        <label for="phone" class="form__label firago firago--style-normal firago--500 firago--smm">მობილურის ნომერი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" class="form__input" id="phone" value="{{ $user->phone }}" name="phone" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>-->

                                    <div class="form__group  form__group--admin mb5">
                                        <label for="web_page" class="form__label firago firago--style-normal firago--500 firago--smm">ვებ-გვერდი
                                            <!-- <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span> -->
                                        </label>
                                        <input type="text" class="form__input" id="web_page" value="{{ $user->web_page }}" name="web_page" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                        <!-- <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div> -->
                                    </div>

                                    <div class="form__group  form__group--admin mb5">
                                        <label for="fb_page" class="form__label firago firago--style-normal firago--500 firago--smm">ფეისბუქი
                                            <!-- <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span> -->
                                        </label>
                                        <input type="text" class="form__input" id="fb_page" value="{{ $user->fb_page }}" name="fb_page" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                        <!-- <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div> -->
                                    </div>

                                    <div class="form__group  form__group--admin">
                                        <label for="linkedin_page" class="form__label firago firago--style-normal firago--500 firago--smm">Linkedin
                                            <!-- <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span> -->
                                        </label>
                                        <input type="text" class="form__input" id="linkedin_page" value="{{ $user->linkedin_page }}" name="linkedin_page" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                        <!-- <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div> -->
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab tab-password-changing @if(isset($tabName) && $tabName=='password') active @endif" data-tab-index="7">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">პაროლის ცვლილება</p>

                                <form class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
                                    @method('patch')
                                    <div class="form__group form__group--admin mb5" >
                                        <label for="old-password" class="form__label add-required">ძველი პაროლი</label>
                                        <input type="password" class="form__input" id="old-password" name="old_password" pattern=".{8,}">
                                        <div class="password-visible">
                                            <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                        </div>
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>მიმდინარე პაროლი არასწორია</div>
                                        </div>
                                    </div>

                                    <div class="form__group  form__group--admin">
                                        <label for="password" class="form__label add-required">ახალი პაროლი</label>
                                        <input type="password" class="form__input" id="password" name="password" pattern=".{8,}">
                                        <div class="password-visible">
                                            <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                        </div>
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>
                                        </div>
                                    </div>

                                    <div class="form__group form__group--admin">
                                        <label for="password_confirmation" class="form__label add-required">გაიმეორეთ ახალი პაროლი</label>
                                        <input type="password" class="form__input" id="password_confirmation" name="password_confirmation" pattern=".{8,}">
                                        <div class="password-visible">
                                            <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                                        </div>
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>პაროლები არ ემთხვევა</div>
                                        </div>
                                    </div>
                                    <div class="bottom">
                                        <div class="button button--red">
                                            <span class="d-inline-block">ცვლილებების შენახვა</span>
                                            <!-- <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="tab subscribed-orgs @if(isset($tabName) && $tabName=='subscripted-orgs') active @endif" data-tab-index="8">
                                @if (sizeof($subscribedCompanies) > 0)
                                <div class="profile-grid subscribed-organizations">
                                    @foreach ($subscribedCompanies as $company)
                                    <div class="subscibed-organization bordered-container" href="#">
                                        <div class="organization-img">
                                            <img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img">
                                        </div>
                                        <div class="organization-title">
                                            <h4 class="heading heading--md mb-1">{{ $company->name }}</h4>
                                            <div class="subs-amount">{{ $company->subscriberCount() }} გამომწერი</div>
                                        </div>
                                        <div class="delete subs-delete" data-company-id="{{ $company->id }}">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- <nav class="pagination-container profile-pagination" url="/ajax-load-more-subscribed-companies" page="1" number-per-page="">
                                        <ul class="pagination pagination--blue">
                                            <li class="page-item prev disabled">
                                                <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-white.svg') }}" alt="previous"></p>
                                </li>
                                <li class="page-item">
                                    <p class="page-link" data-new-page="">1</p>
                                </li>
                                <li class="page-item">
                                    <p class="page-link" data-new-page="">2</p>
                                </li>
                                <li class="page-item">
                                    <p class="page-link" data-new-page="">3</p>
                                </li>
                                <li class="page-item">
                                    <p class="page-link" data-new-page="">4</p>
                                </li>
                                <li class="page-item next">
                                    <p class="page-link" data-new-page=""><img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="previous"></p>
                                </li>
                                </ul>
                                </nav> --}}
                                @else
                                <div class="firago firago--md">შენ არ გაქვს გამოწერილი არც ერთი ორგანიზაცია</div>
                                @endif

                            </div>

                            <div class="tab subscribed-cats @if(isset($tabName) && $tabName=='subscripted-categories') active @endif" data-tab-index="9">

                                <div class="firago firago--md">შენ არ გაქვს გამოწერილი არც ერთი კატეგორია</div>

                                {{-- Currently taken away from page --}}
                                @if(false)
                                <div class="profile-grid subscribed-categories">
                                    <div class="subscibed-category" href="#">
                                        <div class="title">კატეგორიის სახელი</div>
                                        <div class="d-flex align-items-center">
                                            <div class="opp">შესაძლებლობა</div>
                                            <div class="amount">2</div>
                                        </div>
                                        <div class="delete subs-delete" data-company-id="">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                    <div class="subscibed-category" href="#">
                                        <div class="title">კატეგორიის სახელი</div>
                                        <div class="d-flex align-items-center">
                                            <div class="opp">შესაძლებლობა</div>
                                            <div class="amount">2</div>
                                        </div>
                                        <div class="delete subs-delete" data-category-id="">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                    <div class="subscibed-category" href="#">
                                        <div class="title">კატეგორიის სახელი</div>
                                        <div class="d-flex align-items-center">
                                            <div class="opp">შესაძლებლობა</div>
                                            <div class="amount">2</div>
                                        </div>
                                        <div class="delete subs-delete" data-category-id="">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                    <div class="subscibed-category" href="#">
                                        <div class="title">კატეგორიის სახელი</div>
                                        <div class="d-flex align-items-center">
                                            <div class="opp">შესაძლებლობა</div>
                                            <div class="amount">2</div>
                                        </div>
                                        <div class="delete subs-delete" data-category-id="">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                    <div class="subscibed-category" href="#">
                                        <div class="title">კატეგორიის სახელი</div>
                                        <div class="d-flex align-items-center">
                                            <div class="opp">შესაძლებლობა</div>
                                            <div class="amount">2</div>
                                        </div>
                                        <div class="delete subs-delete" data-category-id="">
                                            <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
                                            <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
                                        </div>
                                    </div>
                                </div>

                                <nav class="pagination-container profile-pagination" url="/ajax-load-more-subscribed-companies" page="1" number-per-page="">
                                    <ul class="pagination pagination--blue">
                                        <li class="page-item prev disabled">
                                            <p class="page-link" data-new-page="0" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-white.svg') }}" alt="previous"></p>
                                        </li>
                                        <li class="page-item">
                                            <p class="page-link" data-new-page="">1</p>
                                        </li>
                                        <li class="page-item">
                                            <p class="page-link" data-new-page="">2</p>
                                        </li>
                                        <li class="page-item">
                                            <p class="page-link" data-new-page="">3</p>
                                        </li>
                                        <li class="page-item">
                                            <p class="page-link" data-new-page="">4</p>
                                        </li>
                                        <li class="page-item next">
                                            <p class="page-link" data-new-page=""><img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="previous"></p>
                                        </li>
                                    </ul>
                                </nav>
                                @endif
                            </div>
                            <!--<div class="tab" data-tab-index="8">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">გამოწერილი ორგანიზაციბი</p>

                                <div class="form__group form__group--half">
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
                            </div>

                            <div class="tab" data-tab-index="9">
                                <p class="tab-title firago firago--mdd firago--style-normal firago--upp firago--dark">გამოწერილი კატეგორიები</p>

                                <div class="form__group form__group--half">
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
                            </div>-->



                        </div>
                    </div>
                    <!-- Content Area Ends -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END: Page Main-->

<!-- BEGIN: Page Main-->
{{-- <div id="main" style="display: none">
    <div class="row">
        <div class="col s12">
            <div class="container">
                <!-- Account settings -->
                <section class="tabs-vertical mt-1 section">
                    <div class="row">
                        <div class="col l4 s12">
                            <!-- tabs  -->
                            <div class="card-panel">
                                <ul class="tabs">
                                    <li class="tab">
                                        <a href="#private">
                                            <i class="material-icons">brightness_low</i>
                                            <span>Private Info</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#organization">
                                            <i class="material-icons">error_outline</i>
                                            <span>About Organization</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#regions">
                                            <i class="material-icons">landscape</i>
                                            <span>Regions</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#municipalities">
                                            <i class="material-icons">landscape</i>
                                            <span>Municipalities</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#social-link">
                                            <i class="material-icons">chat_bubble_outline</i>
                                            <span>Social Links</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#password">
                                            <i class="material-icons">security</i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#subbed-companies">
                                            <i class="material-icons">subscriptions</i>
                                            <span>Subscribed Companies</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#subbed-categories">
                                            <i class="material-icons">subscriptions</i>
                                            <span>Subscribed Categories</span>
                                        </a>
                                    </li>
                                    <li class="tab">
                                        <a href="#anonimous-feedback">
                                            <i class="material-icons">chat_bubble_outline</i>
                                            <span>Anonimous Messages</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col l8 s12">
                            <!-- tabs content -->
                            <div id="private">
                                <div class="card-panel">
                                    <div class="display-flex">
                                        <div class="media">
                                            <img id="opportunity-image" src="{{ url('/storage/' . $company->getImagePath()) }}" class="border-radius-4" alt="profile image" height="128" width="128">
</div>
<form method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}" class="media-body" enctype="multipart/form-data">
    @csrf
    @method('patch')
    <div class="general-action-btn">
        <button type="button" id="select-files" class="btn indigo mr-2">
            <span>Upload new photo</span>
        </button>
        <button type="submit" class="btn light-pink mr-2">
            <span>Save</span>
        </button>
    </div>
    <small>Allowed JPG, JPEG or PNG</small>
    <div class="upfilewrapper">
        <input id="upfile" type="file" name="image" accept="image/png, image/jpeg, image/jpg" />
    </div>
</form>
</div>
<div class="divider mb-1 mt-1"></div>
<form class="formValidate" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
    @csrf
    @method('patch')
    <div class="row">
        <div class="col s12">
            <div class="input-field">
                <label for="name_ka">Name (Georgian) <span class="color-red">*</span></label>
                <input id="name_ka" name="name_ka" type="text" value="{{ $company->getTranslation('name', 'ka') }}" required>
            </div>
        </div>
        <div class="col s12">
            <div class="input-field">
                <label for="name_en">Name (English) <span class="color-red">*</span></label>
                <input id="name_en" name="name_en" type="text" value="{{ $company->getTranslation('name', 'en') }}" required>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <label for="email">Email <span class="color-red">*</span></label>
                <input id="email" name="email" type="email" value="{{ $company->email }}" required>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <input id="phone" name="phone" type="tel" pattern="[0-9]{9}" value="{{ $company->phone }}">
                <label for="phone">Phone</label>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <input id="phone2" name="phone2" type="tel" pattern="[0-9]{9}" value="{{ $company->phone2 }}">
                <label for="phone2">Phone 2</label>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <input id="registration_id" name="registration_id" type="number" min="000000000" max="999999999" value="{{ $company->registration_id }}">
                <label for="registration_id">Registration Number</label>
            </div>
        </div>

        <!--<div class="col s12">
                                                    <div class="input-field">
                                                        <textarea class="materialize-textarea" id="address_ka" name="address_ka" placeholder="Address" required>{!! $company->getTranslation('address', 'ka')!!}</textarea>
                                                        <label for="address_ka">Address (Georgian)</label>
                                                    </div>
                                                </div>

                                                <div class="col s12">
                                                    <div class="input-field">
                                                        <textarea class="materialize-textarea" id="address_en" name="address_en" placeholder="Address" required>{!! $company->getTranslation('address', 'en')!!}</textarea>
                                                        <label for="address_en">Address (English)</label>
                                                    </div>
                                                </div>-->

        <div class="input-field col s12">
            <label class="non-input-label" for="is_georgia">Country</label>
            <select id="is_georgia" class="select2-is-georgia browser-default" name="por_is_georgia">
                <option value="1" @if(isset($placeOfRegistration) && $placeOfRegistration->is_georgia) selected @endif>Georgia</option>
                <option value="0" @if(isset($placeOfRegistration) && !$placeOfRegistration->is_georgia) selected @endif>Other</option>
            </select>
        </div>

        <div class="input-field col s12">
            <label class="non-input-label" for="region">Region</label>
            <select id="region" class="select2-regions browser-default" name="por_region">
                <option value="0">Region</option>
                @foreach($regions as $region)
                <option value="{{$region->id}}" @if(isset($placeOfRegistration) && $placeOfRegistration->region_id && $region->id == $placeOfRegistration->region_id) selected @endif>{{$region->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="input-field col s12">
            <label class="non-input-label" for="municipality">Municipality</label>
            <select id="municipality" class="select2-municipalities browser-default" name="por_municipality">
                <option value="0">Municipality</option>
                @foreach($municipalities as $municipality)
                <option value="{{$municipality->id}}" @if(isset($placeOfRegistration) && $municipality->id == $placeOfRegistration->municipality_id) selected @endif>{{$municipality->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="col s12">
            <div class="input-field">
                <textarea class="materialize-textarea" id="por_address_text" name="por_address_text" placeholder="Address" required>{{ isset($placeOfRegistration) ? $placeOfRegistration->address_text : '' }}</textarea>
                <label for="address_en">Address <span class="color-red">*</span></label>
            </div>
        </div>

        <div class="col s12 display-flex justify-content-end form-action">
            <button type="submit" class="btn indigo waves-effect waves-light">
                Save changes
            </button>
        </div>
    </div>
</form>
</div>
</div>
<div id="organization">
    <div class="card-panel">
        <form class="infovalidate" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
            @csrf
            @method('patch')
            <div class="row">

                <div class="col s12">
                    <div class="input-field">
                        <textarea class="materialize-textarea" minlength="200" id="description1_ka" name="description1_ka" placeholder="ორგანიზაციის საქმიანობის აღწერა ორგანიზაციისთვის" required>{!! $company->getTranslation('description1', 'ka')!!}</textarea>
                        <label for="description1_ka">Description 1 (Georgian) <span class="color-red">*</span>
                            <</label> </div> </div> <div class="col s12">
                                <div class="input-field">
                                    <textarea class="materialize-textarea" minlength="200" id="description1_en" name="description1_en" placeholder="ორგანიზაციის საქმიანობის აღწერა ორგანიზაციისთვის" required>{!! $company->getTranslation('description1', 'en')!!}</textarea>
                                    <label for="description1_en">Description 1 (English)</label>
                                </div>
                    </div>

                    <div class="input-field select-field col s12">
                        <label for="type">Type</label>
                        <select id="type" class="select2-type browser-default" name="type">
                            <option value="local" @if($company->type == 'local') selected @endif>Local</option>
                            <option value="international" @if($company->type == 'international') selected @endif>International</option>
                        </select>
                    </div>

                    <div class="input-field select-field col s12">
                        <label for="status">Status</label>
                        <select id="status" class="select2-status browser-default" name="status">
                            @foreach($statuses as $status)
                            <option value="{{$status->id}}" @if($companyStatus && $status->id == $companyStatus->id) selected @endif>{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="input-field select-field col s12">
                        <label for="areal">Areal</label>
                        <select id="areal" class="select2-type browser-default" name="areal">
                            <option value="local" @if($company->areal == 'local') selected @endif>Local</option>
                            <option value="international" @if($company->areal == 'international') selected @endif>International</option>
                        </select>
                    </div>

                    <div class="input-field select-field col s12">
                        <label for="workingTypes">Operation Types</label>
                        <select id="workingTypes" class="select2-working-types browser-default" name="workingTypes[]" multiple="multiple">
                            @foreach($workingTypes as $workingType)
                            <option value="{{$workingType->id}}" @if($companyTypes && $companyTypes->find($workingType->id)) selected @endif>{{$workingType->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col s12 display-flex justify-content-end form-action">
                        <button type="submit" class="btn indigo waves-effect waves-light">Save
                            changes</button>
                    </div>
                </div>
        </form>
    </div>
</div>
<div id="regions">
    <div class="card-panel">
        <form class="infovalidate" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
            @csrf
            @method('patch')
            <input type="hidden" value="region" name="region" />
            <div class="row checkbox-row">

                @foreach($regions as $region)
                <p class="checkbox-wrapper s12">
                    <label>
                        <input type="checkbox" name="regions[]" class="filled-in" value={{ $region->id }} @if($companyRegions->find($region->id)) checked="checked" @endif />
                        <span>{{ $region->name }}</span>
                    </label>
                </p>
                @endforeach
                <div class="col mt-1 s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light">Save
                        changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="municipalities">
    <div class="card-panel">
        <form class="infovalidate" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
            @csrf
            @method('patch')
            <input type="hidden" value="municipality" name="municipality" />
            <div class="row checkbox-row">

                @foreach($municipalities as $municipality)
                <p class="checkbox-wrapper mb-1 col m3 s12">
                    <label>
                        <input type="checkbox" name="municipalities[]" class="filled-in" value={{ $municipality->id }} @if($companyMunicipalities->find($municipality->id)) checked="checked" @endif />
                        <span>{{ $municipality->name }}</span>
                    </label>
                </p>
                @endforeach
                <div class="col mt-1 s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light">Save
                        changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="social-link">
    <div class="card-panel">
        <form method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <input id="fb-link" type="text" class="validate" placeholder="Add link" name="fb_page" value="{{ $company->fb_page }}">
                        <label for="fb-link">Facebook</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field">
                        <input id="linkedin" type="text" class="validate" placeholder="Add link" name="linkedin_page" value="{{ $company->linkedin_page }}">
                        <label for="linkedin">LinkedIn</label>
                    </div>
                </div>
                <div class="col s12">
                    <div class="input-field">
                        <input id="web_page" type="text" class="validate" placeholder="Add link" name="web_page" value="{{ $company->web_page }}">
                        <label for="web_page">Web Site</label>
                    </div>
                </div>
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light">Save
                        changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="password">
    <div class="card-panel">
        <form method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col s12">
                    <div class="input-field">
                        <input id="password" type="password" class="validate" placeholder="Password" name="old_password">
                        <label for="password">Password <span class="color-red">*</span></label>
                    </div>
                </div>
                <div class="col m6 s12">
                    <div class="input-field">
                        <input id="quora-link" type="password" class="validate" placeholder="New password" name="password" value="">
                        <label for="quora-link">New Password <span class="color-red">*</span></label>
                    </div>
                </div>
                <div class="col m6 s12">
                    <div class="input-field">
                        <input id="password_confirmation" type="password" class="validate" placeholder="Confirm password" name="password_confirmation">
                        <label for="password_confirmation">Confirm Password <span class="color-red">*</span></label>
                    </div>
                </div>
                <div class="col s12 display-flex justify-content-end form-action">
                    <button type="submit" class="btn indigo waves-effect waves-light">Save
                        changes</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="subbed-companies">
    <div class="card-panel">
        <div class="infovalidate">
            <div class="row">

                @foreach($subscribedCompanies as $subbedCompany)
                <div class="subbed-wrapper s12 mb-1">
                    <span>{{ $subbedCompany->name }}</span>
                    <a class="waves-effect waves-light btn modal-trigger" href="#modal-company-{{$subbedCompany->id}}"><i class="material-icons">clear</i></a>
                    <!--<a class="btn-floating mb-1 waves-effect waves-light unsubscribe-company" data-id="{{ $subbedCompany->id }}">
                                                            <i class="material-icons">clear</i>
                                                        </a>-->

                    <div id="modal-company-{{$subbedCompany->id}}" class="modal">
                        <div class="modal-content">
                            <p>ნამდვილად გსურთ გამოწერის გაუქმება?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">არა</a>
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn unsubscribe-company" data-id="{{ $subbedCompany->id }}">დიახ</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="subbed-categories">
    <div class="card-panel">
        <div class="infovalidate">
            <div class="row">
                @foreach($subscribedCategories as $category)
                <div class="subbed-wrapper s12 mb-1">
                    <span>{{ $category->name }}</span>
                    <a class="waves-effect waves-light btn modal-trigger" href="#modal-category-{{$category->id}}"><i class="material-icons">clear</i></a>
                    <!--<a class="btn-floating mb-1 waves-effect waves-light unsubscribe-category" data-id="{{ $category->id }}">
                                                            <i class="material-icons">clear</i>
                                                        </a>-->

                    <div id="modal-category-{{$category->id}}" class="modal">
                        <div class="modal-content">
                            <p>ნამდვილად გსურთ გამოწერის გაუქმება?</p>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">არა</a>
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn unsubscribe-category" data-id="{{ $category->id }}">დიახ</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div id="anonimous-feedback">
    <div class="card-panel">
        <div class="faq row">
            <div class="col s12">
                <h5 class="question-title mb-2">Anonimous Feedback</h5>
                @if(count($aMessages))
                <ul class="collapsible categories-collapsible">
                    @foreach($aMessages as $index=>$message)
                    <li class="@if($index == 0) active @endif">
                        <div class="collapsible-header">Anonimous {{ $index+1 }}<i class="material-icons">
                                keyboard_arrow_right </i></div>
                        <div class="collapsible-body">
                            {!!$message->message!!}
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
</section>
</div>
<div class="content-overlay"></div>
</div>
</div>
</div> --}}
<!-- END: Page Main-->

@endsection
