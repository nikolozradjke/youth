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
$pageTitle = 'ახალგაზრდა მუშაკის რეგისტრაცია';
$className = 'user-registration-nav';
@endphp

<div class="wrapper user-worker-registration-page">
    @include('templates.userAreaNav')
    <div class="blue-container blue-container--inner d-flex blue-layout-md user-registration-main">
        <div class="w-100">
            <div class="registration-container">
                <div class="heading heading--fancy heading--fancy-white">{{ $pageTitle }}</div>
                <div class="wizard__header">
                    <img class="first-tab disabled" src="{{asset('/images/chevrons.svg')}}" alt="go to first tab" draggable="false" />
                    <img class="prev-tab disabled" src="{{asset('img/icons/back-white.svg')}}" alt="go back" draggable="false" />
                    <div class="wizard__steps">
                        <div class="wizard__step active">
                            1. პირადი ინფორმაცია
                        </div>
                        <!-- <div class="wizard__step">
                            02. მოკლედ ჩემ შესახებ
                        </div> -->
                        <div class="wizard__step">
                            2. მიმდინარე საქმიანობა
                        </div>
                        <!-- <div class="wizard__step">
                            03. განათლება
                        </div> -->
                        <div class="wizard__step">
                            3. საცხოვრებელი ადგილი
                        </div>
                        <div class="wizard__step">
                            4. პაროლი
                        </div>
                        <!-- <div class="wizard__step">
                            06. კოდი
                        </div> -->
                        <div class="wizard__indicator">
                            <span class="bar"></span>
                        </div>
                    </div>
                    <img class="next-tab" src="{{asset('img/icons/back-white.svg')}}" alt="go to next tab" draggable="false" />
                    <img class="last-tab" src="{{asset('/images/chevrons.svg')}}" alt="go to last tab" draggable="false" />
                </div>
                <form action="{{ route('youngWorkerRegistration') }}" method="POST" autocomplete="off" class="form-registration" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}
                    <input name="company" value="1" hidden>
                    <div class="wizard__tabs wizard__tabs--user">
                        <div class="wizard__tab active wizard__tab--checkboxes input-in-checkboxes user-main-info-tab ">
                            <div class="tab-content-wrapper justify-content-center">
                                <!-- <div class="profile-pic profile-pic__registration  ml-1">
                                    <input class="profile-pic-uploader" name="image" type="file" id="inputFile" accept=".png, .jpg, .jpeg">
                                    <div class="pic-container">
                                        <img id="uploadedImage" src="{{ asset('/storage/images/default-avatar.png') }}" alt="profile-picture">
                                    </div>
                                    <div class="profile-pic-upload profile-pic-upload__registration">
                                        <img src="{{ asset('img/icons/pencil-white.svg') }}" alt="img upload">
                                    </div>
                                    <div class="upload-text-wrapper">
                                        <div class="upload-text__registration firago firago--sm firago--normal">ატვირთე ფოტო</div>
                                    </div>
                                </div> -->
                                <div class="tab-form-group-wrapper">
                                    <div class="form__group ">
                                        <label for="fb-link" class="form__label">facebook ლინკი</label>
                                        
                                        <input type="url" placeholder="მიუთითეთ ლინკი" class="form__input" id="fb-link" name="fb-link" value="" registration-type="user">
                                        
                                    </div>
                                    <div class="form__group ">
                                        <label for="name" class="form__label">
                                            სახელი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" placeholder="ჩაწერეთ სახელი" class="form__input" id="name" name="first_name" pattern="[a-zA-Z0-9]+|[ა-ჰ]" value="@if(old('fist_name')){{old('first_name')}}@endif">
                                        
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>
                                    <div class="form__group ">
                                        <label for="last-name" class="form__label">გვარი
                                            <span class="required">
                                                <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                            </span>
                                        </label>
                                        <input type="text" placeholder="ჩაწერეთ გვარი" class="form__input" id="last-name" name="last_name" pattern="[a-zA-Z0-9]+|[ა-ჰ]" value="@if(old('last_name')){{old('last_name')}}@endif">
                                        
                                        <div class="form__tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>აუცილებელი ველი</div>
                                        </div>
                                    </div>
                                    <div class="form__group ">
                                        <label for="birth-date" class="form__label">დაბადების თარიღი</label>
                                        <!-- bg-url="url(/img/icons/bdate.svg)" 
                                        bg-url-active="url(/img/icons/bdate-blue.svg)"  -->
                                        <input readonly placeholder="მიუთითეთ დაბადების თარიღი" type="text" class="form__input input-bg bdate hasDatepicker" id="birth-date" name="birth_date" value="@if(old('birth_date')){{old('birth_date')}}@endif" 
                                        data-toggle="datepicker" readonly>
                                        
                                    </div>
                                    <div class="form__group ">
                                        <label for="private-number" class="form__label">პირადი ნომერი</label>
                                        <input placeholder="ჩაწერეთ პირადი ნომერი" autocomplete="off" type="text" class="form__input" id="private-number" name="private_number" maxlength="11" pattern="^[0-9]{11}|^$" value="@if(old('private_number')){{old('private_number')}}@endif">
                                       
                                        <div class="form__tooltip form__tooltip--light">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>გთხოვთ მიუთითოთ 11 ნიშნა კოდი (გამოიყენეთ მხოლოდ ციფრები)</div>
                                        </div>
                                    </div>
                                    <div class="form__group select__group">
                                        <!-- <label for="private-number" class="form__label">სქესი</label> -->
                                        <!-- <select name="gender" id="" class="form__input input-bg" pattern="[a-zA-Z0-9]+|[ა-ჰ]|^$" bg-url="url(/img/icons/arrow-down-select.svg)" bg-url-active="url(/img/icons/arrow-down-select-blue.svg)">
                                            <option value=""></option>
                                            <option value="male">მდედრობითი</option>
                                            <option value="female">მამრობითი</option>
                                        </select> -->
                                        <!-- <input type="text" class="form__input" id="gender" value="@if(old('gender')){{old('gender')}}@endif" name="gender"> -->
                                        <!-- <label for="gender" class="form__label">სქესი</label> -->
                                        <label for="gender" class="form__label">სქესი</label>
                                        <select name="gender" id="" class="form__select form__input  input-bg">
                                          <option value="0" selected>აირჩიეთ სქესი</option>
                                          <option value="1">მდედრობითი</option>
                                          <option value="2">მამრობითი</option>
                                          <option value="3">ანონიმური</option>
                                        </select>
                                        
                                    </div>
                                    <div class="form__group ">
                                        <!-- <input type="text" class="form__input" id="phone" name="phone" pattern="^[0-9]{9}|^$" value="@if(old('phone')){{old('phone')}}@endif" registration-type="user"> -->
                                        <label for="phone" class="form__label">მობილურის ნომერი</label>

                                        <input type="text" class="form__input" id="phone" name="phone" value="@if(old('phone')){{old('phone')}}@endif" registration-type="user">
                                        <div class="form__tooltip form__tooltip--light">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>გთხოვთ მიუთითოთ 9 ნიშნა რიცხვი</div>
                                        </div>
                                    </div>

                                    <label class="checkbox-container mb-3">
                                        <input class="form__input" type="checkbox" name="age-check" value="0">
                                        <span class="checkmark radio"></span>
                                        <div class="firago firago--normal firago--sm">საიტზე რეგისტრაციისთვის საჭიროა, რომ თქვენ იყოთ 13+ წლის</div>
                                        <div class="form__tooltip standard-tooltip form__tooltip--error">
                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                            <div>გთხოვთ დაეთანხმოთ მითითებულ პირობას</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="wizard__tab">
                            <div class="user-disablities-wrapper">
                                <div class="firago firago--normal firago--sm">გაქვთ თუ არა რაიმე ტიპის შეზღუდვა</div>
                                @foreach ($userDissabilities as $userDisability)
                                <div class="user-disability disability mt-1 mb-1">
                                    <label class="checkbox-container">
                                        <input name="disability_checks[{{$userDisability->id}}]" type="checkbox" value="0">
                                        <div class="firago firago--normal firago--sm">{{$userDisability->name}}</div>
                                        <span class="checkmark"></span>
                                    </label>

                                    <div class="disability-details">
                                        <label for="disability-{{$userDisability->id}}" class="firago firago--normal firago--sm">დააზუსტეთ შეზღუდვა</label>
                                        <div class="form__group form__group--half">
                                            <input name="disability_descriptions[{{$userDisability->id}}]" id="disability-{{$userDisability->id}}" disabled autocomplete="off" type="text" class="form__input" placeholder="ფიზიკური შეზღუდვის ტიპი">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="user-disability no-disability mt-1">
                                    <label class="checkbox-container">
                                        <input type="checkbox" value="0" checked>
                                        <div class="firago firago--normal firago--sm">არ მაქვს შეზღუდვა</div>
                                        <span class="checkmark radio"></span>
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="wizard__tab user-worker-education-work-tab">
                            <div class="occupation-wrapper education-wrapper mb-4">
                                <div class="firago firago--normal firago--sm mb-4">აირჩიე განათლება</div>
                                <div class="address-dropdowns">
                                <!-- <div class="form__group form__group--dropdown mb-3">
                                    <div class="firago firago--normal firago--sm">თქვენი განათლება</div>
                                    <div class="input-wrapper">
                                        <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ განათლება" readonly>
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                    <div class="dropdown-right dropdown-regions active">
                                        <div class="dropdown-right__content">
                                            @foreach ($userEducations as $id => $val)
                                            <label class="no-checkmark radio">
                                                <input name=' user_education_id' type="radio" value="{{$id}}">
                                        <span>{{$val->name}}</span>
                                        </label>
                                        @endforeach
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form__group form__group--dropdown mb-2">
                                    <div class="firago firago--normal firago--sm">სასწავლო დაწესებულება</div>
                                    <div class="input-wrapper">
                                        <input type="text" name="edu_name" class="form__input ellipsis" placeholder="ჩაწერეთ სასწავლო დაწესებულება">
                                        
                                    </div>
                                        
                                </div>
                                <div class="form__group form__group--dropdown mb-2">
                                    <div class="firago firago--normal firago--sm">აკადემიური ხარისხი</div>
                                    <div class="input-wrapper">
                                        <input type="text" name="edu_grade" class="form__input ellipsis" placeholder="ჩაწერეთ აკადემიური ხარისხი">
                                        
                                    </div>
                                        
                                </div>
                                <div class="form__group form__group--dropdown mb-2">
                                    <div class="firago firago--normal firago--sm">ჩაწერთ ინფორმაცია</div>
                                    <div class="input-wrapper">
                                        <input type="text" name="edu_info" class="form__input ellipsis" placeholder="ჩაწერთ ინფორმაცია">
                                    </div>
                                        
                                </div>
                               
                                <div class="form__group form__group--dropdown mb-2 position-relative">
                                    <div class="firago firago--normal firago--sm">დავასრულე სასწავლებებლი</div>
                                    <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ განათლება" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userEducations as $id => $val)
                                                <label class="no-checkmark radio">
                                                    <input name=' user_education_id' type="radio" value="{{$val->id}}">
                                            <span>{{$val->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- <select name="" id="" class="form__select form__input  input-bg">
                                          <option value="0" selected>აირჩიეთ </option>
                                          <option value="1" >სკოლა </option>
                                          <option value="2" >პროფესიული სასწავლებებლი </option>
                                          <option value="3" >ბაკალავრი </option>
                                          <option value="4" >მაგისტრატურა </option>
                                          <option value="5" >დოქტურანტურა </option>
                                    </select>  -->
                                    <!-- <div class="input-wrapper">
                                        <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ სასწავლებებლი" readonly>
                                        <div class="form__group-arrow">
                                            <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                        </div>
                                    </div>
                                     
                                    <div class="dropdown-right dropdown-regions active">
                                        <div class="dropdown-right__content">
                                            <label class="no-checkmark radio">
                                              <input  type="radio" value="">
                                              <span>სკოლა</span>
                                            </label>
                                            <label class="no-checkmark radio">
                                              <input  type="radio" value="">
                                              <span>პროფესიული სასწავლებებლი</span>
                                            </label>
                                            <label class="no-checkmark radio">
                                              <input  type="radio" value="">
                                              <span>ბაკალავრი</span>
                                            </label>
                                            <label class="no-checkmark radio">
                                              <input  type="radio" value="">
                                              <span>მაგისტრატურა</span>
                                            </label>
                                            <label class="no-checkmark radio">
                                              <input  type="radio" value="">
                                              <span>დოქტურანტურა</span>
                                            </label>
                                        </div>
                                    </div> -->
                                </div>

                                <!-- <div class="other-education">
                                    <div class="firago firago--normal firago--sm">ჯერ კიდევ ვსწავლობ</div>
                                    <div class="form__group form__group--half">
                                        <input name='user_education_description' autocomplete="off" type="text" class="form__input" placeholder="სკოლა, პროფესიული, უმაღლესი">
                                    </div>
                                </div> -->

                                <div class="user-disability no-disability">
                                    <label class="checkbox-container mb-2">
                                        <input type="radio" value="ვსწავლობ" name="study_status">
                                        <div class="firago firago--normal firago--sm">ვსწავლობ</div>
                                        <span class="checkmark radio not-radio"></span>
                                    </label>
                                    <label class="checkbox-container">
                                        <input type="radio" value="არ ვსწავლობ"  name="study-status">
                                        <div class="firago firago--normal firago--sm">არ ვსწავლობ</div>
                                        <span class="checkmark radio not-radio"></span>
                                    </label>
                                </div>
                              </div>
                            </div>
                            <div class="occupation-wrapper">
                                <div class="firago firago--normal firago--sm mb-4">საქმიანობის სფერო
                                  <!-- <span class="additional-info firago--xs">
                                        <img src="{{ asset('img/icons/info-white.svg') }}" alt="info" draggable="false">
                                        <span>დასაშვებია რამდენიმე პასუხის არჩევა</span>
                                    </span> -->
                                  </div>
                                <div class="address-dropdowns">
                                    <!-- <div class="form__group form__group--dropdown mb-3">
                                        <div class="firago firago--normal firago--sm">ვსწავლობ</div>
                                        <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ განათლება" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userOcupationStudy as $study)
                                                <label class="no-checkmark radio">
                                                    <input name="user_ocupation_study_id" type="radio" value="{{$study->id}}">
                                                    <span>{{$study->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form__group form__group--dropdown mb-3">
                                        <div class="firago firago--normal firago--sm">ვმუშაობ</div>
                                        <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userOcupationWork as $work)
                                                <label class="no-checkmark radio">
                                                    <input name="user_ocupation_work_id" type="radio" value="{{$work->id}}">
                                                    <span>{{$work->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group form__group--dropdown mb-3">
                                        <div class="firago firago--normal firago--sm">ვარ</div>
                                        <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userOccupations as $occ)
                                                <label class="no-checkmark radio">
                                                    <input name="user_occupation_id" type="radio" value="{{$occ->id}}">
                                                    <span>{{$occ->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form__group form__group--dropdown mb-2">
                                        <div class="firago firago--normal firago--sm">
                                        საქმიანობის სფერო</div>
                                        <!-- <div class="input-wrapper">
                                            <input type="text" class="form__input ellipsis" placeholder="მიუთითეთ">
                                        </div>    -->
                                        <select name="sphere_id" id="" class="form__select form__input  input-bg">
                                            <option value="{{ null }}">აირჩიეთ... </option>
                                        @forelse($spheres as $sphere)
                                          <option value="{{ $sphere->id }}">{{ $sphere->name }} </option>
                                        @empty
                                        @endforelse
                                        </select>  
                                    </div>
                                    <div class="form__group form__group--dropdown mb-2 position-relative">
                                        <!-- <div class="firago firago--normal firago--sm">
                                        სამუშაო განაკვეთი</div>
                                        <select name="" id="" class="form__select form__input  input-bg">
                                          <option value="0" selected>აირჩიეთ </option>
                                        </select>   -->

                                        <div class="firago firago--normal firago--sm"> სამუშაო განაკვეთი</div>
                                        <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userOcupationWork as $work)
                                                <label class="no-checkmark radio">
                                                    <input name="user_ocupation_work_id" type="radio" value="{{$work->id}}">
                                                    <span>{{$work->name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__group form__group--dropdown mb-2">
                                        <div class="firago firago--normal firago--sm">
                                        სექტორი</div>
                                        <!-- <div class="input-wrapper">
                                            <input type="text" class="form__input ellipsis" placeholder="მიუთითეთ">
                                        </div>    -->
                                        <select name="sector_id" id="" class="form__select form__input  input-bg">
                                            <option value="{{ null }}">აირჩიეთ... </option>
                                            @forelse($sectors as $sector)
                                              <option value="{{ $sector->id }}">{{ $sector->name }} </option>
                                            @empty
                                            @endforelse
                                        </select>  
                                    </div>
                                    <div class="user-disability no-disability">
                                        <label class="checkbox-container mb-2">
                                            <input type="radio" value="1">
                                            <div class="firago firago--normal firago--sm">არ ვმუშაობ</div>
                                            <span class="checkmark radio not-radio"></span>
                                        </label>
                                    </div>

                                    <div class="other-education mt-2">
                                        <div class="firago firago--normal firago--sm">სხვა</div>
                                        <div class="form__group form__group--half">
                                            <input name='ocupation_description'  autocomplete="off" type="text" class="form__input" placeholder="ჩაწერეთ თქვენი საქმიანობის შესახებ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="wizard__tab">
                            <div class="occupation-wrapper education-wrapper">
                                <div class="firago firago--normal firago--sm mb-4">რა განათლება გაქვთ მიღებული?</div>
                                <div class="address-dropdowns">
                                    <div class="form__group form__group--dropdown mb-3">
                                        <div class="firago firago--normal firago--sm">თქვენი განათლება</div>
                                        <div class="input-wrapper">
                                            <input disabled type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ განათლება" readonly>
                                            <div class="form__group-arrow">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="arrow" draggable="false">
                                            </div>
                                        </div>
                                        <div class="dropdown-right dropdown-regions active">
                                            <div class="dropdown-right__content">
                                                @foreach ($userEducations as $id => $val)
                                                <label class="no-checkmark radio">
                                                    <input name=' user_education_id' type="radio" value="{{$id}}">
                                            <span>{{$val->name}}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="other-education">
                                    <div class="firago firago--normal firago--sm">ჯერ კიდევ ვსწავლობ</div>
                                    <div class="form__group form__group--half">
                                        <input name='user_education_description' autocomplete="off" type="text" class="form__input" placeholder="სკოლა, პროფესიული, უმაღლესი">
                                    </div>
                                </div>

                                <div class="user-disability no-disability mt-5">
                                    <label class="checkbox-container">
                                        <input type="checkbox" value="0">
                                        <div class="firago firago--normal firago--sm">არანაირი განათლება არ მაქვს მიღებული</div>
                                        <span class="checkmark radio"></span>
                                    </label>
                                </div>
                              </div>
                            </div>
                        </div>   -->
                    

                        <div class="wizard__tab wizard__tab--registration-place">
                          <div class="left-wrapper">
                            <div class="left country">
                                <div class="firago firago--normal firago--sm">ქვეყანა</div>
                                <label class="checkbox-container mb-1">
                                    <input type="radio" name="is_georgia" value="1" checked>
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--normal firago--sm">საქართველო</div>
                                </label>
                                <label class="checkbox-container mb-1">
                                    <input type="radio" name="is_georgia" value="0">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--normal firago--sm">სხვა</div>
                                </label>
                                <div class="form__group disabled mb-4 mt-1">
                                    <label for="foreign-address" class="form__label">ქვეყანა, ქალაქი, მისამართი</label>

                                    <input type="text" class="form__input" id="foreign-address" name="address_text" disabled>
                                </div>
                            </div>
                          </div>
                          <div class="right address-dropdowns active justify-content-center mb-4">
                              <div class="inputs">
                                  <!-- <div class="form__group form__group--dropdown  linked">
                                      <div class="firago firago--normal firago--sm">ქვეყანა</div>
                                      <div class="dropdown-right-trigger">
                                          <input type="text" class="form__input readonly ellipsis" placeholder="მიუთითეთ" readonly disabled>
                                          <div class="form__group-arrow">
                                              <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                          </div>
                                      </div>
                                      <div class="dropdown-right dropdown-regions active selected">
                                          <div class="dropdown-right__content">
                                              
                                              <label class="no-checkmark radio">
                                                  <input type="radio" name="is_georgia" value="1">
                                                  <span>საქართველო</span>
                                              </label>
                                              <label class="no-checkmark radio">
                                                  <input type="radio" name="is_georgia" value="0">
                                                  <span>სხვა</span>
                                              </label>
                                              
                                          </div>
                                      </div>
                                  </div> -->
                                  <div class="form__group form__group--dropdown  linked">
                                      <div class="firago firago--normal firago--sm">რეგიონი</div>
                                      <div class="dropdown-right-trigger">
                                          <input type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ რეგიონი" readonly disabled>
                                          <div class="form__group-arrow">
                                              <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                          </div>
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
                                      <div class="firago firago--normal firago--sm">მუნიციპალიტეტი</div>
                                      <div class="dropdown-right-trigger">
                                          <input type="text" class="form__input readonly ellipsis" placeholder="აირჩიეთ მუნიციპალიტეტი" readonly disabled>
                                          <div class="form__group-arrow">
                                              <img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="arrow" draggable="false">
                                          </div>
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
                                      <div class="firago firago--normal firago--sm">ქალაქი ან სოფელი</div>
                                      <input type="text" class="form__input user-input" name="address_text" disabled>
                                  </div>
                              </div>
                          </div>
                        </div> 
                        <div class="wizard__tab justify-content-center">
                          <div class="passwords-content-wrapper">
                            <div class="form__group form__group--half">
                                <label for="email" class="form__label">ელ. ფოსტა
                                    <span class="required">
                                        <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                    </span>
                                </label>
                                <input type="text" class="form__input" id="email" name="email" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" value="@if(old('email')){{old('email')}}@endif">
                               
                                <div class="form__tooltip form__tooltip--light">
                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                    <div alt-text='ელ-ფოსტა უკვე დარეგისტრირებულია' default-text='გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი'>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                                </div>
                            </div>
                            <div class="form__group form__group--half">
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
                            <div class="form__group form__group--half mb-4">
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
                            <div class="d-flex align-items-center confirmation-checkbox mb-2">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--300 firago--italic firago--xs">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--xs privacy-button pointer privacy-policy-button">
                                    კონფიდენციალურობის პოლიტიკას</div>
                            </div>
                            <div class="d-flex align-items-center confirmation-checkbox mb-4">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--300 firago--italic firago--xs">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--xs terms-button pointer terms-button">
                                    წესებსა და პირობებს</div>
                            </div>
                          </div>
                        
                        </div>
                    <!-- <div class="wizard__tab">
                        <div class="d-flex flex-column sms-code"> -->
                            <!-- <div class="code-input-container">
                                <div class="form__group mb-4">
                                    <input type="number" class="form__input" id="code" name="code" pattern="^[0-9]{4}$">
                                    <label for="code" class="form__label">ჩაწერეთ მიღებული კოდი</label>
                                </div>
                                <div class="success-icon mb-3 ml-3"> -->
                                    <!-- <img src="{{ asset('img/icons/success-icon-green.svg') }}" alt="success" draggable="false"> -->
                                    <!-- <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.176 16.3123L9.80466 13.8256L9 14.6694L12.176 18L19 10.8438L18.1953 10L12.176 16.3123Z" fill="#0AB1B1" />
                                        <circle cx="14" cy="14" r="13.5" stroke="#fff" />
                                        <rect x="11.0625" y="10.0029" width="10.68" height="1.5" transform="rotate(45 11.0625 10.0029)" fill="#EE3048" />
                                        <rect x="10" y="17.552" width="10.68" height="1.5" transform="rotate(-45 10 17.552)" fill="#EE3048" />
                                    </svg> -->
                                <!-- </div>
                            </div> -->
                            <!--<div class="form__group line-height-1-3 mb-3 code-text-user">
                                    <p class="firago firago--sm text-white">კოდი გამოიგზავნება თქვენს მიერ მითითებულ ელ-ფოსტაზე</p>
                                </div>-->
                            <!-- <div class="code-container mb-11"> -->
                                <!-- <div class="send-code button--white" data-alternate-text="კოდის ახლიდან გამოგზავნა">
                                    <span>კოდის გამოგზავნა</span>
                                    <img src="{{ asset('images/email-red.svg') }}" alt="login">
                                    <div class="form__tooltip">
                                        <img src="{{ asset('img/icons/info-white.svg') }}" alt="info" draggable="false">
                                        <div class="firago--xs">ერთჯერადი კოდი გამოგზავნილია თქვენს ელ. ფოსტაზე</div>
                                    </div>
                                </div>
                                <div class="code-timer" id="code-timer">
                                </div> -->
                                <!--<div class="send-code firago firago--400 firago--italic firago--sm pointer text-white" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>
                                    <div class="firago firago--400 firago--italic firago--sm pointer text-red" data-alternate-text="კოდის ახლიდან გამოგზავნა">კოდის გამოგზავნა</div>-->
                            <!-- </div> -->

                            <!-- @if($errors->has('code'))
                            <div class="warning warning--md mb-3 visible">
                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                <div>{{ trans($errors->first()) }}</div>
                            </div>
                            @endif -->

                            <!-- <div class="d-flex align-items-center confirmation-checkbox mb-2">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--300 firago--italic firago--xs">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--xs privacy-button pointer privacy-policy-button">
                                    კონფიდენციალურობის პოლიტიკას</div>
                            </div>
                            <div class="d-flex align-items-center confirmation-checkbox mb-4">
                                <label class="checkbox-container mb-1 mt-1">
                                    <input type="checkbox">
                                    <span class="checkmark radio"></span>
                                    <div class="firago firago--300 firago--italic firago--xs">ვეთანხმები&nbsp;</div>
                                </label>
                                <div class="underlined firago firago--300 firago--italic firago--xs terms-button pointer terms-button">
                                    წესებსა და პირობებს</div>
                            </div>
                        </div>
                    </div> -->
                    </div>

              <div class="link-fancy next-step mb-4">
                <div class="title">გაგრძელება</div>
                <div class="attribute">
                     <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
                </div>
            </div>
            <div class="final-registration-container">
                <div class="button button--red final-registration  disabled-2 next-step mb-4" style="display: none">
                    <span class="d-inline-block">რეგისტრაცია</span>
                    <!-- <img src="{{ asset('img/icons/registration-button-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2"> -->
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


@endsection