@extends('layouts.master')

@section('content')

@php
    $hasQueries = isset($queryAnswers) && $queryAnswers->count() > 0;
@endphp
<style>
    .web-links {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
</style>

<div class="popup popup-rating">
    <div class="popup__content popup__content--m">
        <div class="popup__close d-flex align-items-center">
            <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
            <img src="{{ asset('img/icons/x-white.svg') }}" alt="close">
        </div>
        <div class="ratings-detailed">
            @foreach ($queryQuestionAnswersDetailed as $content)
                <div class="criteria__detailed">
                    <div class="criteria__top">
                        <div class="criteria__title">{{$content['question']->text}}</div>
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="criteria__score">{{number_format($content['avg'], 1, '.', ',')}}</div>
                            <div class="criteria__stars">
                            </div>
                            <div class="criteria__votes">{{$content['total']}}</div>
                        </div>
                    </div>
                    <div class="chart">
                        @for ($i = 5; $i >= 1; $i--)
                            <div class="chart-bar-single">
                                <div class="point">{{$i}}</div>
                                <div class="chart-bar">
                                    <div class="chart-bar-progress chart-bar-progress--{{$i}}"></div>
                                </div>
                                <div class="votes">{{$content['votes'][$i]}}</div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<section class="section-oragization">
      @php
        if($company->cover_image)
        $cover = "/storage/" . $company->getCoverPath();
        else
        $cover = "/img/org-cover.png";
        @endphp
        <div class="organization-cover-img" style="background-image:url({{$cover}})">
            {{-- <div class="organization-cover-img" style="background-image:url(/img/org-cover.png)"> --}}

        </div>
    <div class="wrapper">
        
        <div class="organization-header">
            <div class="org-address-phone">
                @if($company->address)
                <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $company->latitude . ',' . $company->longitude }}" target=_blank class="link d-flex align-items-center" >
                    <div class="icon">
                        <img src="{{ asset('img/icons/location.svg') }}" alt="marker">
                    </div>
                    <span>{{ $company->address }}</span>
                </a>
                @endif
                @if($company->phone)
                <a href="tel:{{$company->phone}}" class="link d-flex align-items-center">
                    <div class="icon"><img src="{{ asset('img/icons/call-calling.svg') }}" alt="tel"></div>
                    <span>{{ $company->phone }}</span>
                </a>
                @endif

                @if($company->web_page)
                <a href="{{ \App\Helpers\AppHelper::formatUrl($company->web_page) }}" target=_blank class="link d-flex align-items-center">
                    <div class="icon">
                        <img src="{{ asset('img/icons/global-web.svg') }}" alt="web">
                    </div>
                    <span class="web-links" >Website</span>
                </a>
                @endif
                @if($company->fb_page)
                <a href="{{ \App\Helpers\AppHelper::formatUrl($company->fb_page) }}" target=_blank class="link d-flex align-items-center">
                    <div class="icon">
                        <img src="{{ asset('img/icons/facebook-new.svg') }}" alt="facebook">
                    </div>
                    <span class="web-links" >Facebook</span>
                </a>
                @endif
            </div>
            <div class="left">
                <div class="organization-img">
                    <img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img">
                </div>
                <h4 class="organization-title">{{ $company->name }}</h4>
                <div class="organization-rating criteria__detailed">
                    {{-- <div class="d-flex align-items-center mb-1 mt-2">
                        <div class="criteria__score">2.5</div>
                        <div class="criteria__stars"></div>
                    </div>
                    <div class="criteria__votes mb-2">(13,940)</div> --}}
                    <div class="subs-amount"><span>{{ $subsCount }} </span>გამომწერი</div>
                </div>
                <!-- @php
                $isSubbed = (isset($user) && $user->isSubscribedToCompany($company->id));
                @endphp
                <div class="organization-buttons">
                    <button class="subscribe button--red @if($isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/unsubscribe-company">
                        <span>გამოწერილი</span>
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                    </button>
                    <button class="align-items-center subscribe button--red @if(!$isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/subscribe-company" data-popup-message='ორგანიზაციის გამოწერისთვის გაიარე ავტორიზაცია'>
                        <span>გამოიწერე ორგანიზაცია</span>
                        <img src="{{ asset('img/icons/subscribe-white.svg') }}" alt="subscribe">
                    </button>
                    <div class="share organization-share" data-url="{{ $company->getShortURL() }}">
                        <img src="{{ asset('img/icons/share-white.svg') }}" alt="share" draggable="false">
                    </div>
                </div> -->
            </div>
            <!-- <div class="middle">
                <h4 class="organization-title">{{ $company->name }}</h4>
                @php
                $isSubbed = (isset($user) && $user->isSubscribedToCompany($company->id));
                @endphp
                <div class="organization-buttons">
                    <button class="subscribe button--red @if($isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/unsubscribe-company">
                        <span>გამოწერილი</span>
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                    </button>
                    <button class="subscribe button--red @if(!$isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/subscribe-company" data-popup-message='ორგანიზაციის გამოწერისთვის გაიარე ავტორიზაცია'>
                        <span>გამოიწერე ორგანიზაცია</span>
                        <img src="{{ asset('img/icons/subscribe-white.svg') }}" alt="subscribe">
                    </button>
                    <div class="share organization-share" data-url="{{ $company->getShortURL() }}">
                        <img src="{{ asset('img/icons/share-white.svg') }}" alt="share" draggable="false">
                    </div>
                </div>
            </div> -->
            <div class="bordered-container contact-info org-contact-web">
                @php
                $isSubbed = (isset($user) && $user->isSubscribedToCompany($company->id));
                @endphp
                <div class="organization-buttons">
                    <button class="subscribe align-items-center button--red @if($isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/unsubscribe-company">
                        <span>გამოწერილი</span>
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                    </button>
                    <button class="align-items-center subscribe button--red @if(!$isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/subscribe-company" data-popup-message='ორგანიზაციის გამოწერისთვის გაიარე ავტორიზაცია'>
                        <span>გამოიწერე ორგანიზაცია</span>
                        <img src="{{ asset('img/icons/subscribe-white.svg') }}" alt="subscribe">
                    </button>
                    <div class="share organization-share" data-url="{{ $company->getShortURL() }}">
                        <img src="{{ asset('img/icons/share-red.svg') }}" alt="share" draggable="false">
                    </div>
                </div>
                <!-- <div class="heading heading--md">საკონტაქტო ინფორმაცია</div> -->
                <!-- @if($company->address)
                <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $company->latitude . ',' . $company->longitude }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/marker-white.svg') }}" alt="marker">
                    </div>
                    <span>{{ $company->address }}</span>
                </a>
                @endif
                @if($company->phone)
                <a href="tel:{{$company->phone}}" class="link">
                    <div class="icon"><img src="{{ asset('img/icons/tel-white.svg') }}" alt="tel"></div>
                    <span>{{ $company->phone }}</span>
                </a>
                @endif -->
                <!-- @if($company->web_page)
                <a href="{{ \App\Helpers\AppHelper::formatUrl($company->web_page) }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/global-web.svg') }}" alt="web">
                    </div>
                    <span class="web-links" >Website</span>
                </a>
                @endif
                @if($company->fb_page)
                <a href="{{ \App\Helpers\AppHelper::formatUrl($company->fb_page) }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/facebook-new.svg') }}" alt="facebook">
                    </div>
                    <span class="web-links" >Facebook</span>
                </a>
                @endif -->
            </div>
        </div>
    </div>
