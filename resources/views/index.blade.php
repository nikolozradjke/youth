@extends('layouts.master')



@section('content')
<div class="popup popup-registration-success @if(app('request')->input('company_registered')) popup-active @endif">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="popup__close d-flex align-items-center">
            <img src="{{ asset('img/icons/x-blue-rect.svg') }}" alt="close">
        </div>
        <div class="top">
            <img src="{{ asset('img/icons/popup-check-red.svg') }}" alt="checkmark" class="mr-2">
            <p class="firago firago--dark-brown firago--mdd">გილოცავთ, თქვენ წარმატებით გაიარეთ რეგისტრაცია</p>
        </div>
        <p class="middle">თუ გაქვთ მიმდინარე ან უახლოესი ტრენინგები, სემინარები,
            ბანაკები და ა.შ, მაშინ დაამატეთ შესაძლებლობა</p>
        @if(!isset($pagename) || (isset($pagename) && $pagename != 'registration' && $pagename != 'login' ) )
        @if(isset($auth) && $auth && isset($guard) && $guard == 'company')
        <a class="button button--red justify-content-center" href="{{ url('/' . app()->getLocale() . '/admin/opportunity/create') }}" target=_blank>
        <img src="{{ asset('img/icons/plus-double-white.svg') }}" alt="add opportunity" class="mr-1">
            <span>დაამატე შესაძლებლობა</span>
        </a>
        @endif
        @endif
    </div>
</div>

@if(!$auth && $staticData && sizeof($staticData) > 0)
<section class="section-join-us">
    <div class="wrapper no-padding-md">
        <div class="join-us">
            {{-- First Section --}}
            <div class="text-content user-welcome">
                <div class="heading heading--md heading-light">{{ $staticData->first()->user_section_title }}</div>
                <h2 class="heading heading--lgg user-heading">{{ $staticData->first()->user_section_subtitle }}</h2>
                <div class="paragraph">
                    {!! $staticData->first()->user_section_text !!}
                </div>
                <a href="{{ url('/' . app()->getLocale() . '/user-registration') }}" class="link-fancy user-button">
                    <div class="title">დარეგისტრირდი</div>
                    
                </a>
            </div>

            <div class="text-content user-welcome">
                <div class="heading heading--md heading-light"></div>
                <h2 class="heading heading--lgg user-heading">ხარ ახალგაზრდული მუშაკი?</h2>
                <div class="paragraph">
                შემოგვიერთდი, რომ გაიგო რა შესაძლებლობები არსებობს შენთვის საქართველოში და მის გარეთ
                </div>
                <a href="{{ route('user-worker-registration') }}" class="link-fancy user-button youth-worker-btn">
                    <div class="title">დარეგისტრირდი</div>
                    
                </a>
            </div>

            

            @foreach ($staticData as $data)
            @if ($staticData->first() == $data)
            @continue
            @endif
            <div class="text-content organization-welcome">
                <div class="heading heading--md heading-light">{{ $data->user_section_title }}</div>
                <h2 class="heading heading--lgg org-heading">{{ $data->user_section_subtitle }}</h2>
                <div class="paragraph">
                    {!! $data->user_section_text !!}
                </div>
                <a href="{{ url('/' . app()->getLocale() . '/org-registration' ) }}" class="link-fancy organization-button">
                    <div class="title">დარეგისტრირდი</div>
                   
                </a>
                <img src="{{ asset('img/axalgazrdoba-img-lg.svg') }}" alt="youth agency" class="img-lg">
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<section class="section-highlighted ">
    <div class="wrapper">
        <h4 class="heading heading--fancy">გამორჩეული შესაძლებლობები</h4>
        <div class="grid-container">
            @php
            $classes = ['item-md', 'item-sm', 'item-sm', 'item-md', 'item-lg'];
            @endphp
            @foreach($topOpportunities as $index=>$opportunity)
            <div class="event item {{ $classes[$index] }}">
                <div class="event">
                    <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__img">
                        <img src="{{ asset('/storage/' . $opportunity->getImagePath()) }}" alt="eventimg">
                    </a>
                    <div class="event__bottom">
                        <div class="event__date">{!! $opportunity->getDateString() !!}</div>
                        <div class="event__desc">
                            <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__title">
                                <h3>{{ $opportunity->name }}</h3>
                            </a>
                            <h4>{{ $opportunity->company->name }}</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@if($auth && count($subscribedOpportunities) > 0)
<section class="my-events">
    <div class="wrapper">
        <h4 class="heading heading--fancy">გამოწერილი ორგანიზაციები და კატეგორიები</h4>
    </div>
    <div class="pt-4">
        <div class="wrapper ">
            <div class="events subscribed">
                @foreach($subscribedOpportunities as $opportunity)
                @include('templates.opportunity')
                @endforeach
            </div>
            @if($showMoreSubscribed)

            
            <div class="d-flex justify-content-center">
                <a href="{{ url('/' . app()->getLocale() . '/subscribed-events') }}" class="link-fancy m-h-auto mb-8 see-all-opportunities">
                    <div class="title">ნახე ყველა შესაძლებლობა</div>
                    <!-- <div class="attribute">
                        <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                    </div> -->
                </a>
            </div>
            @endif
        </div>
    </div>
    </div>
</section>
@endif
@php
$title = 'შესაძლებლობები';
$showAllOpportunities = true;
@endphp
<section class="main-page-events">
    <div class="page-bgs">
      <div></div>
      <div></div>
    </div>
    

      <div class="wrapper opportunities-wrapper">
    
        <div class="heading-container">
            <div class="heading heading--fancy">@if(isset($title)) {{ $title }} @else {{ 'შესაძლებლობები' }} @endif
                @if(isset($showSubButton) && $showSubButton)
                    @php
                        $isSubbed = (isset($user) && $user->isSubscribedToCategory($category->id));
                    @endphp
                    <button class="subscribe button--red ml-3 justify-content-center align-items-center @if($isSubbed) active @endif" data-id="{{ $category->id }}" data-url="/unsubscribe-category">
                        <img src="{{ asset('img/icons/check-white.svg') }}" alt="checkmark">
                        <span>გამოწერილი</span>
                    </button>
                    <button class="subscribe button--red ml-3 justify-content-center align-items-center @if(!$isSubbed) active @endif" data-id="{{ $category->id }}" data-url="/subscribe-category" data-popup-message='კატეგორიის გამოსაწერად გაიარეთ ავტორიზაცია'>
                        <span>გამოიწერე კატეგორია</span>
                    </button>
                @endif
            </div>
            <!-- <div class="switch opportunity-switch">
                <div class="switch__item active" data-sort="schedule_date">უახლესი</div>
                <div class="switch__item" data-sort="start_date">მოახლოებული</div>
            </div> -->
        </div>
        @if(count($opportunities))
      </div>    
        <div class="main-page--volunteer main-page-sliders">
          <h3>მოხალისეობა</h3>
          <div class="swiper">
            <div class="events swiper-wrapper">
              
            @forelse($vol_opportunities as $op)

              <div class="single-card swiper-slide">
                    <a class="card-image-wrapper" href="{!! route('opportunity', ['id' => $op->id]) !!}">
                      <div class="card-img" style="background-image: url({{ asset('/storage/' . $op -> getImagePath()) }})"></div>
                  </a>
                  <div class="card-info">
                      <a href="{!! route('opportunity', ['id' => $op->id]) !!}">
                          <div class="info-title" title="{{ $op->name }}">
                                  {{ $op->name }}
                          </div>
                      </a>
                      <div class="d-flex align-items-start justify-content-between card-info-add-block">
                        <a class="card-info-and-fav" href="{!! route('organization', ['id' => $op->company->id]) !!}">
                            <div class="info-company">
                                <div class="company-img" style="background-image: url({{ asset('/storage/' . $op->company->getImagePath()) }})"></div>
                                <div class="company-name" title="{{ $op->company->name }}">
                                    {{ $op->company->name }}
                                </div>
                            </div>
                        </a>
                        <div action="{{ $op->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($op -> favorite) selected @endif" data-opportunity-id="{{ $op->id }}">
                            @include('svg.heart-black')
                        </div>

                      </div>
                      <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                        <div class="location-wrapper">
                            <div class="icon-pin">
                                @include('svg.location-marker')
                            </div>
                            <div class="info-location">
                                @if($op->address)
                                {!! $op->address !!}
                                @else
                                <div>ონლაინ ღონისძიება</div>
                                @endif
                            </div>
                        </div>
                        
                          <div class="d-flex align-items-center justify-content-center info-date">{{ $op->getDateString() }}</div>
                        
                      </div>
                      
                  </div>
              </div>
              
            @empty
            @endforelse
    
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          
        </div>
        <div class="main-page--youthwork main-page-sliders">
          <h3>ახალგაზრდული საქმიანობა</h3>
          <div class="swiper">
            <div class=" events swiper-wrapper">
              @forelse($young_opportunities as $op)

              <div class="single-card swiper-slide">
                    <a class="card-image-wrapper" href="{!! route('opportunity', ['id' => $op->id]) !!}">
                      <div class="card-img" style="background-image: url({{ asset('/storage/' . $op -> getImagePath()) }})"></div>
                  </a>
                  <div class="card-info">
                      <a href="{!! route('opportunity', ['id' => $op->id]) !!}">
                          <div class="info-title" title="{{ $op->name }}">
                                  {{ $op->name }}
                          </div>
                      </a>
                      <div class="d-flex align-items-start justify-content-between card-info-add-block">
                        <a class="card-info-and-fav" href="{!! route('organization', ['id' => $op->company->id]) !!}">
                            <div class="info-company">
                                <div class="company-img" style="background-image: url({{ asset('/storage/' . $op->company->getImagePath()) }})"></div>
                                <div class="company-name" title="{{ $op->company->name }}">
                                    {{ $op->company->name }}
                                </div>
                            </div>
                        </a>
                        <div action="{{ $op->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($op -> favorite) selected @endif" data-opportunity-id="{{ $op->id }}">
                            @include('svg.heart-black')
                        </div>

                      </div>
                      <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                        <div class="location-wrapper">
                            <div class="icon-pin">
                                @include('svg.location-marker')
                            </div>
                            <div class="info-location">
                                @if($op->address)
                                {!! $op->address !!}
                                @else
                                <div>ონლაინ ღონისძიება</div>
                                @endif
                            </div>
                        </div>
                        
                          <div class="d-flex align-items-center justify-content-center info-date">{{ $op->getDateString() }}</div>
                        
                      </div>
                      
                  </div>
              </div>
              
                @empty
                @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
         
        </div>
        <div class="main-page--education main-page-sliders">
          <h3>საგანმანათლებლო</h3>
          <div class="swiper">
            <div class=" events swiper-wrapper">
              @forelse($edu_opportunities as $op)

              <div class="single-card swiper-slide">
                    <a class="card-image-wrapper" href="{!! route('opportunity', ['id' => $op->id]) !!}">
                      <div class="card-img" style="background-image: url({{ asset('/storage/' . $op -> getImagePath()) }})"></div>
                  </a>
                  <div class="card-info">
                      <a href="{!! route('opportunity', ['id' => $op->id]) !!}">
                          <div class="info-title" title="{{ $op->name }}">
                                  {{ $op->name }}
                          </div>
                      </a>
                      <div class="d-flex align-items-start justify-content-between card-info-add-block">
                        <a class="card-info-and-fav" href="{!! route('organization', ['id' => $op->company->id]) !!}">
                            <div class="info-company">
                                <div class="company-img" style="background-image: url({{ asset('/storage/' . $op->company->getImagePath()) }})"></div>
                                <div class="company-name" title="{{ $op->company->name }}">
                                    {{ $op->company->name }}
                                </div>
                            </div>
                        </a>
                        <div action="{{ $op->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($op -> favorite) selected @endif" data-opportunity-id="{{ $op->id }}">
                            @include('svg.heart-black')
                        </div>

                      </div>
                      <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                        <div class="location-wrapper">
                            <div class="icon-pin">
                                @include('svg.location-marker')
                            </div>
                            <div class="info-location">
                                @if($op->address)
                                {!! $op->address !!}
                                @else
                                <div>ონლაინ ღონისძიება</div>
                                @endif
                            </div>
                        </div>
                        
                          <div class="d-flex align-items-center justify-content-center info-date">{{ $op->getDateString() }}</div>
                        
                      </div>
                      
                  </div>
              </div>
              
              @empty
              @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        </div>
        <div class="main-page--other main-page-sliders">  
          <h3>სხვა</h3>
          <div class="swiper">
            <div class="events swiper-wrapper">
              @forelse($other_opportunities as $op)

              <div class="single-card swiper-slide">
                    <a class="card-image-wrapper" href="{!! route('opportunity', ['id' => $op->id]) !!}">
                      <div class="card-img" style="background-image: url({{ asset('/storage/' . $op -> getImagePath()) }})"></div>
                  </a>
                  <div class="card-info">
                      <a href="{!! route('opportunity', ['id' => $op->id]) !!}">
                          <div class="info-title" title="{{ $op->name }}">
                                  {{ $op->name }}
                          </div>
                      </a>
                      <div class="d-flex align-items-start justify-content-between card-info-add-block">
                        <a class="card-info-and-fav" href="{!! route('organization', ['id' => $op->company->id]) !!}">
                            <div class="info-company">
                                <div class="company-img" style="background-image: url({{ asset('/storage/' . $op->company->getImagePath()) }})"></div>
                                <div class="company-name" title="{{ $op->company->name }}">
                                    {{ $op->company->name }}
                                </div>
                            </div>
                        </a>
                        <div action="{{ $op->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($op -> favorite) selected @endif" data-opportunity-id="{{ $op->id }}">
                            @include('svg.heart-black')
                        </div>

                      </div>
                      <div class="d-flex align-items-center justify-content-between opportunity-date-place">
                        <div class="location-wrapper">
                            <div class="icon-pin">
                                @include('svg.location-marker')
                            </div>
                            <div class="info-location">
                                @if($op->address)
                                {!! $op->address !!}
                                @else
                                <div>ონლაინ ღონისძიება</div>
                                @endif
                            </div>
                        </div>
                        
                          <div class="d-flex align-items-center justify-content-center info-date">{{ $op->getDateString() }}</div>
                        
                      </div>
                      
                  </div>
              </div>
              
              @empty
              @endforelse
            </div> 
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
          
        </div>


        @endif
        <div class="wrapper opportunities-wrapper">
          <p class="firago firago--blue firago--mdd not-found mb-3" style="display: none">შესაძებლობები არ მოიძებნა</p>
        </div>
        <!-- <div class="link-fancy-container"> -->
        @if(isset($showAllOpportunities) && $showAllOpportunities)
        <div class="wrapper opportunities-wrapper">
            <div class="d-flex justify-content-center">
                <a href="{{ url('/' . app()->getLocale() . '/events') }}" class="link-fancy m-h-auto mb-8 see-all-opportunities">
                    <div class="title">ნახე ყველა შესაძლებლობა</div>
                    <!-- <div class="attribute">
                        <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                    </div> -->
                </a>
            </div>
        </div>
        @elseif($opportunityCount > $numberPerPage)
        <div class="wrapper opportunities-wrapper">
            <nav id="opportunity-pagination" class="pagination-container opportunity-pagination">
                @include('renders.paginationRender',[
                    'opportunityCount' => $opportunityCount,
                    'numberPerPage'    => $numberPerPage,
                    'page'             => $page,
                    'term'             => ""
                ]) 
            </nav>
        </div>
        @endif
        <!-- </div> -->
   


</section>

@endsection