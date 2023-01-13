@php



@endphp

@extends('layouts.master')

@section('content')


<div class="popup popup-file-downloader">
    <div class="popup__content popup__content--m popup__content--white">
        <div class="popup__close d-flex align-items-center">
            <span class="firago firago--normal firago--smm firago--dark mr-1">დახურვა</span>
            <img src="{{ asset('img/icons/x-dark.svg') }}" alt="close">
        </div>
        <div class="firago firago--smm firago--blue mb-3">
            @if($opportunity->id == 9)
            Download files
            @else
            ფაილების გადმოტვირთვა
            @endif
        </div>
        @foreach($mediaUrls as $name=>$url)
        <div class="uploader-container file-downloader">
            <div class="file-name firago firago--smm firago--blue">{{ $name }}</div>
            <a target=_blank href="{{ asset($url) }}" download="{{$name}}">
                <label class="upload-button firago" for="inputFile">
                    <img src="{{ asset('images/download.svg') }}" />
                </label>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="popup popup-rating">
    <div class="popup__content popup__content--m">
        <div class="popup__close d-flex align-items-center">
            <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
            <img src="{{ asset('img/icons/x-white.svg') }}" alt="close">
        </div>
        <div class="ratings-detailed">
            @foreach ($queryQuestions as $question)
            <div class="criteria__detailed">
                <div class="criteria__top">
                    <div class="criteria__title">{{$question->text}}</div>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="criteria__score">{{number_format($questionsAverage[$question->id], 1, '.', ',')}}</div>
                        <div class="criteria__stars">
                        </div>
                        <div class="criteria__votes">{{$totalAnswerCount[$question->id]}}</div>
                    </div>
                </div>
                <div class="chart">
                    @for ($i = 5; $i >= 1; $i--)
                    <div class="chart-bar-single">
                        <div class="point">{{$i}}</div>
                        <div class="chart-bar">
                            <div class="chart-bar-progress chart-bar-progress--{{$i}}"></div>
                        </div>
                        <div class="votes">{{$questionAllScores[$question->id][$i]}}</div>
                    </div>
                    @endfor
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="popup popup-delete-comment">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="popup-top">
            <img src="{{ asset('img/icons/alert-red.svg') }}" alt="alert">
            <div class='firago firago--blue firago--style-normal firago--md firago--500 ml-4'>გსურთ კომენტარის წაშლა?</div>
        </div>
        <div class="popup-bottom">
            <div class="popup__close button button--border-blue">
                <span>გაუქმება</span>
                <img src="{{ asset('img/icons/x-blue-rect.svg') }}" alt="cancel">
            </div>
            <div id="delete-opportunity-comment-button" class="button button--red delete-comment">
                <span>წაშლა</span>
                <img src="{{ asset('img/icons/delete-white.svg') }}" alt="delete">
            </div>
        </div>
    </div>
</div>