</section>
<section class="organization-main">
    <div class="tabs-wrapper">
        <div class="wrapper">
            <div class="switch switch--organization no-ajax">
                <div class="switch__item active">ორგანიზაციის შესახებ</div>
                <div class="switch__item">შესაძლებლობები</div>
                <div class="switch__item @if(!$hasQueries) disabled @endif">შეფასებები</div>
            </div>
        </div>
        <div class="tabs-container active">
            <div class="tab organization-tab organization-tab--about active">
                <div class="wrapper">
                    <div class="heading heading--fancy">
                        საქმიანობის აღწერა
                    </div>
                </div>
                <div class="wrapper org-info-wrapper">
                    <div class="organization-description ck-content">
                        <p class="organization-description-content shorten-content">
                            {!! $company->description1 !!}
                            {{-- ლორემ იპსუმ გალიიდან ნაოჭიანი სამოცდაშვიდი მივაგნო კატები სიბრძნეს გვიჩურჩულა შეჭმას უთხოვნელად, ხაპი დამაბრმავა დაამტკიცესო მიგვიხვდება. პატივისცემით ეპიზოდები დაყირავებული გაიგონებდა, გაეყარა, გალიიდან, სიბრძნეს, მოგვასმენინონო გადაშლის მათგანი ქვეყნებს გამოჩენილი, მიბრუნებისა ამჯობინებს. დაამტკიცესო ჰადელნი მიგვიხვდება დაიმორჩილებენ ყლუპი ლომებსა. ამჯობინებს ლოგიკურ დამაბრმავა გალიიდან ქვეყანაც დაგვეპატიჟა, დაჰყურებდა, მივაგნო შემურულ. ართმევენ ღვთისაგან დროების პრუსტზე, სახელმწიფო, ვარდისფერ დაიმორჩილებენ ამჯობინებს თვალთმაქცობ ყურთან გულშემზარავი გიძღვნი. შეჭმას ყურთან ვარდისფერ შეახო ასეო ქვეყნებს. დაამტკიცესო კომპლექსს სახელმწიფო დამაბრმავა მერხს, გულშემზარავი ნავსადგურის ბიძამისი პროგრესულ მოვარდა დაჰყურებდა ქეშელაც. მოსული მათგანი გაიგონებდა პრუსტზე ოსიმა ასეო კომპლექსს ფარაჯანოვსაც ვარდისფერ უთხოვნელად. გაიგონებდა ტყუილის ღვთისაგან ესმოდათ რეალობების, შეახო პროექტზე ვირზე მიბრუნებისა უთხოვნელად ჰადელნი ასეო მოდილიანის დაყირავებული დესერტი. --}}
                        </p>
                        <div class="more-content-button">მეტის ნახვა<img src="{{ asset('img/icons/see-more-arrow-blue.svg') }}" alt="arrow"></div>
                    </div>
                </div>
                <div class="organization-details-container">
                    <div class="wrapper org-info-wrapper">
                        <div class="organization-details">
                            @php
                            $placeOfRegistration = $company->place_of_registration;
                            if ($placeOfRegistration)
                            $placeOfRegistration = $placeOfRegistration->address_text;
                            $map = [
                            'ორგანიზაციის სახელი' => [$company->name,false],
                            'საკონტაქტო ნომერი' => [$company->phone,false],
                            'ორგანიზაციის ტიპი' => [$company->type,false],
                            'ელექტრონული მეილი' => [$company->email,false],
                            'რეგისტრაციის ადგილი' => [$placeOfRegistration,false],
                            'Facebook' => [$company->fb_page,true],
                            'სარეგისტრაციო ნომერი' => [$company->registration_id,false],
                            'Linkedin' => [$company->linkedin_page,true],
                            'მისამართი' => [$company->address,false],
                            'ვებგვერდი' => [$company->web_page,true],
                            ];
                            @endphp
                            @foreach ($map as $key => list($value, $bool))
                            @if ($value)
                            <div class="organization-detail-single">
                                <div class="detail-title">{{ $key }}:</div>
                                @if (!$bool)
                                <div class="detail-value">{{ $value }}</div>
                                @else
                                <a href={{ \App\Helpers\AppHelper::formatUrl($value) }} target=_blank class="link detail-value web-links link">{{ $value }}</a>
                                @endif
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="organization-areas">
                    <div class="wrapper org-info-wrapper">
                        <div class="organization-detail-single">
                            <div class="detail-title">სამოქმედო არეალი (რეგიონული):</div>
                            <div class="detail-value">
                                @php $workingRegions = $company->workingRegions; $strReg = ""@endphp
                                @if($workingRegions)
                                @foreach ($workingRegions as $region)
                                @php $strReg = $strReg . ', ' .$region->name; @endphp
                                @endforeach
                                @php $strReg = substr($strReg, 2); @endphp
                                {{$strReg}}
                                @endif
                            </div>
                        </div>
                        <div class="organization-detail-single">
                            <div class="detail-title">სამოქმედო არეალი (მუნიციპალიტეტი):</div>
                            <div class="detail-value">
                                @php $workingMunicipalities = $company->workingMunicipalities; $strMun = "" @endphp
                                @if($workingMunicipalities)
                                @foreach ($workingMunicipalities as $municipality)
                                @php $strMun = $strMun . ', ' .$municipality->name; @endphp
                                @endforeach
                                @php $strMun = substr($strMun, 2); @endphp
                                {{$strMun}}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab organization-tab organization-tab--opportunities">
                <div class="wrapper">
                    <div class="events-block">
                        <div class="heading heading--fancy">
                            მიმდინარე შესაძლებლობები
                        </div>
                        <div class="events">
                            @php $index = 1 @endphp
                            @foreach ($ongoingOpportunities as $opportunity)
                            @include('templates.opportunity', [
                            'hide' => $index > 3
                            ])
                            @php $index++ @endphp
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center org-event-buttons">
                            @if(sizeof($ongoingOpportunities) == 0)
                            <p class="not-found mb-7 mt-5 w-100">შესაძებლობები არ მოიძებნა</p>
                            @endif
                            @if(sizeof($ongoingOpportunities) > 3)
                            <a class="link-fancy m-h-auto mt-5 mb-4 see-more-opportunities-organization-page" data-expanded=false>
                                <div class="title">ნახე მეტი</div>
                                <div class="attribute">
                                    <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="double arrow">
                                </div>
                            </a>
                            <a class="link-fancy link-fancy--reversed m-h-auto mt-5 mb-4 see-less-opportunities-organization-page" data-expanded=false style="display: none;">
                                <div class="attribute">
                                    <img src="{{ asset('img/icons/arrow-left-double-white.svg') }}" alt="double arrow">
                                </div>
                                <div class="title">ნახე ნაკლები</div>
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="events-block">
                        <div class="heading heading--fancy">
                            დასრულებული შესაძლებლობები
                        </div>
                        <div class="events">
                            @php $index = 1 @endphp
                            @foreach ($finishedOpportunities as $opportunity)
                            @include('templates.opportunity', [
                            'hide' => $index > 3,
                            'completed' => true
                            ])
                            @php $index++ @endphp
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center org-event-buttons">
                            @if(sizeof($finishedOpportunities) == 0)
                            <p class="firago firago--blue firago--mdd not-found mb-9 w-100">შესაძებლობები არ მოიძებნა</p>
                            @endif
                            @if(sizeof($finishedOpportunities) > 3)
                            <a class="link-fancy m-h-auto mt-5 mb-4 see-more-opportunities-organization-page">
                                <div class="title">ნახე მეტი</div>
                                <div class="attribute">
                                    <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="double arrow">
                                </div>
                            </a>
                            <a class="link-fancy link-fancy--reversed m-h-auto mt-5 mb-4 see-less-opportunities-organization-page" data-expanded=false style="display: none;">
                                <div class="attribute">
                                    <img src="{{ asset('img/icons/arrow-left-double-white.svg') }}" alt="double arrow">
                                </div>
                                <div class="title">ნახე ნაკლები</div>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab organization-tab organization-tab--rating">
                <div class="wrapper">
                    <div class="heading heading--fancy">შეფასება</div>
                </div>
                <div class="wrapper org-info-wrapper">
                    <div class="event-rating organization-rating event-rating--grey">
                        <div class="score">
                            <img src="{{ asset('img/icons/star-yellow.svg') }}" alt="star">
                            {{number_format($company->companyAvgScore(), 1, '.', ',')}}
                            <div class="before">(<span>{{$queryAnswers->count()}}</span> შეფასება)</div>
                        </div>
                        <div class="criterias">

                            @foreach ($queryPropertyAnswers as $key=>$answer)
                                <div class="criteria">
                                    <div class="criteria__key">{{$queryProperties[$key-1]->text}}</div>
                                    <div class="criteria__value">{{$answer}}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="organization-comments">
                    <div id="organization-feedbacks" class="wrapper org-info-wrapper">
                        @foreach ($feedbacks as $feedback)
                        @include('renders.organizationFeedbackRenderer')
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mb-5">
                        @if ($hasMoreFeeds)
                        <a id="see-more-feedbacks-organization-inner-page" data-company-id={{$company->id}} class="link-fancy m-h-auto mt-5">
                            <div class="title">ნახე მეტი</div>
                            <div class="attribute">
                                <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection