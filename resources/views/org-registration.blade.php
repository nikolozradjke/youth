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

@php
$pageTitle = 'ორგანიზაციის რეგისტრაცია';
$className = 'org-registration-nav';
@endphp

<div class="wrapper user-registration-page  org-registration-page">
    @include('templates.userAreaNav')
    <div class="blue-container blue-container--inner d-flex blue-layout-md org-registration-main">
        <div class="registration-container">
            <div class="heading heading--fancy heading--fancy-white">ორგანიზაციის რეგისტრაცია</div>
            <div class="wizard__header">
                <img class="first-tab disabled" src="{{asset('/images/chevrons.svg')}}" alt="go to first tab" draggable="false" />
                <img class="prev-tab disabled" src="{{asset('img/icons/back-white.svg')}}" alt="go back" draggable="false" />
                <div class="wizard__steps">
                    <div class="wizard__step active">
                        1. <span class="title active">პირადი ინფორმაცია</span>
                    </div>
                    <div class="wizard__step">
                        2. <span class="title active">ორგანიზაციის აღწერა</span>
                    </div>
                    <div class="wizard__step">
                        3. <span class="title">რეგისტრაციის ადგილი</span>
                    </div>
                    <div class="wizard__step">
                        4. <span class="title">ორგანიზაციის ტიპი</span>
                    </div>
                    <!-- <div class="wizard__step">
                        05. <span class="title">სამოქმედო არეალი</span>
                    </div> -->
                    <div class="wizard__step">
                        5. <span class="title">სამოქმედო არეალი</span>
                    </div>
                    <div class="wizard__step">
                        6. <span class="title">საქმიანობის არჩევა</span>
                    </div>
                    <!-- <div class="wizard__step">
                        08. <span class="title">სოც. ქსელების მიმაგრება</span>
                    </div> -->
                    <div class="wizard__step">
                        7. <span class="title">პაროლი</span>
                    </div>
                    <div class="wizard__indicator">
                        <span class="bar"></span>
                    </div>
                </div>
                <img class="next-tab" src="{{asset('img/icons/back-white.svg')}}" alt="go to next tab" draggable="false" />
                <img class="last-tab" src="{{asset('/images/chevrons.svg')}}" alt="go to last tab" draggable="false" />
            </div>
            <form action="/register-company" method="POST" class="form-registration" enctype="multipart/form-data" autocomplete="off">
                {{ csrf_field() }}
                <div class="wizard__tabs wizard__tabs--organization">
                    <div class="wizard__tab wizard__tab--md wizard__tab--org-info active ">
                        <div class="form__group mb-2">
                            <label for="org-name" class="form__label">ორგანიზაციის სახელი
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label>
                            <input type="text" class="form__input" id="org-name" name="name" pattern="[a-zA-Z0-9]+|[ა-ჰ]" value="@if(old('name')){{old('name')}}@endif">
                            
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>აუცილებელი ველი</div>
                            </div>
                        </div>
                        <div class="form__group ">
                            <label for="email" class="form__label">ელ-ფოსტა
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label>
                            <input type="email" class="form__input" id="email" name="email" value="@if(old('email')){{old('email')}}@endif" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
                           
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div alt-text='ელ-ფოსტა უკვე დარეგისტრირებულია' default-text='გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი'>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                            </div>
                        </div>
                        <div class="form__group ">
                            <!-- <input type="tel" class="form__input" id="phone-number" name="phone" registration-type="company" value="@if(old('phone')){{old('phone')}}@endif" pattern="^[0-9]{9}|^$"> -->
                            <label for="phone-number" class="form__label">საკონტაქტო ნომერი
                                <!--<span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>-->
                            </label>
                            <input type="tel" class="form__input" id="phone-number" name="phone" registration-type="company" value="@if(old('phone')){{old('phone')}}@endif">
                            
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი'>გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი</div>
                            </div>
                        </div>
                        <div class="form__group ">
                            <!-- <input type="tel" class="form__input" id="phone-number-2" name="phone2" registration-type="company" value="@if(old('phone2')){{old('phone2')}}@endif" pattern="^[0-9]|^$"> -->
                            <label for="phone-number-2" class="form__label">საკონტაქტო ნომერი 2</label>
                            <input type="tel" class="form__input" id="phone-number-2" name="phone2" registration-type="company" value="@if(old('phone2')){{old('phone2')}}@endif">
                            
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='შეიტანეთ მხოლოდ ციფრები'>შეიტანეთ მხოლოდ ციფრები</div>
                            </div>
                        </div>
                        <div class="form__group ">
                            <label for="registration-number" class="form__label">სარეგისტრაციო ნომერი
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label>
                            <input type="text" class="form__input" id="registration-number" name="registration_id" value="@if(old('registration_id')){{old('registration_id')}}@endif" pattern="^[0-9]{9}" maxlength="9">
                            
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითეთ 9 ციფრი'>გთხოვთ, მიუთითეთ 9 ციფრი</div>
                            </div>
                        </div>
                        <!-- <div class="profile-pic profile-pic__registration  file-uploader">
                            <div class="upload-text-wrapper">
                                <div class="upload-text__registration firago firago--sm firago--normal">ატვირთე ფოტო</div>
                            </div>
                            <input class="profile-pic-uploader" name="image" type="file" id="inputFile" accept=".png, .jpg, .jpeg">
                            <div class="pic-container">
                                <img id="uploadedImage" src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="profile-picture">
                                <span>ფოტოს ატვირთვა</span>
                            </div>
                            <div class="profile-pic-upload profile-pic-upload__registration">
                                <img src="{{ asset('img/icons/pencil-white.svg') }}" alt="img upload">
                            </div>
                            
                        </div> -->
                        <div class="form__group mb-4 skip-animation file-uploader org-reg-upload-img">
                            <div class="form__label">ატვირთე ფოტო </div>
                            <label for="inputFile">
                                <div class="form__input input-file input-bg photo img-src">
                                  <div> 
                                    <span>ფოტოს ატვირთვა</span>
                                    <span>მოცულობა: 20MB</span>
                                  </div>
                                </div>
                                <!-- <img  src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="profile-picture"> -->
                                <input name="image" type="file" id="inputFile" style="display: none;" accept=".png, .jpg, .jpeg">
                            </label>
                            <div class="form__input input-file img-src--filled pr-1">
                                <div class="file-name"></div>
                                <img class="org-prof-img-uploaded" src="" alt="">
                                <img src="{{ asset('img/icons/x-blue.svg') }}" alt="delete" draggable="false" class="delete-img">
                            </div>
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div default-text='ფოტოს ფორმატი: jpg, jpeg, png. ზომა: 3:4' alt-text='ფაილი აღემატება დასაშვებ ზომას'>ფოტოს ფორმატი: jpg, jpeg, png. ზომა: 3:4</div>
                            </div>
                        </div>
                        
                        {{-- <div class="form__group form__group--half form__group--hidden input-employees" style="visibility:hidden; opacity: 0;">
                            <select name="number_of_employees_id" id="number-of-employees" class="form__input input-bg">
                                <option value=""></option>
                                @foreach($numberOfEmployees as $index=>$number)
                                <option value="{{ $number->id }}" @if($index==0) selected @endif>{{ $number->min . '-' . $number->max }}</option>
                        @endforeach
                        </select>
                        <label for="number-of-employees" class="form__label">თანამშრომლების რაოდენობა</label>
                    </div> --}}

                    <!-- <div class="form__group form__group--half">
                            <input type="text" class="form__input" id="address" name="info_address" value="@if(old('address')){{old('address')}}@endif" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                            <label for="address" class="form__label">მისამართი
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label>
                            <div class="form__tooltip form__tooltip--light">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>აუცილებელი ველი</div>
                            </div>
                        </div> -->
                </div>
                <div class="wizard__tab wizard__tab--md wizard__tab--description">
                    <div class="tab__title firago firago--sm firago--normal">ორგანიზაციის საქმიანობის აღწერა
                        <span class="required">
                            <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                        </span>
                    </div>
                    <div class="form__group textarea-group mb-7">
                        <textarea id="saqmianobis-sfero" maxlength="400" cols="30" rows="5" class="form__input" name="description1" placeholder="აღწერე ორგანიზაციის საქმიანობა, მისია და ა.შ. მაქსიმუმ 400 სიმბოლოთი"></textarea>
                        <!-- <label for="saqmianobis-sfero" class="form__label">საქმიანობის აღწერა ორგანიზაციის საჯარო პროფილისთვის
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label> -->
                        <div class="textarea-subtext">აღწერე ორგანიზაციის საქმიანობა, მისია და ა.შ. მაქსიმუმ 400 სიმბოლოთი</div>
                        <div class="form__tooltip form__tooltip--error">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>აუცილებელი ველი</div>
                        </div>
                    </div>
                </div>
                <div class="wizard__tab wizard__tab--registration-place">
                    <div class="left-wrapper">
                        <div class="left country">
                            <div class="firago firago--normal firago--sm org-reg-place-title">ორგანიზაციის რეგისტრაციის ადგილი</div>
                            <label class="checkbox-container required-address">
                                <input type="radio" name="is_georgia" value="1" checked>
                                <span class="checkmark radio not-radio"></span>
                                <div class="firago firago--normal firago--sm">ადგილობრივი</div>
                            </label>
                            <label class="checkbox-container required-address mb-1">
                                <input type="radio" name="is_georgia" value="0">
                                <span class="checkmark radio not-radio"></span>
                                <div class="firago firago--normal firago--sm">საერთაშორისო</div>
                            </label>
                            <div class="form__group disabled mb-2">
                                <label for="foreign-address" class="form__label add-required org-reg-subtitle">ქვეყანა, ქალაქი, მისამართი</label>
                                <input type="text" class="form__input" id="foreign-address" name="address_text" disabled>
                            </div>
                        </div>
                        <!-- <div class="firago firago--normal firago--sm add-required date-title org-reg-subtitle ">ორგანიზაციის რეგისტრაციის თარიღი</div>
                        <div class="form__group mb-1">
                            <input type="text" class="form__input user-input input-bg readonly data-picker-plain" name="registration_date" data-toggle="datepicker" readonly bg-url="url(/img/icons/arrow-down-white.svg)">
                        </div> -->
                    </div>
                    <div class="right address-dropdowns active mb-2 ">
                      
                        <div class="inputs mt-2">
                            
                            <div class="form__group form__group--dropdown linked">
                                <div class="firago firago--normal firago--sm add-required org-reg-subtitle">რეგიონი</div>
                                <div class="dropdown-right-trigger">
                                    <input type="text" class="form__input readonly ellipsis" placeholder="აირჩით რეგიონი" readonly disabled>
                                </div>
                                <div class="form__group-arrow">
                                    <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                </div>
                                <div class="dropdown-right dropdown-regions active selected">
                                    <div class="dropdown-right__content">
                                        @foreach($regions as $region)
                                        <label class="no-checkmark radio">
                                            <input type="radio" name="region" value="{{$region->id}}">
                                            <span>{{ $region->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form__group form__group--dropdown disabled linked">
                                <div class="firago firago--normal firago--sm add-required org-reg-subtitle">მუნიციპალიტეტი</div>
                                <div class="dropdown-right-trigger">
                                    <input type="text" class="form__input readonly ellipsis" placeholder="აირჩით მუნიციპალიტეტი" readonly disabled>
                                </div>
                                <div class="form__group-arrow">
                                    <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                </div>
                                @foreach($regions as $region)
                                <div class="dropdown-right dropdown-regions" data-region-id="{{ $region->id }}">
                                    <div class="dropdown-right__content">
                                        @foreach($region->municipalities as $municipality)
                                        <label class="no-checkmark radio">
                                            <input type="radio" name="municipality" value="{{ $municipality->id }}">
                                            <span>{{ $municipality->name }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="form__group disabled">
                                <div class="firago firago--normal firago--sm add-required org-reg-place-title">იურიდიული მისამართი</div>
                                <input type="text" class="form__input user-input" name="address_text" disabled>
                            </div>
                            <div class="form__group address-matching">
                                <div class="firago firago--normal firago--sm org-reg-place-title mb-0">მისამართი</div>
                                <div class="firago firago--normal firago--sm line-height-1-3 mb-2 org-reg-subtitle">ფაქტობრივი მისამართი ემთხვევა თუ არა იურიდიულს</div>
                                <div class="address-toggle mt-2">
                                    <label class="checkbox-container  left w-100">
                                        <div class="firago firago--normal firago--sm toggle-title active">კი</div>
                                        <input type="radio" value="1" name="addresses_match" class="ignore" hidden checked>
                                        <span class="checkmark radio not-radio"></span>

                                    </label>
                                    <!-- <div class="toggle">
                                        <span class="slider"></span>
                                    </div> -->
                                    <label class="checkbox-container  right w-100">
                                        <div class="firago firago--normal firago--sm toggle-title">არა</div>
                                        <input type="radio" value="0" name="addresses_match" class="ignore" hidden>
                                        <span class="checkmark radio not-radio"></span>

                                    </label>
                                </div>
                            </div>
                            <!-- <div class="form__group  mb-2">
                                <div class="firago firago--normal firago--sm add-required org-reg-place-title">იურიდიული მისამართი</div>
                                <input type="text" class="form__input user-input" name="address_text" >
                            </div> -->
                            <div class="form__group actual-address ">
                                <div class="firago firago--normal firago--sm add-required org-reg-subtitle">ფაქტობრივი მისამართი</div>
                                <input type="text" class="form__input user-input" name="info_address" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="left-wrapper mt-4">
                      <div class="firago firago--normal firago--sm add-required date-title org-reg-subtitle ">ორგანიზაციის რეგისტრაციის თარიღი</div>
                      <div class="form__group mb-4">
                          <input type="text" class="form__input user-input input-bg readonly data-picker-plain" name="registration_date" data-toggle="datepicker" readonly bg-url="url(/img/icons/arrow-down-white.svg)">
                      </div>
                    </div>
                </div>
                <div class="wizard__tab wizard__tab--checkboxes wizard__tab--org-type input-in-checkboxes">
                    <div class="tab-header">
                        <div class="firago firago--normal firago--sm add-required">ორგანიზაციის ტიპი</div>
                        <span>მიუთითეთ ის კატეგორია, რომელიც ფიქრობთ რომ თქვენს შესაძლებლობას შეესაბამება</span>
                        <!-- <div class="toggle-container">
                            <label class="left">
                                <div class="firago firago--normal firago--sm toggle-title active">ადგილობრივი</div>
                                <input type="radio" value="local" name="type" class="ignore" hidden checked>
                            </label>
                            <div class="toggle">
                                <span class="slider"></span>
                            </div>
                            <label class="right">
                                <div class="firago firago--normal firago--sm toggle-title">საერთაშორისო</div>
                                <input type="radio" value="international" name="type" class="ignore" hidden>
                            </label>
                        </div> -->
                    </div>
                    <div class="status-container mb-3">
                        <!-- <div class="hint top no-after">
                            <svg viewBox="0 0 5 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.94968 0.5C3.67112 0.5 3.40397 0.608619 3.207 0.801964C3.01003 0.995308 2.89937 1.25754 2.89937 1.53097C2.89937 1.8044 3.01003 2.06663 3.207 2.25997C3.40397 2.45332 3.67112 2.56194 3.94968 2.56194C4.22825 2.56194 4.4954 2.45332 4.69237 2.25997C4.88934 2.06663 5 1.8044 5 1.53097C5 1.25754 4.88934 0.995308 4.69237 0.801964C4.4954 0.608619 4.22825 0.5 3.94968 0.5ZM3.69761 3.77848C2.86436 3.84721 0.588675 5.62735 0.588675 5.62735C0.448633 5.73045 0.490646 5.72357 0.602679 5.91602C0.714713 6.1016 0.700709 6.11534 0.833749 6.02599C0.973791 5.93664 1.20486 5.7923 1.58998 5.55862C3.07442 4.62387 1.82805 6.78203 1.19086 10.4179C0.93878 12.2187 2.59128 11.2908 3.0184 11.0159C3.43853 10.7478 4.56587 9.98491 4.6779 9.90931C4.83195 9.80621 4.71992 9.72373 4.60088 9.5519C4.51686 9.43506 4.43283 9.51754 4.43283 9.51754C3.97769 9.81308 3.14444 10.4317 3.03241 10.0399C2.89937 9.64813 3.75363 6.96074 4.22277 5.11187C4.29979 4.67199 4.50985 3.70975 3.69761 3.77848Z" fill="white" />
                            </svg>
                            <span>მოცემული კატეგორიებიდან თქვენ შეგიძლიათ მხოლოდ ერთის არჩევა</span>
                        </div>
                        <div class="firago firago--normal firago--sm title add-required">სტატუსი</div> -->
                        <div class="org-status checkboxes width-option-other">
                            @foreach ($companyStatuses as $id => $status)
                            @if (!$status->can_be_filled)
                            <label class="checkbox-container">
                                <input type="radio" name="company_status_id" value="{{$status->id}}">
                                <span class="checkmark radio not-radio"></span>
                                <div class="firago firago--normal firago--sm">{{$status->name}}</div>
                            </label>
                            @else
                            <div class="option-other">
                                <label class="checkbox-container">
                                    <input type="radio" name="company_status_id" value="{{$status->id}}" class="other-radio" checked>
                                    <span class="checkmark radio not-radio"></span>
                                    <div class="firago firago--normal firago--sm">{{$status->name}}</div>
                                </label>
                                <div class="form__group skip-animation">
                                    <input type="text" class="form__input" name="company_status_description" value=" ">
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- <div class="wizard__tab wizard__tab--checkboxes wizard__tab--activities1 wizard__tab--md">
                    <div class="firago firago--normal firago--sm w-100 add-required">არის თუ არა ორგანიზაცია საერთაშორისო?</div>
                    <div class="hint top w-100 no-after">
                        <svg viewBox="0 0 5 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.94968 0.5C3.67112 0.5 3.40397 0.608619 3.207 0.801964C3.01003 0.995308 2.89937 1.25754 2.89937 1.53097C2.89937 1.8044 3.01003 2.06663 3.207 2.25997C3.40397 2.45332 3.67112 2.56194 3.94968 2.56194C4.22825 2.56194 4.4954 2.45332 4.69237 2.25997C4.88934 2.06663 5 1.8044 5 1.53097C5 1.25754 4.88934 0.995308 4.69237 0.801964C4.4954 0.608619 4.22825 0.5 3.94968 0.5ZM3.69761 3.77848C2.86436 3.84721 0.588675 5.62735 0.588675 5.62735C0.448633 5.73045 0.490646 5.72357 0.602679 5.91602C0.714713 6.1016 0.700709 6.11534 0.833749 6.02599C0.973791 5.93664 1.20486 5.7923 1.58998 5.55862C3.07442 4.62387 1.82805 6.78203 1.19086 10.4179C0.93878 12.2187 2.59128 11.2908 3.0184 11.0159C3.43853 10.7478 4.56587 9.98491 4.6779 9.90931C4.83195 9.80621 4.71992 9.72373 4.60088 9.5519C4.51686 9.43506 4.43283 9.51754 4.43283 9.51754C3.97769 9.81308 3.14444 10.4317 3.03241 10.0399C2.89937 9.64813 3.75363 6.96074 4.22277 5.11187C4.29979 4.67199 4.50985 3.70975 3.69761 3.77848Z" fill="white" />
                        </svg>
                        <span>მოცემული კატეგორიებიდან თქვენ შეგიძლიათ მხოლოდ ერთის არჩევა</span>
                    </div>
                    <label class="checkbox-container">
                        <input type="radio" name="areal" value="international">
                        <span class="checkmark radio"></span>
                        <div class="firago firago--normal firago--sm">კი</div>
                    </label>
                    <label class="checkbox-container">
                        <input type="radio" name="areal" value="local" checked>
                        <span class="checkmark radio"></span>
                        <div class="firago firago--normal firago--sm">არა</div>
                    </label>
                </div> -->
                <div class="wizard__tab wizard__tab--activities2">
                    <div class="org-registr-place-country">
                      <div class="firago firago--normal firago--sm w-100 add-required  org-reg-place-title ">ორგანიზაციის სამოქმედო არეალი</div>
                      <!-- <div class="hint top w-100 no-after mt-2 mb-2">
                          <svg viewBox="0 0 5 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M3.94968 0.5C3.67112 0.5 3.40397 0.608619 3.207 0.801964C3.01003 0.995308 2.89937 1.25754 2.89937 1.53097C2.89937 1.8044 3.01003 2.06663 3.207 2.25997C3.40397 2.45332 3.67112 2.56194 3.94968 2.56194C4.22825 2.56194 4.4954 2.45332 4.69237 2.25997C4.88934 2.06663 5 1.8044 5 1.53097C5 1.25754 4.88934 0.995308 4.69237 0.801964C4.4954 0.608619 4.22825 0.5 3.94968 0.5ZM3.69761 3.77848C2.86436 3.84721 0.588675 5.62735 0.588675 5.62735C0.448633 5.73045 0.490646 5.72357 0.602679 5.91602C0.714713 6.1016 0.700709 6.11534 0.833749 6.02599C0.973791 5.93664 1.20486 5.7923 1.58998 5.55862C3.07442 4.62387 1.82805 6.78203 1.19086 10.4179C0.93878 12.2187 2.59128 11.2908 3.0184 11.0159C3.43853 10.7478 4.56587 9.98491 4.6779 9.90931C4.83195 9.80621 4.71992 9.72373 4.60088 9.5519C4.51686 9.43506 4.43283 9.51754 4.43283 9.51754C3.97769 9.81308 3.14444 10.4317 3.03241 10.0399C2.89937 9.64813 3.75363 6.96074 4.22277 5.11187C4.29979 4.67199 4.50985 3.70975 3.69761 3.77848Z" fill="white" />
                          </svg>
                          <span>მოცემული კატეგორიებიდან თქვენ შეგიძლიათ მხოლოდ ერთის არჩევა</span>
                      </div> -->
                      <label class="checkbox-container mb-1">
                          <input type="radio" name="areal" value="international">
                          <span class="checkmark radio not-radio"></span>
                          <div class="firago firago--normal firago--sm">საერთაშორისო</div>
                      </label>
                      <label class="checkbox-container">
                          <input type="radio" name="areal" value="local" checked>
                          <span class="checkmark radio not-radio"></span>
                          <div class="firago firago--normal firago--sm">ადგილობრივი</div>
                      </label>
                    </div>
                    <div class="firago firago--normal firago--sm w-100 tab-title add-required  org-reg-place-title mb-3">ორგანიზაციის საქმიანობის გეოგრაფიული არეალი</div>
                    <div class="right-dropdowns" style="display: none;">
                        <div class="form__group form__group--dropdown form__group-regions">
                            <div class="firago firago--normal firago--sm">რეგიონი</div>
                            <div class="dropdown-right-trigger">
                                <input type="text" class="form__input readonly ellipsis" placeholder="აირჩით რეგიონი" readonly disabled>
                            </div>
                            <div class="form__group-arrow">
                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                            </div>
                            <div class="dropdown-right regions-multiple with-master-checkbox">
                                <div class="dropdown-right__content multiple-selection">
                                    <label class="checkbox-container master">
                                        <input type="checkbox" name="">
                                        <span class="checkmark"></span>
                                        <span class="firago firago--normal firago--sm">ყველას მონიშვნა</span>
                                    </label>
                                    @foreach ($regions as $region)
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="area_regions[]" value="{{$region->id}}">
                                        <span class="checkmark"></span>
                                        <span class="firago firago--normal firago--sm">{{$region->name}}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div class="selected-regions">
                                <!-- <div class="selected-region">აჭარა
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">შიდა ქართლი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">კახეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">სამცხე-ჯავახეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">იმერეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">აჭარა
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">შიდა ქართლი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">კახეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">სამცხე-ჯავახეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">იმერეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div>
                                    <div class="selected-region">სამეგრელო და ზემო სვანეთი
                                        <img src="{{ asset('img/icons/x-white-rect.svg') }}" alt="remove" draggable="false">
                                    </div> -->
                            </div>
                        </div>
                        <div class="form__group form__group--dropdown special disabled">
                            <div class="firago firago--normal firago--sm">მუნიციპალიტეტი</div>
                            <input type="text" class="form__input" placeholder="აირჩით მუნიციპალიტეტი" disabled>
                            <div class="form__group-arrow search-button">
                                <img src="{{ asset('img/icons/search-white.svg') }}" alt="search" draggable="false">
                            </div>
                            <div class="dropdown-right municipalities">
                                <div class="dropdown-right__content">
                                    @foreach ($regions as $region)
                                    @foreach ($region->municipalities as $municipality)
                                    <label class="no-checkmark municipality">
                                        <input name="area_municipalities[]" type="checkbox" data-id-region="{{$region->id}}" value="{{$municipality->id}}">
                                        <img src="{{ asset('img/icons/checkmark-white.svg') }}" alt="checkmark" draggable="false">
                                        <span>{{$municipality->name}}</span>
                                    </label>
                                    @endforeach
                                    @endforeach
                                    <div class="no-checkmark no-result">
                                        <span>მონაცემები არ მოიძებნა</span>
                                    </div>
                                </div>
                            </div>
                            <div class="selected-municipalities">
                            </div>
                        </div>
                    </div>
                    <div class="select-section-wrapper mb-3">
                        <div class="select-section select-section--light">
                            <div class="filter__dropdown regions">
                                <label id="filter-by-municipalities-all" class="checkbox-container checkbox-container--red checkbox-container--white all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach ($regions as $region)
                                <label class="checkbox-container sub-item checkbox-container--red checkbox-container--white">
                                    <input type="checkbox" data-id="{{$region->id}}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{$region->name}}</div>
                                </label>
                                @endforeach
                            </div>
                            <div class="municipalities-wrapper">
                                <!-- <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div> -->
                                <div class="municipality-sections-wrapper">
                                    @foreach ($regions as $region)
                                    <div class="municipality-section" data-region-id="{{$region->id}}">
                                        <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                                        <div class="filter__dropdown municipalities-dropdown">
                                            <label class="checkbox-container mobile checkbox-container--red checkbox-container--white all-checkmark uncheck-all">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <div class="title">{{$region->name}}</div>
                                                <img src="{{ asset('/img/icons/chevron-down-white.svg') }}" />
                                            </label>
                                            <label class="checkbox-container desktop checkbox-container--red checkbox-container--white all-checkmark uncheck-all">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                                <div class="title">ყველა</div>
                                            </label>
                                            <div class="separator separator-static"></div>
                                            @foreach ($region->municipalities as $municipality)
                                            <label id="filter-by-municipalities" class="checkbox-container sub-item checkbox-container--red checkbox-container--white">
                                                <input type="checkbox" data-id="{{$municipality->id}}">
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
                </div>
                <div class="wizard__tab wizard__tab--fields wizard__tab--checkboxes input-in-checkboxes">
                    <div class="left fields">
                        <div class="firago firago--normal firago--sm tab-title add-required">ორგანიზაციის საქმიანობის ტიპები</div>
                        <div class="hint top no-after">
                            <svg viewBox="0 0 5 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.94968 0.5C3.67112 0.5 3.40397 0.608619 3.207 0.801964C3.01003 0.995308 2.89937 1.25754 2.89937 1.53097C2.89937 1.8044 3.01003 2.06663 3.207 2.25997C3.40397 2.45332 3.67112 2.56194 3.94968 2.56194C4.22825 2.56194 4.4954 2.45332 4.69237 2.25997C4.88934 2.06663 5 1.8044 5 1.53097C5 1.25754 4.88934 0.995308 4.69237 0.801964C4.4954 0.608619 4.22825 0.5 3.94968 0.5ZM3.69761 3.77848C2.86436 3.84721 0.588675 5.62735 0.588675 5.62735C0.448633 5.73045 0.490646 5.72357 0.602679 5.91602C0.714713 6.1016 0.700709 6.11534 0.833749 6.02599C0.973791 5.93664 1.20486 5.7923 1.58998 5.55862C3.07442 4.62387 1.82805 6.78203 1.19086 10.4179C0.93878 12.2187 2.59128 11.2908 3.0184 11.0159C3.43853 10.7478 4.56587 9.98491 4.6779 9.90931C4.83195 9.80621 4.71992 9.72373 4.60088 9.5519C4.51686 9.43506 4.43283 9.51754 4.43283 9.51754C3.97769 9.81308 3.14444 10.4317 3.03241 10.0399C2.89937 9.64813 3.75363 6.96074 4.22277 5.11187C4.29979 4.67199 4.50985 3.70975 3.69761 3.77848Z" fill="white" />
                            </svg>
                            <span>მოცემული კატეგორიებიდან აირჩიეთ ერთი ან რამდენიმე</span>
                        </div>
                        <div class="checkboxes-wrapper">
                            <label class="checkbox-container master">
                                <input type="checkbox" name="" value="">
                                <span class="checkmark"></span>
                                <span class="firago firago--normal firago--sm">ყველას მონიშვნა</span>
                            </label>
                            @foreach ($companyWorkignTypes as $type)
                            @if (!$type->can_be_filled)
                            <label class="checkbox-container">
                                <input type="checkbox" name="working_types[]" value="{{$type->id}}">
                                <span class="checkmark"></span>
                                <span class="firago firago--normal firago--sm">{{$type->name}}</span>
                                <div class="hint hint--fixed">
                                    <svg viewBox="0 0 5 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3.94968 0.5C3.67112 0.5 3.40397 0.608619 3.207 0.801964C3.01003 0.995308 2.89937 1.25754 2.89937 1.53097C2.89937 1.8044 3.01003 2.06663 3.207 2.25997C3.40397 2.45332 3.67112 2.56194 3.94968 2.56194C4.22825 2.56194 4.4954 2.45332 4.69237 2.25997C4.88934 2.06663 5 1.8044 5 1.53097C5 1.25754 4.88934 0.995308 4.69237 0.801964C4.4954 0.608619 4.22825 0.5 3.94968 0.5ZM3.69761 3.77848C2.86436 3.84721 0.588675 5.62735 0.588675 5.62735C0.448633 5.73045 0.490646 5.72357 0.602679 5.91602C0.714713 6.1016 0.700709 6.11534 0.833749 6.02599C0.973791 5.93664 1.20486 5.7923 1.58998 5.55862C3.07442 4.62387 1.82805 6.78203 1.19086 10.4179C0.93878 12.2187 2.59128 11.2908 3.0184 11.0159C3.43853 10.7478 4.56587 9.98491 4.6779 9.90931C4.83195 9.80621 4.71992 9.72373 4.60088 9.5519C4.51686 9.43506 4.43283 9.51754 4.43283 9.51754C3.97769 9.81308 3.14444 10.4317 3.03241 10.0399C2.89937 9.64813 3.75363 6.96074 4.22277 5.11187C4.29979 4.67199 4.50985 3.70975 3.69761 3.77848Z" fill="white" />
                                    </svg>
                                    <span>{{$type->description}}</span>
                                </div>
                            </label>
                            @else
                            <div class="option-other">
                                <label class="checkbox-container checkbox-container--other">
                                    <input type="checkbox" value="{{$type->id}}" name="working_types[]" class="other-checkbox" checked>
                                    <span class="checkmark"></span>
                                    <div class="firago firago--normal firago--sm">{{$type->name}}</div>
                                </label>
                                <div class="form__group skip-animation">
                                    <input type="text" class="form__input" name="working_type_description[{{$type->id}}]" value=" ">
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="right">
                        <div class="firago firago--normal firago--sm tab-title">ორგანიზაციის საქმიანობის ქვეტიპები</div>
                        @foreach ($companyWorkignTypes as $type)
                        <div class="subfields">
                            @foreach ($type->CompanyWorkingSubtype as $subtype)
                            <div class="subfield">{{$subtype->name}}</div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- <div class="wizard__tab wizard__tab--checkboxes wizard__tab--md">
                        <div class="firago firago--normal firago--md mb-3 w-100 line-height-1-2">მონიშნე ორგანიზაციის საქმიანობის არეალი (შესაძლებელია 1-ზე მეტი არეალის მონიშვნა)</div>
                        <div class="warning warning--lg mb-3">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>გასაგრძელებლად მონიშნეთ ერთი ან რამდენიმე</div>
                        </div>
                        <div class="checkboxes mb-3">
                            @foreach($regions as $region)
                            <label class="checkbox-container mb-3 mt-1">
                                <input type="checkbox" name="regions[]" value="{{ $region->id }}">
                                <span class="checkmark"></span>
                                <div class="firago firago--normal firago--sm">{{ $region->name }}</div>
                            </label>
                            @endforeach
                        </div>
                    </div> -->
                <!-- <div class="wizard__tab wizard__tab--checkboxes wizard__tab--md">
                        <div class="firago firago--normal firago--md mb-3 w-100">აირჩიე ორგანიზაციის საქმიანობა</div>
                        <div class="warning warning--lg mb-3">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>გასაგრძელებლად მონიშნეთ ერთი ან რამდენიმე</div>
                        </div>
                        <div class="checkboxes mb-3">
                            @foreach($categories as $category)
                            @if($category->has_description)
                            <div class="option-other">
                                <label class="checkbox-container mb-3 mt-1">
                                    <input type="checkbox" name="categories[]" value="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="firago firago--normal firago--sm">{{ $category->name }}</div>
                                </label>
                                <div class="form__group disabled">
                                    <input type="text" class="form__input" id="other-region" name="category_description" disabled>
                                    <div class="form__tooltip form__tooltip--light">
                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                        <div>აუცილებელი ველი</div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <label class="checkbox-container mb-3 mt-1">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                                <span class="checkmark"></span>
                                <div class="firago firago--normal firago--sm">{{ $category->name }}</div>
                            </label>
                            @endif
                            @endforeach
                            <div class="option-other">
                                <label class="checkbox-container mb-3 mt-1">
                                    <input type="checkbox" name="regions[]" value="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="firago firago--normal firago--sm">სხვა</div>
                                </label>
                                <div class="form__group disabled">
                                    <input type="text" class="form__input" id="other-region" name="" disabled>
                                    <div class="form__tooltip form__tooltip--light">
                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                        <div>აუცილებელი ველი</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form__tooltip">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>გასაგრძელებლად მონიშნეთ ერთი ან რამდენიმე</div>
                        </div>
                    </div> -->
                <!-- <div class="wizard__tab wizard__tab--lg align-content-start wizard__tab--socials">
                    <div class="form__group form__group--third">
                        <input type="text" class="form__input" id="facebook" name="fb_page" value="@if(old('fb_page')){{old('fb_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                        <label for="facebook" class="form__label">facebook</label>
                    </div>
                    <div class="form__group form__group--third">
                        <input type="text" class="form__input" id="linkedin" name="linkedin_page" value="@if(old('linkedin_page')){{old('linkedin_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                        <label for="linkedin" class="form__label">linkedin</label>
                    </div>
                    <div class="form__group form__group--third">
                        <input type="text" class="form__input" id="webpage" name="web_page" value="@if(old('web_page')){{old('web_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                        <label for="webpage" class="form__label">webpage</label>
                    </div>
                    <div class="form__group form__group--half file-uploader" style="display: none">
                        <label for="inputFile">
                            <div class="form__input input-file input-bg photo img-src">ატვირთე დოკუმენტი</div>
                            <input name="document" type="file" id="inpuFile" style="display: none;" accept=".pdf">
                        </label>
                        <div class="form__input input-file input-bg photo img-src--filled">
                            <div class="file-name"></div>
                            <img src="{{ asset('img/icons/x-white.svg') }}" alt="delete" draggable="false" class="delete-img">
                        </div>
                    </div>
                </div> -->
                <div class="wizard__tab wizard__tab--md wizard__tab--password">
                    <div class="form__group ">
                        <label for="facebook" class="form__label">facebook</label>
                        <input type="text" class="form__input" id="facebook" name="fb_page" value="@if(old('fb_page')){{old('fb_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                        
                    </div>
                    <div class="form__group ">
                        <label for="linkedin" class="form__label">linkedin</label>
                        <input type="text" class="form__input" id="linkedin" name="linkedin_page" value="@if(old('linkedin_page')){{old('linkedin_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                        
                    </div>
                    <div class="form__group ">
                        <label for="webpage" class="form__label">webpage</label>
                        <input type="text" class="form__input" id="webpage" name="web_page" value="@if(old('web_page')){{old('web_page')}}@endif" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                    </div>
                    <div class="form__group  file-uploader mb-2" style="display: none">
                        <label for="inputFile">
                            <div class="form__input input-file input-bg photo img-src">ატვირთე დოკუმენტი</div>
                            <input name="document" type="file" id="inpuFile" style="display: none;" accept=".pdf">
                        </label>
                        <div class="form__input input-file input-bg photo img-src--filled">
                            <div class="file-name"></div>
                            <img src="{{ asset('img/icons/x-white.svg') }}" alt="delete" draggable="false" class="delete-img">
                        </div>
                    </div>
                    <div class="line mt-5 mb-4 org-reg-page-pass-line"></div>
                    <div class="form__group">
                         <label for="password" class="form__label">პაროლი
                            <span class="required">
                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                            </span>
                        </label>
                        <input type="password" class="form__input" id="password" name="password" pattern=".{8,}">
                        
                        <div class="password-visible">
                            <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                        </div>
                        <div class="form__tooltip form__tooltip--light">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>პაროლი უნდა შეიცავდეს მინიმუმ 8 სიმბოლოს</div>
                        </div>
                    </div>
                    <div class="form__group ">
                        <label for="password_confirmation" class="form__label">გაიმეორე პაროლი
                            <span class="required">
                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                            </span>
                        </label>
                        <input type="password" class="form__input" id="password_confirmation" name="password_confirmation" pattern=".{8,}">
                       
                        <div class="password-visible">
                            <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                        </div>
                        <div class="form__tooltip form__tooltip--error">
                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                            <div>პაროლები არ ემთხვევა</div>
                        </div>
                    </div>
                    <!-- <div class="code-input-container"> -->
                        <!-- <div class="form__group form__group--half mb-3">
                            <input type="number" class="form__input" id="code" name="code" pattern="^[0-9]{4}$">
                            <label for="code" class="form__label">მიღებული კოდი
                                <span class="required">
                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                </span>
                            </label>
                        </div>
                        <div class="success-icon mb-3 ml-2">
                            <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.176 16.3123L9.80466 13.8256L9 14.6694L12.176 18L19 10.8438L18.1953 10L12.176 16.3123Z" fill="#0AB1B1" />
                                <circle cx="14" cy="14" r="13.5" stroke="#fff" />
                                <rect x="11.0625" y="10.0029" width="10.68" height="1.5" transform="rotate(45 11.0625 10.0029)" fill="#EE3048" />
                                <rect x="10" y="17.552" width="10.68" height="1.5" transform="rotate(-45 10 17.552)" fill="#EE3048" />
                            </svg>
                        </div> -->
                        <!-- <div class="form__group form__group--half line-height-1-3 mb-3">
                                <p class="firago firago--sm text-white">კოდი გამოიგზავნება თქვენს მიერ მითითებულ ელ-ფოსტაზე</p>
                            </div> -->
                    <!-- </div> -->
                    <!-- <div class="mt-2">
                            <div class="code-container">
                                <div class="send-code firago firago--400 firago--italic firago--sm underlined pointer text-white" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>
                                <div class="firago firago--400 firago--italic firago--sm underlined pointer mb-5 text-red" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>
                            </div>
                        </div> -->

                    <!--<div class="code-container organization-code-container mb-9 mt-1 w-100">-->
                    <!--    <div class="send-code button--white" data-alternate-text="კოდის ახლიდან გამოგზავნა">-->
                    <!--        <span>კოდის გამოგზავნა</span>-->
                    <!--        <img src="{{ asset('images/email-red.svg') }}" alt="code">-->
                    <!--        <img src="{{ asset('images/mail-white.svg') }}" alt="code" class="img-disabled">-->
                    <!--        <div class="form__tooltip">-->
                    <!--            <img src="{{ asset('img/icons/info-white.svg') }}" alt="info" draggable="false">-->
                    <!--            <div class="firago--xs">ერთჯერადი კოდი გამოგზავნილია თქვენს ელ. ფოსტაზე</div>-->
                    <!--        </div>-->
                    <!--    </div>-->
                    <!--    <div class="code-timer" id="code-timer">-->
                    <!--    </div>-->
                        <!--<div class="send-code firago firago--400 firago--italic firago--sm pointer text-white" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>
                                   <div class="firago firago--400 firago--italic firago--sm pointer text-red" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>-->
                    <!--</div>-->

                    <!-- @if($errors->has('code'))
                    <div class="warning warning--md mb-3 visible">
                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                        <div>{{ trans($errors->first()) }}</div>
                    </div>
                    @endif -->

                    <div class="w-100 mb-5">
                        <div class="d-flex align-items-center confirmation-checkbox mt-3">
                            <label class="checkbox-container mb-1 mt-1">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <div class="firago firago--300 firago--italic firago--sm">ვეთანხმები&nbsp;</div>
                            </label>
                            <div class="underlined firago firago--300 firago--italic firago--sm privacy-button pointer privacy-policy-button">
                                კონფიდენციალურობის პოლიტიკას</div>
                        </div>
                        <div class="d-flex align-items-center confirmation-checkbox mb-3">
                            <label class="checkbox-container mb-1 mt-1">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <div class="firago firago--300 firago--italic firago--sm">ვეთანხმები&nbsp;</div>
                            </label>
                            <div class="underlined firago firago--300 firago--italic firago--sm terms-button pointer terms-button">
                                წესებსა და პირობებს</div>
                        </div>
                        <!-- <div class="d-flex align-items-center mb-1">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="firago firago--300 firago--italic firago--sm">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--sm privacy-button pointer privacy-policy-button">
                                    კონფიდენციალურობის პოლიტიკას</div>
                            </div>
                            <div class="d-flex align-items-center mb-1">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="firago firago--300 firago--italic firago--sm">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--sm terms-button pointer terms-button">
                                    წესებსა და პირობებს</div>
                            </div> -->
                    </div>
                </div>
        </div>
        <div class="link-fancy next-step mb-4">
            <div class="title">გაგრძელება</div>
            <div class="attribute">
              <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
            </div>
        </div>
        <div class="final-registration-container">
            <div class="button button--red final-registration  disabled-2 next-step mb-4" style="display:none">
                <span class="d-inline-block">რეგისტრაცია</span>
                <!-- <img src="{{ asset('img/icons/registration-button-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
            </div>
        </div>
        </form>
    </div>
</div>
</div>


@endsection