<div class="main-content-container event-inner-page wrapper" id="possibility_main_container">
    <div class="basic-info-container">
        <div class="info-header">
            <div class="date-misc-container">
                <!-- <div class="event-date-container">
                    <div class="event-date">{{ $eventDates['startTime']['date'] }}</div>
                    <div class="event-month">{{ $eventDates['startTime']['month'] }}</div>
                </div> -->
                <div class="event-misc-info-container">
                    <div class="event-title">{{ $opportunity -> name }}</div>
                    <div class="event-time-location">
                        <div class="event-time-container">
                            <div class="event-start-time">
                                <span class="date">{{ $eventDates['startTime']['date'] }}</span>
                                <span class="month">{{ $eventDates['startTime']['month'] }}.</span>
                                <span class="year">{{ $eventDates['startTime']['year'] }}</span>
                                <!-- <span class="time">{{ $eventDates['startTime']['time'] }}</span> -->
                            </div>
                            <span class="date-separator"> - </span>
                            <div class="event-end-time">
                                <span class="date">{{ $eventDates['endTime']['date'] }}</span>
                                <span class="month">{{ $eventDates['endTime']['month'] }}.</span>
                                <span class="year">{{ $eventDates['endTime']['year'] }}</span>
                                <!-- <span class="time">{{ $eventDates['endTime']['time'] }}</span> -->
                            </div>
                        </div>
                        @if ($opportunity -> latitude && $opportunity -> longitude && $opportunity -> address)
                        <span class="time-address-separator"> / </span>
                        <div class="event-location">{!! $opportunity -> address !!}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="actions">
                @if($application_url)
                <a class="@if(Auth::check() && !$finished) active @elseif($finished) disabled @endif @if($urlButtonAction == 'add-going') active @endif add-going fill-application-btn with-url justify-content-center" href="{{ $application_url }}" target=_blank action="add-going" data-opportunity-id="{{ $opportunity-> id }}" data-opportunity-id="{{ $opportunity -> id }}">
                    <div class="btn-text mr-1">აპლიკაციის შევსება</div>
                @else
                <div class="@if(Auth::check() && !$finished) active @elseif($finished) disabled @endif @if($opportunityGoing) going @endif add-going btn fill-application-btn no-url justify-content-center" data-opportunity-id="{{ $opportunity -> id }}">
                    <div class="btn-text mr-1"> {{ $opportunityGoing ? 'მიდიხართ' : 'წასვლა' }}</div>
                @endif
                    <div class="icon-default">
                        @include('svg.document-white')
                    </div>
                    <div class="icon-attending">
                        @include('svg.check')
                    </div>
                @if($application_url) 
                </a> 
                @else
                </div>
                @endif
                <div class="@auth active @endauth add-to-favorites-btn @if($opportunityIsFavorite) added @endif add-fav btn" data-opportunity-id="{{ $opportunity -> id }}">
                    <!-- <div>ფავორიტები</div> -->
                    @include('svg.heart-outline')
                </div>
            </div>
        </div>
        <div class="cover-image-container">
            <div class="cover-image" style="background-image: linear-gradient(transparent, #000000), url('{{ asset('/storage/' . $opportunity -> image) }}')"></div>
            <div class="organizer-info-container">
                @if(is_null($opportunity->company_id))
                    <div class="organizer-image" style="background-image: url('{{ asset('/storage/'. $company->getImagePath()) }}')"></div>
                <div class="organizer-name-container">
                        <div class="organizer-name">{{ $guard == 'web' ? $company->fitst_name . ' ' . $company->last_name : $company -> name }}</div>
                    <div class="subscribers"><span>{{ $subsCount }}</span> გამომწერი</div>
                </div>
                @else
                <a href="{!! route('organization', ['id' => $company->id]) !!}">
                    <div class="organizer-image" style="background-image: url('{{ asset('/storage/'. $company->getImagePath()) }}')"></div>
                </a>
                <div class="organizer-name-container">
                    <a href="{!! route('organization', ['id' => $company->id]) !!}">
                        <div class="organizer-name">{{ $guard == 'web' ? $company->fitst_name . ' ' . $company->last_name : $company -> name }}</div>
                    </a>
                    <div class="subscribers"><span>{{ $subsCount }}</span> გამომწერი</div>
                </div>
                @endif
                
                <div class='@auth active @endauth {{ $isSubbed ? "subscribed" : "" }} subscribe subscribe-btn btn' data-company-id="{{ $company -> id }}">{{ $isSubbed ? "გამოწერილი" : "გამოწერა" }}</div>
            </div>
        </div>
    </div>
    <div class="tab-switcher align-items-center justify-content-between">
        <div class="tab-btns-wrapper">
            <div class="tab-btns" id="tab-btns">
                <div class="tab-btn description active">აღწერა</div>
                <div class="tab-btn faq">ხშირად დასმული კითხვები</div>
                <div class="tab-btn media">მედია</div>
                <div class="tab-btn files">ფაილები</div>
            </div>
        </div>
        <div class="line"></div>
        <!-- <div class="actions">
            @if($application_url)
            <a class="@if(Auth::check() && !$finished) active @elseif($finished) disabled @endif @if($urlButtonAction == 'add-going') active @endif add-going fill-application-btn with-url" href="{{ $application_url }}" target=_blank action="add-going" data-opportunity-id="{{ $opportunity-> id }}" data-opportunity-id="{{ $opportunity -> id }}">
                <div class="btn-text">აპლიკაციის შევსება</div>
            @else
            <div class="@if(Auth::check() && !$finished) active @elseif($finished) disabled @endif @if($opportunityGoing) going @endif add-going btn fill-application-btn no-url" data-opportunity-id="{{ $opportunity -> id }}">
                <div class="btn-text"> {{ $opportunityGoing ? 'მიდიხართ' : 'წასვლა' }}</div>
            @endif
                <div class="icon-default">
                    @include('svg.document-white')
                </div>
                <div class="icon-attending">
                    @include('svg.check')
                </div>
            @if($application_url)
            </a> 
            @else
            </div>
            @endif
            <div class="@auth active @endauth add-to-favorites-btn @if($opportunityIsFavorite) added @endif add-fav btn" data-opportunity-id="{{ $opportunity -> id }}">
                @include('svg.heart-outline')
                <div>ფავორიტები</div>
            </div>
        </div> -->
    </div>
    <div class="tabs-container">
        <div class="tab tab-event-description active">
            <div class="event-description ">
                <!-- <div class="description-wrapper opportunity-description-inner"> -->
                <div class="description-wrapper">
                    {!! $opportunity -> description !!}
                </div>                
                @if(!$opportunity -> categories -> isEmpty())
                <div class="opportunity-categories">
                    @foreach ($opportunity -> categories as $category)
                        <div class="single-category">#{{ $category -> name }}</div>
                    @endforeach
                </div>
                @endif
            </div>
            <div class="event-extra-info">
                @if(!$opportunity -> disabilities -> isEmpty())
                <div class="disabilities-list">
                    <div class="disability-title">შესაძლებლობა ადაპტირებულია:</div>
                    <div class="disabilities">
                        @foreach ($opportunity -> disabilities as $disability)
                        <div class="single-disability">
                            {{ $disability -> description }}
                            <div class="disability-icon ml-1">
                                <img src="{{ asset('/storage/'.$disability->getImagePath()) }}">
                            </div>
                            
                        </div>
                        @endforeach
                    </div>                    
                </div>
                @endif
                <div class="event-contact">
                    <div class=contact-title>საკონტაქტო ინფორმაცია</div>
                    <div class="contact-items">
                        @empty(!$opportunity -> address)
                        <div class="contact-item contact-directions">
                            <div class="contact-icon">
                                @include('svg.contact-pin')
                            </div>
                            <div>{{ str_replace(['<p>','</p>'], '', $opportunity -> address) }}</div>
                        </div>
                        @endempty
                        @empty(!$opportunity -> phone)
                        <div class="contact-item contact-phone">
                            <div class="contact-icon">
                                @include('svg.contact-phone')
                            </div>
                            <a href="tel:{{ $opportunity -> phone }}">{{ $opportunity -> phone }}</a>
                        </div>
                        @endempty
                        @empty(!$opportunity -> phone2)
                        <div class="contact-item contact-phone">
                            <div class="contact-icon">
                                @include('svg.contact-phone')
                            </div>
                            <a href="tel:{{ $opportunity -> phone2 }}">{{ $opportunity -> phone2 }}</a>
                        </div>
                        @endempty
                        @empty(!$opportunity -> email)
                        <div class="contact-item contact-email">
                            <div class="contact-icon">
                                @include('svg.contact-email')
                            </div>
                            <a href="{{ 'mailto:' . $opportunity->email }}" target=_blank>
                                {{ $opportunity -> email }}
                            </a>
                        </div>
                        @endempty
                        @empty(!$linkedin_page)
                        <a class="contact-item contact-web" href="{{ $linkedin_page }}" target="_blank">
                            <div class="contact-icon">
                                @include('svg.contact-linkedin')
                            </div>
                            <div>{{ $linkedin_page }}</div>
                        </a>
                        @endempty
                        @empty(!$web_page)
                        <a class="contact-item contact-web" href="{{ $web_page }}" target="_blank">
                            <div class="contact-icon">
                                @include('svg.contact-web')
                            </div>
                            <div>{{ $web_page }}</div>
                        </a>
                        @endempty
                        @empty(!$fb_page)
                        <a class="contact-item contact-fb" href="{{ $fb_page }}" target="_blank">
                            <div class="contact-icon">
                                @include('svg.contact-facebook')
                            </div>
                            <div>{{ $fb_page }}</div>
                        </a>
                        @endempty
                    </div>
                </div>
                
                <div class="contact-location">
                    @if (!$opportunity->is_virtual)
                    <div class="map-wrapper">
                        <div id="map-container" class="map-container" data-lat="{{ $opportunity->latitude }}" data-long="{{ $opportunity->longitude }}"></div>
                    </div>
                    @else
                    <div class=online-event>
                        <div class="online-event-header">
                            <div>ტარდება ვირტუალურ სივრცეში</div>
                            <div class="active-status @if($finished) finished @endif"></div>
                        </div>
                        <div>ელექტრონული ბმული</div>
                        <div class="event-url-container">
                            <div class='url-input-container'>
                                <input class="url-input" id="event-url" type="text" value="{{ $opportunity->application_url }}" readonly>
                                <div class="url-copy-btn btn">დააკოპირე</div>
                            </div>
                            <a class="event-url-btn btn" href="{{ $opportunity->application_url }}" target="_blank">
                                <div>ბმულზე გადასვლა</div>
                                @include('svg.link')
                            </a>                            
                        </div>
                    </div>
                    @endif
                </div>
                <!-- <div class="interested">შესაძლებლობით დაინტერესებულია ({{ $interestedUsers }})</div> -->
                <div target="_blank" class="share-btn event__share" data-url="{{ $opportunity->getShortURL() }}">
                    @include('svg.share')
                </div>
            </div>
        </div>
        <div class="tab tab-faq">
            <div class="questions-container">
                @if ($opportunity -> faqs)
                    @foreach ($opportunity -> faqs as $faq)
                    <div class="single-faq">
                        <div class="question-wrapper">
                            <div class="question">{{ $faq -> question }}</div>
                            <div class="dropdown-icon">
                                @include('svg.dropdown-arrow')
                            </div>
                        </div>
                        <div class="answer-wrapper">
                            <div class="answer">{{ $faq -> answer }}</div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div>კითხვები არ მოიძებნა</div>
                @endif
            </div>
        </div>
        <div class="tab tab-media">
            <div class="images">
                @foreach ($opportunity->opportunity_medias as $media)
                    <div class="single-image" style="background-image: url('{{ asset('/storage/' . $media->media_url)  }}')"></div>
                @endforeach
            </div>
            <div class="slider" id="slider">
                <div class="active-image" id="active-image">
                   
                </div>
                <div class="slider-controls">
                    <div class="slider-navigation">
                        <div class="navigation slider-control left d-flex align-items-center justify-content-center">
                          <img src="{{ asset('img/icons/arrow-left-yellow.svg') }}" alt="">
                        </div>
                        <div class="navigation slider-control right d-flex align-items-center justify-content-center">
                          <img src="{{ asset('img/icons/arrow-right-yellow.svg') }}" alt="">
                        </div>
                    </div>
                    <div class="slider-close slider-control btn d-flex align-items-center justify-content-center">
                      დახურვა
                      <div class="ml-1  d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/icons/plus-white.svg') }}" alt="">
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab tab-files">
            <div class="tab-title">ფაილები</div>
            <div class="tab-description">აქედან შეგიძლიათ გადატვირთოთ ფაილები</div>
            <div class="available-files">
                @if ($mediaUrls)
                @foreach($mediaUrls as $name=>$url)
                <div class="single-download">
                    <div class="file-name">{{ $name }}</div>
                    <a target=_blank href="{{ asset($url) }}" download="{{$name}}">
                        <div class="download-btn btn">
                            @include('svg.download-arrow')
                        </div>                        
                    </a>
                </div>
                @endforeach
                @else
                <div class=no-files>ფაილები არ მოიძებნება</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="opportunity-inner-wrapper event-inner-page-opportunity-wrapper first pb-1">
    <div class="wrapper no-padding-md">
        <!-- <section class="opportunity-header">
            <div class="opportunity-header__left">
                <div class="event-image">
                    <img src="{{ asset('/storage/' . $opportunity->getImagePath()) }}" alt="img">
                </div>
                <div class="sub-buttons">
                    <div action="add-favorite" data-opportunity-id="{{ $opportunity->id }}" class="button--red url-button @if(!$opportunity->isFavorite($user, $opportunity->id)) active @endif add-fav @if($finished) disabled @endif" data-popup-message='რჩეულებში დასამატებლად გაიარეთ ავტორიზაცია'>
                        <span>რჩეულებში დამატება</span>
                        <img src="{{ asset('img/icons/heart-white.svg') }}" alt="favorites">
                    </div>
                    <div action="remove-favorite" data-opportunity-id="{{ $opportunity->id }}" class="button--red @if($auth && $opportunity->isFavorite($user, $opportunity->id)) active @endif url-button">
                        <span>რჩეულებში დამატებულია</span>
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                    </div>
                </div>
            </div>
            <div class="opportunity-header__right">
                <div class="box-1">
                    <div class="organization-img">
                        <a href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}"><img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img"></a>
                    </div>
                    <div class="titles">
                        <h3 class="opportunity-title">{{ $opportunity->name }}</h3>
                        <div class="organization-title">
                            <a href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}">
                                <h4>{{ $company->name }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-2">
                    <div class="date">{!! $opportunity->getDateString() !!}</div>
                    <div class="sub-buttons">
                        <div class="subs-amount"><span>{{ $subsCount }} </span>გამომწერი</div>
                        <button class="subscribe button--red align-items-center @if($isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/unsubscribe-company">
                            <img src="{{ asset('img/icons/bell-white-striked.svg') }}" alt="checkmark">
                        </button>
                        <button class="subscribe button button--red align-items-center @if(!$isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/subscribe-company" data-popup-message='ორგანიზაცის გამოსაწერად გაიარე ავტორიაზაცია'>
                            <img src="{{ asset('img/icons/bell-white.svg') }}" alt="subscribe">
                        </button>
                    </div>
                </div>
                <div class="box-3">
                    <a class="tag" href="#">#ხელოვნება</a>
                    <a class="tag" href="#">#თეატრი</a>
                    <a class="tag" href="#">#კინო</a>
                    <a class="tag" href="#">#განათლება</a>
                    <a class="tag" href="#">#ხელოვნება</a>
                    <a class="tag" href="#">#თეატრი</a>
                    <a class="tag" href="#">#კინო</a>
                </div>
                <div class="box-4">
                    <div class="interested">
                        დაინტერესებული<span>(85)</span>
                    </div>
                    <div class="virtual-space">
                        <span></span>ტარდება ვირტუალურ სივრცეში
                    </div>
                </div>
                <div class="box-5">
                    <div class="buttons">
                        <a href="{{ $application_url }}" target=_blank action="add-going" data-opportunity-id="{{ $opportunity->id }}" class="button--red add-going url-button @if($application_url) open-url @endif @if($urlButtonAction == 'add-going') active @endif @if($finished) disabled @endif" data-popup-message='შესაძლებლობაზე რეგისტრაციისთვის გაიარეთ ავტორიზაცია'>
                            @if($opportunity->id == 9)
                            <span>Apply now</span>
                            @else
                            <span>აპლიკაციის შევსება</span>
                            @endif
                            <img src="{{ asset('img/icons/document-white.svg') }}" alt="application">
                        </a>
                        <div action="remove-going" data-opportunity-id="{{ $opportunity->id }}" class="button--red url-button @if($urlButtonAction == 'remove-going') active @endif">
                            @if($opportunity->id == 9)
                            <span>Registered</span>
                            @else
                            <span>რეგისტრირებულია</span>
                            @endif
                            <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                        </div>
                        @if(count($mediaUrls))
                        <a href="#" target=_blank class="multiple-download button--red url-button button--white active">
                            @if($opportunity->id == 9)
                            <span>Download files</span>
                            @else
                            <span>ფაილების გადმოტვირთვა</span>
                            @endif
                            <img src="{{ asset('img/icons/download-red.svg') }}" alt="download">
                        </a>
                        @endif
                        <div class="share share-inner" data-url="{{ $opportunity->getShortURL() }}">
                            <img src="{{ asset('img/icons/share-icon.svg') }}" alt="share">
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <section class="event-inner-main">
            <div class="opportunity-description-inner">
 </figure>
                <h2>უღობავდა გუცაევი სახეაწითლებული უარობდა გვაფრთხილებდა ჩინემას თენგიზი თეიმურაზიც, ცოდვას, ვიმეცადინო, გადმოუკეცა გამოგიდებენ</h2>
                <p>წყლად გამომიგზავნა სსისხლი ესროლო გადაიქცეოდეს შლენდორფის დისკუსიაში ღრეობასა მოწმედ, თავსაბურავს ვაჟებს, ცნობილ, მხარემაც ნაჩხუბარი ტყვიის. მამაოთი მხარემაც გამოსწორებულიყო ლირიკულის დისკუსიაში ჭექა. პუტინის წყლად აქაურობას რხევით ამოიოხრებს მანეთად, ვაჟებს პრესტიჟია წამოვიღოთ. იკისრეო მიბძანებთ ზღარბი პუტინის რუსტის, აქაურობას, მოთვალყურე ლლიონ გამოსწორებულიყო ლირიკულის რასაკვირევლია დაამკვიდრეს.</p>
                <blockquote>სიგანით მონათა ბბრალო ჭიკჭიკს მოწონებული გამოფინეს. არავინა ბბრალო თენგიზი, მძლიეს ძაღლებისა უწყობდა ისააკი დადგამდა</blockquote>
                <h3>კაზანოვას მთვარეს</h3>
                <ul>
                    <li>ევროპელები</li>
                    <li>ბრეცია</li>
                    <li>ნაკლებია სტომატოლოგების, ნათესაობა</li>
                    <li>ჰერცოგ ჩახვეულიყო ბანკეტისთვის კანცელარია ვდიე აგაცოცდებაო.</li>
                    <li>უპირატესობას ოფიცრისა ჰარპერისა განრისხებით წარმოება. ულოცავს განდეგილის გაიღიმეს შეტყობილი გმირობა ექვსას განრისხებით სუვენირი</li>
                </ul>
                <iframe src="https://www.youtube.com/embed/cXx489yL6PE" frameborder="0"></iframe>
            </div>
            <div class="right">
                @if ($opportunity->disabilities && sizeof($opportunity->disabilities) > 0)
                <div class="firago firago--upper firago--dark-brown firago--smm">შესაძლებლობა ადაპტირებულია:</div>
                <ul class="disabilities">
                    @foreach ($opportunity->disabilities as $disability)
                    <li>
                        <img src="{{ asset('/storage/' . $disability->getImagePath()) }}" alt="">
                        <span>{{$disability->type}}</span>
                    </li>
                    @endforeach
                </ul>
                @endif
                <div class="bordered-container bordered-container--grey contact-info">
                    <div class="heading">საკონტაქტო ინფორმაცია</div>
                    @if($opportunity->latitude && $opportunity->longitude)
                    <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $opportunity->latitude . ',' . $opportunity->longitude }}" target=_blank class="link">
                        <div class="icon">
                            <img src="{{ asset('img/icons/marker-grey.svg') }}" alt="marker">
                        </div>
                        <span>{!! $opportunity->address !!}</span>
                    </a>
                    @else
                    <div class="link">
                        <div class="icon">
                            <img src="{{ asset('img/icons/marker-grey.svg') }}" alt="marker">
                        </div>
                        <span>{!! $opportunity->address !!}</span>
                    </div>
                    @endif
                    @if(isset($opportunity->phone) && $opportunity->phone)
                    <a href="tel:{{$opportunity->phone}}" class="link">
                        <div class="icon"><img src="{{ asset('img/icons/tel-grey.svg') }}" alt="tel"></div>
                        <span>{{ $opportunity->phone }}</span>
                    </a>
                    @endif
                    @if($opportunity->email)
                    <a href="{{ 'mailto:' . $opportunity->email }}" target=_blank class="link">
                        <div class="icon email">
                            <img src="{{ asset('img/icons/email-grey.svg') }}" alt="email">
                        </div>
                        <span>{{ $opportunity->email }}</span>
                    </a>
                    @endif
                    @if($web_page)
                    <a href="{{ $web_page }}" target=_blank class="link">
                        <div class="icon">
                            <img src="{{ asset('img/icons/globe-grey.svg') }}" alt="website">
                        </div>
                        <span>Official Website</span>
                    </a>
                    @endif
                    @if($fb_page)
                    <a href="{{ $fb_page }}" target=_blank class="link">
                        <div class="icon">
                            <img src="{{ asset('img/icons/facebook-grey.svg') }}" alt="facebook">
                        </div>
                        <span>Facebook</span>
                    </a>
                    @endif
                    @if($linkedin_page)
                    <a href="{{ $linkedin_page }}" target=_blank class="link">
                        <div class="icon">
                            <img src="{{ asset('img/icons/linkedin-grey.svg') }}" alt="linkedin">
                        </div>
                        <span>Linkedin</span>
                    </a>
                    @endif
                </div>
                <div class="map-wrapper">
                    <div id="map-container" class="map-container" data-lat="{{ $opportunity->latitude }}" data-long="{{ $opportunity->longitude }}">
                    </div>
                </div>
                <div class="bordered-container bordered-container--grey virtual-space-box">
                    <div class="firago firago--upper mb-4 firago--mdd firago--dark-brown">ტარდება ვირტუალურ სივრცეში</div>
                    <div class="firago firago--style-normal firago--smm mb-2 firago--dark-brown">ელექტრონული ბმული</div>
                    <a class="virtual-space-link" href="#">http://zoomlinsdfdfsdf.com</a>
                    <div class="green-dot"></div>
                </div>
            </div>
        </section>
        <div class="d-flex align-items-center switch-parent-block">
          <div class="interested">შესაძლებლობით დაინტერესებულია ({{ $interestedUsers }})</div>
          <div class="line"></div>
          <div class="switch switch--event">
              <div class="switch__item active">დისკუსია</div>
              <div class="switch__item">შეფასება</div>
              <!-- <div class="switch__item disabled">მედია</div> -->
          </div>
        </div>
        
    </div>
</div>


<div class="event-tabs">
    <div class="event-tab event-tab--discussion active">
        <!-- <div class="opportunity-inner-wrapper event-inner-page-opportunity-wrapper">
            <div class="wrapper">
                <div class="heading heading--fancy heading--upper">დისკუსია</div>
            </div>
        </div> -->
        <div class="bg-light-grey event-inner-page-opportunity-wrapper">
            <div class="wrapper opportunity-comments">
                <div class="comments">
                    <div id="discusion-comments-section-start" class="comment-form-container">
                        <div id="opportunity-comments-count" class="firago">კომენტარები ({{$totalComments}})</div>
                        @if ($auth && $guard == 'web')
                        <div class="comment-form">
                            <div class="comment__img comment__img--circle">
                                <img src="{{ url("/storage/" . $user->getImagePath() )}}" alt="avatar" draggable="false" />
                            </div>
                            <textarea name="" id="new_comment-text-id" cols="30" rows="10" placeholder="დაამატეთ კომენტარი..."></textarea>
                            <button id="new_comment_button" class="button--red d-flex justify-content-center align-items-center disabled " disabled data-opportunity-id="{{ $opportunity->id }}" data-user-id="{{ $user->id }}">
                                <span class="mr-1">დაწერე კომენტარი</span>
                                <img src="{{ asset('img/icons/comment-white.svg') }}" alt="send">
                            </button>
                        </div>
                        <!-- <button id="new_comment_button" class="button--red d-flex justify-content-center align-items-center disabled " disabled data-opportunity-id="{{ $opportunity->id }}" data-user-id="{{ $user->id }}">
                            <span class="mr-1">დაწერე კომენტარი</span>
                            <img src="{{ asset('img/icons/comment-white.svg') }}" alt="send">
                        </button> -->
                        @endif
                    </div>
                    @foreach ($opportunityComments as $comment)
                    @include('renders.opportunityCommentRender')
                    @endforeach
                    <div id="discusion-comments-section-end" class="d-flex justify-content-center">
                        @if ($hasMoreComments)
                        <a id="see-more-comments" data-opportunity-id="{{ $opportunity->id }}" class="link-fancy m-h-auto mt-5 mb-4">
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

    <div class="event-tab event-tab--rating">
        <div class="opportunity-inner-wrapper">
            <div class="wrapper">
                <div class="heading heading--fancy heading--upper">შეფასება</div>
                <div class="event-raiting-container">
                    <div class="wrapper">
                        <div class="event-rating event-rating--grey">
                            <div class="score">
                                <img src="{{ asset('img/icons/star-yellow.svg') }}" alt="star">
                                {{number_format($overallAverage, 1, '.', ',')}}
                                <div class="before">(<span>{{ $questionAllScoresCount }}</span> შეფასება)</div>
                            </div>
                            <div class="criterias">
                                @foreach ($questionPropertyAnswers as $property => $count)
                                <div class="criteria">
                                    <div class="criteria__key">{{$property}}</div>
                                    <div class="criteria__value">{{$count}}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-light-grey">
            @if(count($queryMessages))
            <div class="wrapper opportunity-feedback">
                <div class="comments" data-feedback-page="1" data-messages-count="{{ $numMessages }}">
                    @foreach($queryMessages as $message)
                    <div class="comment" data-message-id="{{$message->id}}">
                        <div class="comment__votes">
                            <div class="comment__vote comment__vote--up @if($message->isLikeduser(1)) active @endif">
                                <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg" data-popup-message='კომენტარის შეფასებისთვის გაიარე ავტორიაზაცია'>
                                    <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
                                </svg>
                                <div class="number">{{$message->likedUsers()->count()}}</div>
                            </div>
                            <div class="comment__vote comment__vote--down @if($message->isLikeduser(0)) active @endif">
                                <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg" data-popup-message='კომენტარის შეფასებისთვის გაიარე ავტორიაზაცია'>
                                    <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
                                </svg>
                                <div class="number">{{$message->dislikedUsers()->count()}}</div>
                            </div>
                        </div>
                        <div class="comment__img comment__img--circle">
                            <img src="{{ url('/storage/' . $message->getUserPicture()) }}" alt="profile-picture" draggable="false" />
                        </div>
                        <div class="comment__text">
                            <div class="comment__author">{{ $message->getUserName()}}</div>
                            <p class="comment__content">{!! $message->message !!}</p>
                        </div>
                        <div class="comment__actions">
                            <div class="comment__date">{{$message->getDateString()}}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($numMessages > $numMessagesPerPage)
                <div class="d-flex justify-content-center">
                    <a href="#" class="load-feedback link-fancy m-h-auto mt-5 mb-4" data-opportunity-id="{{$opportunity->id}}" data-num-messages-per-page="{{$numMessagesPerPage}}">
                        <div class="title">ნახე მეტი</div>
                        <div class="attribute">
                            <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                        </div>
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
</div>
</div>
<div class="wrapper no-padding-md">
    <!-- <div class="blue-container event-inner-main">
        <div class="event__date">{!! $opportunity->getDateString() !!}</div>
        <div class="middle">
            <div class="bordered-container bordered-container--red host-details">
                <div class="top d-flex mb-2">
                    <div class="organization-img">
                        <a href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}"><img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img"></a>
                    </div>
                    <div class="organization-title">
                        <a href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}">
                            <h4 class="heading heading--lg">{{ $company->name }}</h4>
                        </a>
                        <div class="subs-amount"><span>{{ $subsCount }} </span>გამომწერი</div>
                    </div>
                </div>
                @php
                $isSubbed = (isset($user) && $user->isSubscribedToCompany($company->id));
                @endphp
                <div class="d-flex">
                    <div class="event__date">{!! $opportunity->getDateString() !!}</div>
                    <button class="subscribe button--red align-items-center @if($isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/unsubscribe-company">
                        <span>გამოწერილი</span>
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                    </button>
                    <button class="subscribe button button--red align-items-center @if(!$isSubbed) active @endif" data-id="{{ $company->id }}" data-url="/subscribe-company" data-popup-message='ორგანიზაცის გამოსაწერად გაიარე ავტორიაზაცია'>
                        <span>გამოიწერე ორგანიზაცია</span>
                        <img src="{{ asset('img/icons/subscribe-white.svg') }}" alt="subscribe">
                    </button>
                </div>
            </div>
            <div class="tags">
                <div class="tag-links">
                    @foreach($opportunity->categories as $category)
                    <a href="{{ url('/' . app()->getLocale() . '/category/' . $category->id) }}" class="tag bordered-container">{{ $category->name }}</a>
                    @endforeach
                </div>

            </div>
            <div class="event-texts">
                <div class="heading heading--lgg mb-2 mt-2">{{ $opportunity->name }}</div>
                <div class="paragraph">
                    {!! $opportunity->description !!}
                </div>
            </div>
        </div>
        <div class="right">
            <div class="image">
                <img src="{{ asset('/storage/' . $opportunity->getImagePath()) }}" alt="img">
            </div>
            <div class="buttons">
                <a href="{{ $application_url }}" target=_blank action="add-going" data-opportunity-id="{{ $opportunity->id }}" class="button--red add-going url-button @if($application_url) open-url @endif @if($urlButtonAction == 'add-going') active @endif @if($finished) disabled @endif" data-popup-message='შესაძლებლობაზე რეგისტრაციისთვის გაიარეთ ავტორიზაცია'>
                    @if($opportunity->id == 9)
                    <span>Apply now</span>
                    @else
                    <span>აპლიკაციის შევსება</span>
                    @endif
                    <img src="{{ asset('img/icons/document-white.svg') }}" alt="application">
                </a>
                <div action="remove-going" data-opportunity-id="{{ $opportunity->id }}" class="button--red url-button @if($urlButtonAction == 'remove-going') active @endif">
                    @if($opportunity->id == 9)
                    <span>Registered</span>
                    @else
                    <span>რეგისტრირებულია</span>
                    @endif
                    <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                </div>
                <div action="add-favorite" data-opportunity-id="{{ $opportunity->id }}" class="button--red url-button @if(!$opportunity->isFavorite($user, $opportunity->id)) active @endif add-fav @if($finished) disabled @endif" data-popup-message='რჩეულებში დასამატებლად გაიარეთ ავტორიზაცია'>
                    <span>რჩეულებში დამატება</span>
                    <img src="{{ asset('img/icons/heart-white.svg') }}" alt="favorites">
                </div>
                <div action="remove-favorite" data-opportunity-id="{{ $opportunity->id }}" class="button--red @if($auth && $opportunity->isFavorite($user, $opportunity->id)) active @endif url-button">
                    <span>რჩეულებში დამატებულია</span>
                    <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                </div>
                @if(count($mediaUrls))
                <a href="#" target=_blank class="multiple-download button--red url-button button--white active">
                    @if($opportunity->id == 9)
                    <span>Download files</span>
                    @else
                    <span>ფაილების გადმოტვირთვა</span>
                    @endif
                    <img src="{{ asset('img/icons/download-red.svg') }}" alt="download">
                </a>
                @endif
                <div class="share share-inner" data-url="{{ $opportunity->getShortURL() }}">
                    <img src="{{ asset('img/icons/share-icon.svg') }}" alt="share">
                </div>
            </div>
            <div class="bordered-container contact-info">
                <div class="heading heading--md">ინფორმაცია</div>
                @if($opportunity->latitude && $opportunity->longitude)
                <a href="{{ 'https://www.google.com/maps/search/?api=1&query=' . $opportunity->latitude . ',' . $opportunity->longitude }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/marker-green.svg') }}" alt="marker">
                    </div>
                    <span>{!! $opportunity->address !!}</span>
                </a>
                @else
                <div class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/marker-green.svg') }}" alt="marker">
                    </div>
                    <span>{!! $opportunity->address !!}</span>
                </div>
                @endif
                @if(isset($opportunity->phone) && $opportunity->phone)
                <a href="tel:{{$opportunity->phone}}" class="link">
                    <div class="icon"><img src="{{ asset('img/icons/tel-green.svg') }}" alt="tel"></div>
                    <span>{{ $opportunity->phone }}</span>
                </a>
                @endif
                @if($opportunity->email)
                <a href="{{ 'mailto:' . $opportunity->email }}" target=_blank class="link">
                    <div class="icon email">
                        <img src="{{ asset('img/icons/email-green.svg') }}" alt="email">
                    </div>
                    <span>{{ $opportunity->email }}</span>
                </a>
                @endif
                @if($web_page)
                <a href="{{ $web_page }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/globe-green.svg') }}" alt="website">
                    </div>
                    <span>Official Website</span>
                </a>
                @endif
                @if($fb_page)
                <a href="{{ $fb_page }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/facebook-green.svg') }}" alt="facebook">
                    </div>
                    <span>Facebook</span>
                </a>
                @endif
                @if($linkedin_page)
                <a href="{{ $linkedin_page }}" target=_blank class="link">
                    <div class="icon">
                        <img src="{{ asset('img/icons/linkedin-green.svg') }}" alt="linkedin">
                    </div>
                    <span>Linkedin</span>
                </a>
                @endif
            </div>
            <div class="texts-mobile">
                <div class="heading heading--lgg mb-2">{{ $opportunity->name }}</div>
                <div class="paragraph">
                    {!! $opportunity->description !!}
                </div>
            </div>
            <div class="map-wrapper">
                <div id="map-container" class="map-container" data-lat="{{ $opportunity->latitude }}" data-long="{{ $opportunity->longitude }}">
                </div>
            </div>
        </div>
    </div> -->
    <!-- <div class="switch switch--event">
        <div class="switch__item active">დისკუსია</div>
        <div class="switch__item">შეფასება</div>
        <div class="switch__item disabled">მედია</div>
    </div> -->

    <!-- <div class="heading heading--fancy no-padding">დისკუსია</div> -->
</div>

<!--<div class="fb-comments" data-href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" data-width="500" data-numposts="5"></div>-->

@endsection
