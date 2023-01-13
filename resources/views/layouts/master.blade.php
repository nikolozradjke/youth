<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if(isset($pagename) && ($pagename == 'index' || $pagename == 'opportunity' || $pagename == 'about' || $pagename == 'contact' || $pagename == 'opportunities' || $pagename == 'organization' || $pagename == 'login' || $pagename == 'registration' || $pagename == 'passwordReset'))
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    @else
    <!-- <meta name="viewport" content="width=1024, initial-scale=0.0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    @endif

    <link rel="shortcut icon" type="image/png" href="{{ asset('img/icons/favicon.png') }}">
    @php
    $ogTags = request()->ogTag;
    if (! isset($og_title)) $og_title = $ogTags->title;
    if (! isset($og_description)) $og_description = $ogTags->description;
    if (! isset($og_image)) $og_image = $ogTags->image;
    @endphp
    <title>{{ $og_title }}</title>
    <meta property="og:title" content="{{ $og_title }}" />
    <meta property="og:description" content="{{ strip_tags($og_description) }}" />
    <meta property="og:image" content="{{ asset( '/storage/' . $og_image ) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ request()->url() }}" />

    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css"> -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dropzone.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @if(isset($admin) && $admin)
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" href="{{ asset('css/admin/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
    <!-- END: Custom CSS-->
    @endif
    <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css"> -->
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous">
    </script> -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/datepicker.min.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"> -->
    </script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <?php 
        $analytics = \DB::table('contacts')->whereId(1)->select('analytics')->first();
    ?>
    @if(!is_null($analytics))
    {!! $analytics->analytics !!}
    @endif
</head>

@php

if(isset($categor)){
$category = $categor;
}
$paddingClass='padding-top--inner';
if(isset($has_filter) && $has_filter) {
if(isset($dropdownFilters) && $dropdownFilters){
$paddingClass='padding-top--lg';
}else{
$paddingClass='padding-top';
}
}
if(isset($pagename) && $pagename == 'organizations'){
$paddingClass = 'padding-top--lg';
}
@endphp

<body data-url="{{ url('/') }}" is-logged-in="{{ isset($auth) && $auth }}" @if(isset($body_class)) class="{{ $body_class . ' ' . $paddingClass }}" @else class="{{ $paddingClass }}" @endif @if(isset($page)) data-page="{{ $page }}" @endif @if(isset($numberPerPage)) data-number-per-page="{{ $numberPerPage }}" @endif @if(isset($companyNumberPerPage)) data-company-number-per-page="{{ $companyNumberPerPage }}" @endif @if(isset($company)) data-company="{{ $company->id }}" @endif @if(isset($category)) data-category="{{ $category->id }}" @endif @if(isset($region)) data-region="{{ $region->id }}" @endif @if(isset($subscribeQuery)) data-subscribe-query="{{ $subscribeQuery }}" @endif data-locale="{{ app()->getLocale() }}" data-type-id="{{ $type_id ?? '' }}">

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0&appId=1566945996726038&autoLogAppEvents=1"></script>

    <!-- feedback btn -->
    <a href="https://ee.kobotoolbox.org/x/wHFvRcot" target="_blank" class="feedback-btn">ანონიმური შეფასება</a>
  <!--
    <div class="popup feedback-popup">
      <div class="popup__content">
        <div class="popup__close d-flex align-items-center justify-content-center">
          <img src="{{ asset('img/icons/close-img-newblack.svg') }}" alt="close" draggable="false">
        </div>
        <div class="title-default" style="display: block;">
            <div class="heading heading--md mb-4">
              ანონიმური შეფასება
            </div>
        </div>

        <div class="feedback-form">
          <form action="{{ route('review') }}" method="POST">
            @csrf
            <div class="fb-form-row">
              <h4 >რამდენად მარტივია პლატფორმა გამოსაყენებლად?</h4>
              <label for="easy-to-use" class="d-flex align-items-center">
                <input type="radio" id="easy-to-use"  name="dificulty" value="მარტივი">
                <span class="fb-radio"></span>
                <span>მარტივი</span>
              </label>
              <label for="medium-to-use"  class="d-flex align-items-center">

                <input type="radio" id="medium-to-use"  name="dificulty" value="საშუალო">
                <span class="fb-radio"></span>
                <span>საშუალო </span>
              </label>
              <label for="hard-to-use"  class="d-flex align-items-center">

                <input type="radio" id="hard-to-use"  name="dificulty" value="რთული">
                <span class="fb-radio"></span>
                <span>რთული</span>
              </label>
            </div>
            <div class="fb-form-row">
              <h4 for="">ასაკობრიბვი შუალედი</h4>
              <label for="fb-young"  class="d-flex align-items-center">

                <input type="radio" id="fb-young"  name="age" value="18-25">
                <span class="fb-radio"></span>
                <span>18 - 25</span>
              </label>
              <label for="fb-middle"  class="d-flex align-items-center">
                <input type="radio" id="fb-middle"  name="age" value="25-35">
                <span class="fb-radio"></span>
                <span>25-35 </span>
              </label>
              <label for="fb-old"  class="d-flex align-items-center">
                <input type="radio" id="fb-old"  name="age" value="35-ზემოთ">
                <span class="fb-radio"></span>
                <span>35 - ზემოთ</span>
              </label>
            </div>

            <div class="fb-form-row">
              <h4>თქვენი აზრით რა არის გასაუმჯობესებელი</h4>
              <label for="fb-ui"  class="d-flex align-items-center">
                <input type="checkbox" id="fb-ui" name="improvement[]" value="ინტერფეისი">
                <span class="fb-check"></span>
                <span>ინტერფეისი</span>
              </label>
              <label for="fb-ux"  class="d-flex align-items-center">
                <input type="checkbox" id="fb-ux" name="improvement[]" value="სამომხმარებლო გამოცდილება">
                <span class="fb-check"></span>
                <span>სამომხმარებლო გამოცდილება</span>
              </label>
            </div>
            <div class="fb-form-row">
              <h4>ყველაზე ხშირად რომელ გვერდთან გაქვთ შეხება?</h4>
              <label for="fb-most-used-pages">
                <input id="fb-most-used-pages" name="pages" type="text" placeholder="მაგ: ელექტრონული ბიბლიოთეკა, შესაძლებლობები რუკა...">
              </label>
            </div>
            <div class="fb-form-row">
              <h4>გაგვიზიარეთ თქვენი მოსაზრება პლატფორმს შესახებ</h4>
              <label for="fb-message">
                <textarea name="review" id="fb-message" cols="30" rows="10"  placeholder="შეიყვანეთ ტექსტი"></textarea>

              </label>

            </div>
            <div class="fb-form-row d-flex align-items-center justify-content-end">
              <button type="submit">გაგზავნა</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    -->

     <!-- popup-active -->
    <div class="popup subscribe-result-popup {{ \Session::has('registration_success') ? 'popup-active' : '' }}" id="registration-success-popup">
      <div class="popup__content">
        <div class="popup__close d-flex align-items-center justify-content-center">
          <img src="{{ asset('img/icons/close-img-newblack.svg') }}" alt="close" draggable="false">
        </div>
        <div class="subscribe-result">
          <img class="img-success active" src="{{ asset('img/icons/checked-success.svg') }}" alt="close" draggable="false">
          <p>რეგისტრაცია წარმატებით დასრულდა</p>

        </div>
      </div>
    </div>

   
    <div class="popup subscribe-result-popup" id="subscribe-result-popup">
      <div class="popup__content">
        <div class="popup__close d-flex align-items-center justify-content-center">
          <img src="{{ asset('img/icons/close-img-newblack.svg') }}" alt="close" draggable="false">
        </div>
        <div class="subscribe-result">
          <img class="img-success" src="{{ asset('img/icons/checked-success.svg') }}" alt="close" draggable="false">
          <p></p>

        </div>
      </div>
    </div>

     

    <div class="header-bg-img">
      <img src="{{ asset('img/search-bg.png') }}" alt="img upload">
    </div>

    <div class="mobile-nav mobile-menu">
        <img src="{{ asset('img/icons/x-white.svg') }}" alt="close" class="close-mobile-menu">
        <div class="wrapper">
            <div class="mobile-menu-top">
                @if(isset($auth) && $auth)
                <div class="profile-pic">
                    <div class="pic-container">
                        <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="profile-picture">
                    </div>
                    <div class="profile-pic-upload">
                        <img src="{{ asset('img/icons/pencil-white.svg') }}" alt="img upload">
                    </div>
                </div>
                @endif
                <div class="auth-buttons">
                    <!-- @if(!isset($pagename) || (isset($pagename) && $pagename != 'registration' && $pagename != 'login' ) )
                    @if(isset($auth) && $auth && isset($guard) && $guard == 'company')
                    <a class="header__button" href="{{ url('/' . app()->getLocale() . '/admin/opportunity/create') }}" target=_blank>
                        <img src="{{ asset('img/icons/add-white.svg') }}" alt="add">
                        <span>დაამატე შესაძლებლობა</span>
                    </a>
                    @else
                    <div class="header__button login-popup-trigger">
                        <img src="{{ asset('img/icons/add-white.svg') }}" alt="add">
                        <span>დაამატე შესაძლებლობა</span>
                    </div>
                    @endif
                    @endif -->

                    @if(!(isset($auth) && $auth))
                    <a href="{{ url('/' . app()->getLocale() . '/login') }}" class="header__button margin-0 justify-content-center">
                        <!-- <img src="{{ asset('img/icons/user.svg') }}" alt="login"> -->
                        <span>შესვლა</span>
                        <div class="log-in-btn d-flex align-items-center justify-content-center">
                          <img src="{{ asset('img/icons/login-new.svg') }}" alt="" draggable="false">
                        </div>
                    </a>
                    <!-- <a href="#" class="header__reg__button">
                        <span>რეგისტრაცია</span>
                    </a> -->
                    @else
                    <div class="header__button header__button--logged-in margin-0">
                        <img src="{{ asset('img/icons/user.svg') }}" alt="login">
                        @php
                        if(isset($user->first_name))
                        {
                        $name = $user->first_name . ' ' . $user->last_name;
                        }
                        else
                        {
                        $name = $user->name;
                        }
                        @endphp
                        <span>{{ $name }}</span>
                    </div>
                    @endif



                </div>
            </div>
            @if((isset($auth) && $auth))
            <div class="profile-links">
                @if(isset($guard) && $guard == 'company')
                <a href="{{ url('/' . app()->getLocale() . '/admin') }}" target=_blank>
                    <img src="{{ asset('img/icons/admin-panel-new-black.svg') }}" alt="profile">
                    <span>მართვის პანელი</span>
                </a>
                @endif
                <a href="{{ url('/' . app()->getLocale() . '/profile') }}">
                    <img src="{{ asset('img/icons/prof-user-black.svg') }}" alt="profile">
                    <span>ჩემი პროფილი</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=password') }}">
                    <img src="{{ asset('img/icons/pass-key-black-thin.svg') }}" alt="password">
                    <span>პაროლის ცვლილება</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=organizations') }}">
                    <img src="{{ asset('img/icons/prof-notification-black.svg') }}" alt="subscription organizations">
                    <span>გამოწერილი ორგანიზაციები</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=categories') }}">
                    <img src="{{ asset('img/icons/prof-category-black.svg') }}" alt="subscription categories">
                    <span>გამოწერილი კატეგორიები</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=fav-events') }}">
                    <img src="{{ asset('img/icons/prof-heart-black.svg') }}" alt="subscription categories">
                    <span>რჩეული შესაძლებლობები</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=going-events') }}">
                    <img src="{{ asset('img/icons/prof-user-edit-black.svg') }}" alt="subscription categories">
                    <span>რაზე დავრეგისტრირდი</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/profile?tab=completed-events') }}">
                    <img src="{{ asset('img/icons/prof-trend-up-black.svg') }}" alt="subscription categories">
                    <span>დასრულებული შესაძლებლობები</span>
                </a>
                <a href="{{ url('/' . app()->getLocale() . '/logout') }}" class="mt-4">
                    <div class="logout">
                        <img src="{{ asset('img/icons/prof-logout-black.svg') }}" alt="logout">
                        <span class="">გამოსვლა</span>
                    </div>
                </a>
            </div>
            @endif
            <nav class="header__nav">
                <ul>
                    <li @if(isset($pagename) && $pagename=='opportunities' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/events') }}">შესაძლებლობები</a></li>
                    <li @if(isset($pagename) && $pagename=='abilities' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/abilities') }}">შესაძლებლობების რუკა</a></li>
                    <li @if(isset($pagename) && $pagename=='library' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/library') }}">ბიბლიოთეკა</a></li>
                    <li @if(isset($pagename) && $pagename=='organizations' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/organizations') }}">ორგანიზაციები</a></li>
                    <li @if(isset($pagename) && $pagename=='about' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/about') }}">ჩვენ შესახებ</a></li>
                    <li @if(isset($pagename) && $pagename=='contact' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/contact') }}">კონტაქტი</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="mobile-filters mobile-menu">
        <div class="search-mobile">
            <form action="/search" method="GET" class="search-form">
                <div class="search">
                    <input name="text" required type="text" class="search__input" placeholder="მოძებნე შესაძლებლობა ან ორგანიზაცია" value="{{ isset($term) ? $term : '' }}" />
                    <button class="search__submit"><img src="{{ asset('img/icons/search-white.svg') }}" alt="go"></button>
                </div>
            </form>
            <div class="burger-categories">
                <div class="burger-bar bar-1"></div>
                <div class="burger-bar bar-2"></div>
                <div class="burger-bar bar-3"></div>
            </div>
        </div>
        <div class="firago firago--normal forago--xs">შესაძლებლობები</div>
        <div class="categories @if(!(isset($dropdownFilters) && $dropdownFilters)) categories-grid @endif">
            @php
            $count = 0;
            @endphp
            @if(isset($category) && isset($markActiveCategory) && $markActiveCategory)
            <a title="{{ $category->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $category->id) }}" class="category active">
                <h3 class="category__title">{{ $category->name }}</h3>
                <div class="category__amount">{{ $category->getOpportunityCount() }}</div>
            </a>
            @php
            $count += 1;
            @endphp
            @endif
            @if(isset($categories))
            @foreach($categories as $indx=>$cat)
            @if(!isset($category) || (isset($category) && $cat->id != $category->id))
            <a title="{{ $cat->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $cat->id) }}" class="category">
                <h3 class="category__title">{{ $cat->name }}</h3>
                <div class="category__amount">{{ $cat->getOpportunityCount() }}</div>
            </a>
            @php
            $count += 1;
            @endphp
            @endif
            @endforeach
            @endif
        </div>
        @if(isset($dropdownFilters) && $dropdownFilters)
        <div class="filters-container">
            <div class="wrapper">
                <div class="filters">
                    <div class="filter filter--region">
                        <div class="filter__button" default="რეგიონი">რეგიონი</div>
                        <div class="filter__dropdown">
                            <label class="checkbox-container checkbox-container--red uncheck-all">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <div class="title">ყველა რეგიონი</div>
                                <div class="plus">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.0911 4.06094H5.94266V0.9125C5.94266 -0.301562 4.05985 -0.301562 4.05985 0.9125V4.06094H0.911411C-0.302339 4.06094 -0.302339 5.94375 0.911411 5.94375H4.05985V9.09219C4.05985 10.3062 5.94266 10.3062 5.94266 9.09219V5.94375H9.0911C10.305 5.94375 10.305 4.06094 9.0911 4.06094Z" fill="#EE3048" />
                                    </svg>
                                </div>
                            </label>
                            <div class="separator separator-static"></div>
                            @foreach($regions as $region)
                            <label class="checkbox-container checkbox-container--red">
                                <input type="checkbox" data-id="{{ $region->id }}">
                                <span class="checkmark"></span>
                                <div class="title">{{ $region->name }}</div>
                                <div class="plus">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.0911 4.06094H5.94266V0.9125C5.94266 -0.301562 4.05985 -0.301562 4.05985 0.9125V4.06094H0.911411C-0.302339 4.06094 -0.302339 5.94375 0.911411 5.94375H4.05985V9.09219C4.05985 10.3062 5.94266 10.3062 5.94266 9.09219V5.94375H9.0911C10.305 5.94375 10.305 4.06094 9.0911 4.06094Z" fill="#EE3048" />
                                    </svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="filter filter--host">
                        <div class="filter__button" default="ორგანიზატორი">ორგანიზატორი</div>
                        <div class="filter__dropdown">
                            <label class="checkbox-container checkbox-container--red uncheck-all">
                                <input type="checkbox">
                                <span class="checkmark"></span>
                                <div class="title">ყველა ორგანიზატორი</div>
                                <div class="plus">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.0911 4.06094H5.94266V0.9125C5.94266 -0.301562 4.05985 -0.301562 4.05985 0.9125V4.06094H0.911411C-0.302339 4.06094 -0.302339 5.94375 0.911411 5.94375H4.05985V9.09219C4.05985 10.3062 5.94266 10.3062 5.94266 9.09219V5.94375H9.0911C10.305 5.94375 10.305 4.06094 9.0911 4.06094Z" fill="#EE3048" />
                                    </svg>
                                </div>
                            </label>
                            <div class="separator separator-static"></div>
                            @foreach($companies as $company)
                            <label class="checkbox-container checkbox-container--red">
                                <input type="checkbox" data-id="{{ $company->id }}" @if(isset($userCompanies) && in_array($company->id, $userCompanies)) checked @endif>
                                <span class="checkmark"></span>
                                <div class="title">{{ $company->name }}</div>
                                <div class="plus">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.0911 4.06094H5.94266V0.9125C5.94266 -0.301562 4.05985 -0.301562 4.05985 0.9125V4.06094H0.911411C-0.302339 4.06094 -0.302339 5.94375 0.911411 5.94375H4.05985V9.09219C4.05985 10.3062 5.94266 10.3062 5.94266 9.09219V5.94375H9.0911C10.305 5.94375 10.305 4.06094 9.0911 4.06094Z" fill="#EE3048" />
                                    </svg>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @if(isset($auth) && $auth)
                    <div class="filter filter--subscribed">
                        <div class="filter__button">შესაძლებლობები</div>
                        <div class="filter__dropdown">
                            <label class="checkbox-container checkbox-container--red">
                                <input type="radio" name="opportunities" @if(!isset($userCompanies)) checked @endif data-id="all">
                                <span class="checkmark"></span>
                                <div class="title">ყველა შესაძლებლობა</div>
                            </label>
                            <label class="checkbox-container checkbox-container--red">
                                <input type="radio" name="opportunities" @if(isset($userCompanies)) checked @endif data-id="subscribed">
                                <span class="checkmark"></span>
                                <div class="title">ჩემი შესაძლებლობები</div>
                            </label>
                        </div>
                    </div>
                    @endif
                    <button class="button button--red mt-2 mb-2">
                        <span class="d-inline-block">გაფილტვრა</span>
                        <img src="{{ asset('img/icons/filter-white.svg') }}" alt="filter">
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- ფილტრები და კატეგორიები დესკტოპზე -->
    <div class="header-container">
        <div class="banner banner--yellow">
            <div class="wrapper banner__content">
                <img src="{{ asset('img/icons/info-blue.svg') }}" alt="info">
                <div>პლატფორმა მუშაობს სატესტო რეჟიმში</div>
            </div>
        </div>
        <header class="header">
            <div class="wrapper header__content justify-content-between">
                <!--<div class="burger-nav">
                    <div class="burger-bar bar-1"></div>
                    <div class="burger-bar bar-2"></div>
                    <div class="burger-bar bar-3"></div>
                </div>-->
                <h1 class="header__logo">
                    <a href="{{ url('/' . app()->getLocale()) }}"><img src="{{ asset('img/icons/logo-black.svg') }}" alt="logo"></a>
                </h1>
                <nav class="header__nav">
                    <ul>
                        <li @if(isset($pagename) && $pagename=='opportunities' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/events') }}">შესაძლებლობები</a></li>
                        <li @if(str_contains(url()->full(), 'abilities')) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/abilities') }}">შესაძლებლობების რუკა</a></li>
                        <li @if(str_contains(url()->full(), 'library')) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/library') }}">ბიბლიოთეკა</a></li>
                        <li @if(isset($pagename) && $pagename=='organizations' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/organizations') }}">ორგანიზაციები</a></li>
                        <li @if(isset($pagename) && $pagename=='about' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/about') }}">ჩვენ შესახებ</a></li>
                        <li @if(isset($pagename) && $pagename=='contact' ) class="active" @endif><a href="{{ url('/' . app()->getLocale() . '/contact') }}">კონტაქტი</a></li>
                    </ul>
                </nav>
                <div class="header__right">


                    @auth

                    <div class="dropdown-container">
                        <div class="header__button header__button--logged-in margin-0">
                            <!-- <img src="{{ asset('img/icons/user.svg') }}" alt="login"> -->

                            @php
                            if(isset(\Auth::user()->first_name))
                            {
                            $name = \Auth::user()->first_name . ' ' . \Auth::user()->last_name;
                            }
                            else
                            {
                            $name = \Auth::user()->name;
                            }
                            @endphp
                            <span>{{ $name }}</span>
                            <img class="logged-in-user-img" src="{{ asset('/storage/' . \Auth::user()->getImagePath()) }}" alt="profile-picture">
                        </div>
                        <div class="dropdown header__button">
                            @if(isset($guard) && $guard == 'company')
                            <a href="{{ url('/' . app()->getLocale() . '/admin') }}" target=_blank class="org-profile-panle">
                                <img src="{{ asset('img/icons/admin-panel-new-white.svg') }}" alt="profile">
                                <span>მართვის პანელი</span>
                            </a>
                            @endif
                            <a href="{{ url('/' . app()->getLocale() . '/profile') }}">
                                <img src="{{ asset('img/icons/prof-user.svg') }}" alt="profile">
                                <span>ჩემი პროფილი</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=password') }}">
                                <img src="{{ asset('img/icons/pass-key-white-thin.svg') }}" alt="password">
                                <span>პაროლის ცვლილება</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=organizations') }}">
                                <img src="{{ asset('img/icons/prof-notification.svg') }}" alt="subscription organizations">
                                <span>გამოწერილი ორგანიზაციები</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=categories') }}">
                                <img src="{{ asset('img/icons/prof-category.svg') }}" alt="subscription categories">
                                <span>გამოწერილი კატეგორიები</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=fav-events') }}">
                                <img src="{{ asset('img/icons/prof-heart.svg') }}" alt="subscription categories">
                                <span>რჩეული შესაძლებლობები</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=going-events') }}">
                                <img src="{{ asset('img/icons/prof-user-edit.svg') }}" alt="subscription categories">
                                <span>რაზე დავრეგისტრირდი</span>
                            </a>
                            <a href="{{ url('/' . app()->getLocale() . '/profile?tab=completed-events') }}">
                                <img src="{{ asset('img/icons/prof-trend-up.svg') }}" alt="subscription categories">
                                <span>დასრულებული შესაძლებლობები</span>
                            </a>
                            <b class="line line--brown"></b>
                            <a href="{{ url('/' . app()->getLocale() . '/logout') }}">
                                <div class="logout">
                                    <img src="{{ asset('img/icons/prof-logout.svg') }}" alt="logout">
                                    <span>გამოსვლა</span>
                                </div>
                            </a>
                        </div>
                    </div>
                    @else
                    <!-- <a href="#" class="header__reg__button margin-0 mr-1">
                        <span>რეგისტრაცია</span>
                    </a> -->
                    <a href="{{ url('/' . app()->getLocale() . '/login') }}" class="header__button margin-0 ">
                        <!-- <img src="{{ asset('img/icons/user.svg') }}" alt="login"> -->
                        <span>შესვლა</span>
                        <div class="log-in-btn d-flex align-items-center justify-content-center">
                          <img src="{{ asset('img/icons/login-new.svg') }}" alt="">
                        </div>
                    </a>
                    @endauth

                    <!--<div class="lang-container">
                        <div class="lang">
                            @php
                                $path = request()->path();
                                $path = str_replace('ka', '', $path);
                                $path = str_replace('en', '', $path);
                            @endphp
                            @if(app()->getLocale() == 'ka')
                                <div class="lang--selected">ge</div>
                                <b class="arrow">
                                    <img src="{{ asset('img/icons/arrow-down-green.svg') }}" alt="arrow" draggable="false">
                                </b>
                                <div class="lang--available">
                                    <a href="{{ url('/en' . $path) }}">en</a>
                                </div>
                            @else
                                <div class="lang--selected">en</div>
                                <b class="arrow">
                                    <img src="{{ asset('img/icons/arrow-down-green.svg') }}" alt="arrow" draggable="false">
                                </b>
                                <div class="lang--available">
                                    <a href="{{ url('/ka' . $path) }}">ge</a>
                                </div>
                            @endif
                        </div>
                    </div>-->

                </div>

                <div class="search-mobile">
                  <div class="burger-nav">
                    <div class="burger-bar bar-1"></div>
                    <div class="burger-bar bar-2"></div>
                    <div class="burger-bar bar-3"></div>
                  </div>
                </div>
            </div>
        </header>
        <div class="banners">
            @if(isset($auth) && $auth && isset($user->is_complete) && !$user->is_complete)
            <div class="banner">
                <div class="wrapper banner__content">
                    @php
                    $url = '/profile';
                    if(isset($guard) && $guard == 'company')
                    {
                    $url = '/admin/profile';
                    }
                    @endphp
                    <a href="{{ url('/' . app()->getLocale() . $url) }}">
                        <img src="{{ asset('img/icons/bell-red.svg') }}" alt="notification">
                        <div>გთხოვთ, დაასრულოთ პროფილის ინფორმაციის შევსება</div>
                    </a>
                    <div class="close close-banner">
                        <span class="mr-1">დახურვა</span>
                        <img src="{{ asset('img/icons/x-red.svg') }}" alt="close" draggable="false">
                    </div>
                </div>
            </div>
            @endif
            <!-- <div class="banner banner--yellow">
                <div class="wrapper banner__content">
                    <img src="{{ asset('img/icons/info-blue.svg') }}" alt="info">
                    <div>პლატფორმა მუშაობს სატესტო რეჟიმში</div>
                </div>
            </div> -->
        </div>
        <div class="header-bottom-mobile">
            <div class="wrapper">
                <!-- @if(!(isset($auth) && $auth))
                <div class="header__right">
                    <div class="header__button login-popup-trigger">
                        <img src="{{ asset('img/icons/plus-fancy-orange.svg') }}" alt="add">
                        <span>დაამატე შესაძლებლობა</span>
                    </div>
                    <a href="{{ url('/' . app()->getLocale() . '/login') }}" class="header__button margin-0">
                        <img src="{{ asset('img/icons/user-orange.svg') }}" alt="login">
                        <span>შესვლა</span>
                    </a>
                </div>
                @endif -->
                <div class="search-mobile">
                    <!-- <form action="/search" method="GET" class="search-form">
                        <div class="search">
                            <input name="text" required type="text" class="search__input" placeholder="მოძებნე შესაძლებლობა ან ორგანიზაცია" value="{{ isset($term) ? $term : '' }}">
                            <button class="search__submit"><img src="{{ asset('img/icons/search-white.svg') }}" alt="go"></button>
                        </div>
                    </form> -->
                    <!-- <div class="burger-nav">
                        <div class="burger-bar bar-1"></div>
                        <div class="burger-bar bar-2"></div>
                        <div class="burger-bar bar-3"></div>
                    </div> -->
                    <!--<div class="burger-categories">
                        <div class="burger-bar bar-1"></div>
                        <div class="burger-bar bar-2"></div>
                        <div class="burger-bar bar-3"></div>
                    </div>-->
                </div>
            </div>
        </div>
        @if((isset($has_filter) && $has_filter ) || (isset($dropdownFilters) && $dropdownFilters ))

        <div class="categorize">
            <div class="add-and-search-oportunity ">
              <div class="wrapper d-flex align-items-center justify-content-between">
                <form action="/search" method="GET" class="search-form">
                    <div class="search d-flex align-items-center">
                      <button class="search__submit mr-2"><img src="{{ asset('img/icons/search-normal.svg') }}" alt="go"></button>
                      <input name="text" required type="text" class="search__input" placeholder="მოძებნე შესაძლებლობა ან ორგანიზაცია">

                    </div>
                </form>


                @if(!isset($pagename) || (isset($pagename) && $pagename != 'registration' && $pagename != 'login' ) )
                @if(isset($auth) && $auth && isset($guard) && ($guard == 'company' || $guard == 'web' && \Auth::user()->company == 1))
                <a class="header__button" href="{{ url('/' . app()->getLocale() . '/admin/opportunity/create') }}" target=_blank>
                    <img src="{{ asset('img/icons/add.svg') }}" alt="add">
                    <span>დაამატე შესაძლებლობა</span>
                </a>
                @elseif(isset($auth) && $auth && isset($guard) && $guard == 'web' && \Auth::user()->company == 0)
                
                
                @else
                <div class="header__button login-popup-trigger">
                    <img src="{{ asset('img/icons/add.svg') }}" alt="add">
                    <span>დაამატე შესაძლებლობა</span>
                </div>
                @endif
                @endif


              </div>
            </div>
            @if(!in_array(url()->current(), $notShowfilterOnPages))
            <div class="categories-container initial @if(isset($pagename) && $pagename=='opportunities'  && !isset($_GET['type'])) bordered @endif">
                <div class="wrapper">
                    <div class="categories-inner-container">
                        <div class="categories active">
                            @if(isset($has_filter) && $has_filter && isset($categories))
                            <a href="{{ url('/' . app()->getLocale() . '/events?type=all') }}" data-type-id="all" class="category @if(isset($pagename) && $pagename=='opportunities' && !isset($_GET['type']) ) active @endif">
                                <h3 class="category__title">ყველა</h3>
                                <div class="category__amount">{{$total_count}}</div>
                            </a>
                            @foreach ($oppTypes as $type)
                            <a href="{{ url('/' . app()->getLocale() . '/events?type=' . $type->id) }}" data-type-id="{{$type->id}}" class="category">
                                <h3 class="category__title">{{$type->name}}</h3>
                                <div class="category__amount">{{$type->getOpportunityCount()}}</div>
                            </a>
                            @endforeach
                            @php
                            $count = 0;
                            @endphp
                            @if(isset($category) && isset($markActiveCategory) && $markActiveCategory)
                            <a style="display: none" title="{{ $category->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $category->id) }}" class="category active">
                                <h3 class="category__title">{{ $category->name }}</h3>
                                <div class="category__amount">{{ $category->getOpportunityCount() }}</div>
                            </a>
                            @php
                            $count += 1;
                            @endphp
                            @endif
                            @foreach($categories as $indx=>$cat)
                            @if(!isset($category) || (isset($category) && $cat->id != $category->id))
                            <a style="display: none" title="{{ $cat->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $cat->id) }}" class="category">
                                <h3 class="category__title">{{ $cat->name }}</h3>
                                <div class="category__amount">{{ $cat->getOpportunityCount() }}</div>
                            </a>
                            @php
                            $count += 1;
                            @endphp
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <div class="trigger" style="display: none">
                            <!-- <div class="trigger-button open"><img src="{{ asset('img/icons/dots-green.svg') }}" alt="all-categories" draggable="false"></div> -->
                            <div class="trigger-button open">
                                <svg viewBox="0 0 17 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.88 0.0639999C1.656 0.0639999 0.696 1.048 0.696 2.224C0.696 3.424 1.656 4.408 2.88 4.408C4.08 4.408 5.04 3.424 5.04 2.224C5.04 1.048 4.08 0.0639999 2.88 0.0639999ZM8.64563 0.0639999C7.42163 0.0639999 6.46163 1.048 6.46163 2.224C6.46163 3.424 7.42163 4.408 8.64563 4.408C9.84563 4.408 10.8056 3.424 10.8056 2.224C10.8056 1.048 9.84563 0.0639999 8.64563 0.0639999ZM14.4113 0.0639999C13.1873 0.0639999 12.2273 1.048 12.2273 2.224C12.2273 3.424 13.1873 4.408 14.4113 4.408C15.6113 4.408 16.5713 3.424 16.5713 2.224C16.5713 1.048 15.6113 0.0639999 14.4113 0.0639999Z" fill="#0AB1B1" />
                                </svg>
                            </div>
                            <div class="trigger-button close">
                                <span class="firago firago--sm firago--normal">დახურვა</span>
                                <img src="{{ asset('img/icons/x-white.svg') }}" alt="close" draggable="false">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            @endif
            <!-- შესაძლებლობების ფილტრები -->
            @if(isset($dropdownFilters) && $dropdownFilters && isset($pagename) && $pagename == 'opportunities')
            <div class="filters-container filters-container--opportunities">
                <div class="wrapper">
                    <div class="filters">
                        <div class="filter-wrapper types-wrapper has-popup active" data-popup-number="1">
                            <p class="firago firago--italic firago--sm firago--normal">შესაძლებლობის ტიპი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="შესაძლებლობის ტიპი">შესაძლებლობის ტიპი</div>
                                <div class="filter__dropdown">
                                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($regions as $region)
                                    <label class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $region->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $region->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @foreach ($oppTypes as $type)
                        <div class="filter-wrapper types-wrapper" data-type-id="{{$type->id}}">
                            <p class="firago firago--italic firago--sm firago--normal">შესაძლებლობის ქვეტიპი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="შესაძლებლობის ქვეტიპი">შესაძლებლობის ქვეტიპი</div>
                                <div class="filter__dropdown">
                                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($type->subtypes as $subtype)
                                    <label id="filter-by-subtypes" class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $subtype->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $subtype->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="filter-wrapper">
                            <p class="firago firago--italic firago--sm firago--normal">კატეგორია</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="კატეგორია">კატეგორია</div>
                                <div class="filter__dropdown">
                                    <label id="filter-by-categories-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($categories as $category)
                                    <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $category->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $category->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="filter-wrapper has-popup" data-popup-number="2">
                            <p class="firago firago--italic firago--sm firago--normal">ადგილმდებარეობა</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="ადგილმდებარეობა">ადგილმდებარეობა</div>
                                <div class="filter__dropdown">
                                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა რეგიონი</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($regions as $region)
                                    <label class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $region->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $region->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="filter-wrapper">
                            <p class="firago firago--italic firago--sm firago--normal">ასაკობრივი შუალედი</p>
                            <div class="filter filter--region filter-age filter-age-desktop">
                                <div class="filter__button" default="ასაკობრივი შუალედი">ასაკობრივი შუალედი</div>
                                <div class="filter__dropdown">
                                    <div class="firago firago--style-normal firago--dark-brown firago--sm text-center mb-3 mt-1 w-100">მიუთუთეთ ასაკობრივი შუალედი</div>
                                    <div class="range-slider range-slider-desktop" id=""></div>
                                    <div class="inputs">
                                        <input type="number" class='input-age min ignore' id="min-age" readonly disabled>
                                        <input type="number" class='input-age max ignore' id="max-age" readonly disabled>
                                    </div>
                                    <div class="checkboxes">
                                        <label class="checkbox-container checkbox-container--red">
                                            <input type="checkbox" id="no-min" class="ignore" checked>
                                            <span class="checkmark"></span>
                                            <div class="title">არ აქვს მინიმალური ასაკობრივი ზღვარი</div>
                                        </label>
                                        <label class="checkbox-container checkbox-container--red">
                                            <input type="checkbox" id="no-max" class="ignore" checked>
                                            <span class="checkmark"></span>
                                            <div class="title">არ აქვს მაქსიმალური ასაკობრივი ზღვარი</div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="filter-opportunities-button" class="button button--red filter-button">
                            <span class="d-inline-block">ძებნა</span>
                            <img src="{{ asset('img/icons/search-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- შესაძლებლობების ფილრების დასასრული -->

            <!-- ორგანიზაციების ფილრები -->
            @if(isset($dropdownFilters) && $dropdownFilters && isset($pagename) && $pagename == 'organizations')
            <div class="filters-container">
                <div class="wrapper">
                    <div class="filters">
                        {{-- ორგანიზაციის ტიპი --}}
                        <div class="filter-wrapper">
                            <p class="firago firago--italic firago--sm firago--normal">ორგანიზაციის ტიპი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="ორგანიზაციის ტიპი">ორგანიზაციის ტიპი</div>
                                <div class="filter__dropdown">
                                    <label id="filter-by-categories-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    <!-- @foreach ($companyStatuses as $status)
                                                <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                                                    <input type="checkbox" data-id="{{$status->id}}">
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$status->name}}</div>
                                                </label>
                                            @endforeach -->
                                    <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="local">
                                        <span class="checkmark"></span>
                                        <div class="title">ადგილობრივი</div>
                                    </label>
                                    <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="international">
                                        <span class="checkmark"></span>
                                        <div class="title">საერთაშორისო</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- საქმიანობის ტიპი --}}
                        <div class="filter-wrapper">
                            <p class="firago firago--italic firago--sm firago--normal">საქმიანობის ტიპი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="საქმიანობის ტიპი">საქმიანობის ტიპი</div>
                                <div class="filter__dropdown">
                                    <label id="filter-by-working-type-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach ($companyWorkingTypes as $type)
                                    <label id="filter-by-working-type" class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{$type->id}}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{$type->name}}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- ორგანიზაციის სტატუსი --}}
                        <div class="filter-wrapper has-popup" data-popup-number="3">
                            <p class="firago firago--italic firago--sm firago--normal">ორგანიზაციის სტატუსი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="ორგანიზაციის სტატუსი">ორგანიზაციის სტატუსი</div>
                            </div>
                        </div>
                        {{-- რეგისტრაციის ადგილი --}}
                        <div class="filter-wrapper has-popup" data-popup-number="4">
                            <p class="firago firago--italic firago--sm firago--normal">რეგისტრაციის ადგილი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="რეგისტრაციის ადგილი">რეგისტრაციის ადგილი</div>
                                <div class="filter__dropdown">
                                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა რეგიონი</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($regions as $region)
                                    <label class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $region->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $region->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- სამოქმედო არეალი --}}
                        <div class="filter-wrapper has-popup" data-popup-number="5">
                            <p class="firago firago--italic firago--sm firago--normal">სამოქმედო არეალი</p>
                            <div class="filter filter--region">
                                <div class="filter__button" default="სამოქმედო არეალი">სამოქმედო არეალი</div>
                                <div class="filter__dropdown">
                                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="title">ყველა რეგიონი</div>
                                    </label>
                                    <div class="separator separator-static"></div>
                                    @foreach($regions as $region)
                                    <label class="checkbox-container sub-item checkbox-container--red">
                                        <input type="checkbox" data-id="{{ $region->id }}">
                                        <span class="checkmark"></span>
                                        <div class="title">{{ $region->name }}</div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="filter-companies-button" class="button button--red filter-button">
                            <span class="d-inline-block">ძებნა</span>
                            <img src="{{ asset('img/icons/search-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ორგანიზაციების ფილრების დასასრული -->
        </div>
        @endif
    </div>
    <!-- ფილტრები და კატეგორიები დესკტოპზე-ს დასასრული -->

    <!-- ფილტრები და კატეგორიები მობილურზე -->
    @if((isset($has_filter) && $has_filter ) || (isset($dropdownFilters) && $dropdownFilters ))
    <div class="categorize mobile">
        <div class="add-and-search-oportunity ">
          <div class="wrapper d-flex align-items-center justify-content-between">
            <form action="/search" method="GET" class="search-form">
                <div class="search d-flex align-items-center">
                  <button class="search__submit mr-2"><img src="{{ asset('img/icons/search-normal.svg') }}" alt="go"></button>
                  <input name="text" required type="text" class="search__input" placeholder="მოძებნე შესაძლებლობა ან ორგანიზაცია">

                </div>
            </form>


            @if(!isset($pagename) || (isset($pagename) && $pagename != 'registration' && $pagename != 'login' ) )
            @if(isset($auth) && $auth && isset($guard) && ($guard == 'company' || $guard == 'web' && \Auth::user()->company == 1))
            <a class="header__button" href="{{ url('/' . app()->getLocale() . '/admin/opportunity/create') }}" target=_blank>
                <img src="{{ asset('img/icons/add.svg') }}" alt="add">
                <span>დაამატე შესაძლებლობა</span>
            </a>
            @elseif(isset($auth) && $auth && isset($guard) && $guard == 'web' && \Auth::user()->company == 0)
            
            @else
            <div class="header__button login-popup-trigger">
                <img src="{{ asset('img/icons/add.svg') }}" alt="add">
                <span>დაამატე შესაძლებლობა</span>
            </div>
            @endif
            @endif


          </div>
        </div>
        @if(!in_array(url()->current(), $notShowfilterOnPages))
        <div class="categories-container initial @if(isset($pagename) && $pagename=='opportunities'  && !isset($_GET['type'])) bordered @endif">
            <div class="wrapper">
                <div class="categories-inner-container">
                    <div class="categories active">
                        @if(isset($has_filter) && $has_filter && isset($categories))
                        <a href="{{ url('/' . app()->getLocale() . '/events?type=all') }}" data-type-id="all" class="category @if(isset($pagename) && $pagename=='opportunities' && !isset($_GET['type']) ) active @endif">
                            <h3 class="category__title">ყველა</h3>
                            <div class="category__amount">{{$total_count}}</div>
                        </a>
                        @foreach ($oppTypes as $type)
                        <a href="{{ url('/' . app()->getLocale() . '/events?type=' . $type->id) }}" data-type-id="{{$type->id}}" class="category">
                            <h3 class="category__title">{{$type->name}}</h3>
                            <div class="category__amount">{{$type->getOpportunityCount()}}</div>
                        </a>
                        @endforeach
                        @php
                        $count = 0;
                        @endphp
                        @if(isset($category) && isset($markActiveCategory) && $markActiveCategory)
                        <a style="display: none" title="{{ $category->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $category->id) }}" class="category active">
                            <h3 class="category__title">{{ $category->name }}</h3>
                            <div class="category__amount">{{ $category->getOpportunityCount() }}</div>
                        </a>
                        @php
                        $count += 1;
                        @endphp
                        @endif
                        @foreach($categories as $indx=>$cat)
                        @if(!isset($category) || (isset($category) && $cat->id != $category->id))
                        <a style="display: none" title="{{ $cat->name }}" href="{{ url('/' . app()->getLocale() . '/category/' . $cat->id) }}" class="category">
                            <h3 class="category__title">{{ $cat->name }}</h3>
                            <div class="category__amount">{{ $cat->getOpportunityCount() }}</div>
                        </a>
                        @php
                        $count += 1;
                        @endphp
                        @endif
                        @endforeach
                        @endif
                    </div>
                    <div class="trigger" style="display: none">
                        <!-- <div class="trigger-button open"><img src="{{ asset('img/icons/dots-green.svg') }}" alt="all-categories" draggable="false"></div> -->
                        <div class="trigger-button open">
                            <svg viewBox="0 0 17 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.88 0.0639999C1.656 0.0639999 0.696 1.048 0.696 2.224C0.696 3.424 1.656 4.408 2.88 4.408C4.08 4.408 5.04 3.424 5.04 2.224C5.04 1.048 4.08 0.0639999 2.88 0.0639999ZM8.64563 0.0639999C7.42163 0.0639999 6.46163 1.048 6.46163 2.224C6.46163 3.424 7.42163 4.408 8.64563 4.408C9.84563 4.408 10.8056 3.424 10.8056 2.224C10.8056 1.048 9.84563 0.0639999 8.64563 0.0639999ZM14.4113 0.0639999C13.1873 0.0639999 12.2273 1.048 12.2273 2.224C12.2273 3.424 13.1873 4.408 14.4113 4.408C15.6113 4.408 16.5713 3.424 16.5713 2.224C16.5713 1.048 15.6113 0.0639999 14.4113 0.0639999Z" fill="#0AB1B1" />
                            </svg>
                        </div>
                        <div class="trigger-button close">
                            <span class="firago firago--sm firago--normal">დახურვა</span>
                            <img src="{{ asset('img/icons/x-white.svg') }}" alt="close" draggable="false">
                        </div>
                    </div>
                    <form action="/search" method="GET" class="search-form">
                        <div class="search">
                            <input name="text" required type="text" class="search__input" placeholder="მოძებნე შესაძლებლობა ან ორგანიზაცია" value="{{ isset($term) ? $term : '' }}">
                            <button class="search__submit"><img src="{{ asset('img/icons/search-white.svg') }}" alt="go"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        <!-- შესაძლებლობის ფილტრები მობილურზე -->
        @if(isset($dropdownFilters) && $dropdownFilters && isset($pagename) && $pagename == 'opportunities')
        <div class="filters-container mobile expanded">
            <div class="wrapper">
                <!-- <div class="button button--red toggle-filters">
                    <span class="d-inline-block">დეტალური ძებნა</span>
                    <img src="{{ asset('img/icons/arrow-down-select-blue.svg') }}" alt="detailed-search" class="d-inline-block ml-2">
                </div> -->
                <div class="filters">
                    <div class="filter-wrapper types-wrapper has-popup active" data-popup-number="1">
                        <p class="firago firago--italic firago--sm firago--normal">შესაძლებლობის ტიპი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="შესაძლებლობის ტიპი">შესაძლებლობის ტიპი</div>
                            <div class="filter__dropdown">
                                <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($regions as $region)
                                <label class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $region->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @foreach ($oppTypes as $type)
                    <div class="filter-wrapper types-wrapper" data-type-id="{{$type->id}}">
                        <p class="firago firago--italic firago--sm firago--normal">შესაძლებლობის ქვეტიპი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="შესაძლებლობის ქვეტიპი">შესაძლებლობის ქვეტიპი</div>
                            <div class="filter__dropdown">
                                <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($type->subtypes as $subtype)
                                <label id="filter-by-subtypes" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $subtype->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $subtype->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="filter-wrapper">
                        <p class="firago firago--italic firago--sm firago--normal">კატეგორია</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="კატეგორია">კატეგორია</div>
                            <div class="filter__dropdown">
                                <label id="filter-by-categories-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($categories as $category)
                                <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $category->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $category->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="filter-wrapper has-popup" data-popup-number="2">
                        <p class="firago firago--italic firago--sm firago--normal">ადგილმდებარეობა</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="ადგილმდებარეობა">ადგილმდებარეობა</div>
                            <div class="filter__dropdown">
                                <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა რეგიონი</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($regions as $region)
                                <label class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $region->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="filter-wrapper">
                        <p class="firago firago--italic firago--sm firago--normal">ასაკობრივი შუალედი</p>
                        <div class="filter filter--region filter-age filter-age-mobile filter-age-mobile">
                            <div class="filter__button" default="ასაკობრივი შუალედი">ასაკობრივი შუალედი</div>
                            <div class="filter__dropdown">
                                <div class="firago firago--style-normal firago--dark-brown firago--sm text-center mb-3 mt-1 w-100">მიუთუთეთ ასაკობრივი შუალედი</div>
                                <div class="range-slider range-slider-mobile" id=""></div>
                                <div class="inputs">
                                    <input type="number" class='input-age min ignore' id="min-age" readonly disabled>
                                    <input type="number" class='input-age max ignore' id="max-age" readonly disabled>
                                </div>
                                <div class="checkboxes">
                                    <label class="checkbox-container checkbox-container--red">
                                        <input type="checkbox" class="ignore" id="no-min" checked>
                                        <span class="checkmark"></span>
                                        <div class="title">არ აქვს მინიმალური ასაკობრივი ზღვარი</div>
                                    </label>
                                    <label class="checkbox-container checkbox-container--red">
                                        <input type="checkbox" id="no-max" class="ignore" checked>
                                        <span class="checkmark"></span>
                                        <div class="title">არ აქვს მაქსიმალური ასაკობრივი ზღვარი</div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="filter-opportunities-button-mobile" class="button button--red filter-button">
                        <span class="d-inline-block">ძებნა</span>
                        <img src="{{ asset('img/icons/search-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- შესაძლებლობის ფილტრები მობილურზე-ს დასასრული-->

        <!-- ორგანიზაციების ფილტრები მობილურზე -->
        @if(isset($dropdownFilters) && $dropdownFilters && isset($pagename) && $pagename == 'organizations')
        <div class="filters-container mobile expanded">
            <div class="wrapper">
                <!-- <div class="button button--red toggle-filters">
                    <span class="d-inline-block">დეტალური ძებნა</span>
                    <img src="{{ asset('img/icons/arrow-down-select-blue.svg') }}" alt="detailed-search" class="d-inline-block ml-2">
                </div> -->
                <div class="filters">
                    {{-- ორგანიზაციის ტიპი --}}
                    <div class="filter-wrapper">
                        <p class="firago firago--italic firago--sm firago--normal">ორგანიზაციის ტიპი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="ორგანიზაციის ტიპი">ორგანიზაციის ტიპი</div>
                            <div class="filter__dropdown">
                                <label id="filter-by-categories-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                <!-- @foreach ($companyStatuses as $status)
                                                    <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                                                        <input type="checkbox" data-id="{{$status->id}}">
                                                        <span class="checkmark"></span>
                                                        <div class="title">{{$status->name}}</div>
                                                    </label>
                                                @endforeach -->
                                <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="local">
                                    <span class="checkmark"></span>
                                    <div class="title">ადგილობრივი</div>
                                </label>
                                <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="international">
                                    <span class="checkmark"></span>
                                    <div class="title">საერთაშორისო</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- საქმიანობის ტიპი --}}
                    <div class="filter-wrapper">
                        <p class="firago firago--italic firago--sm firago--normal">საქმიანობის ტიპი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="საქმიანობის ტიპი">საქმიანობის ტიპი</div>
                            <div class="filter__dropdown">
                                <label id="filter-by-working-type-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach ($companyWorkingTypes as $type)
                                <label id="filter-by-working-type" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{$type->id}}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{$type->name}}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- ორგანიზაციის სტატუსი --}}
                    <div class="filter-wrapper has-popup" data-popup-number="3">
                        <p class="firago firago--italic firago--sm firago--normal">ორგანიზაციის სტატუსი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="ორგანიზაციის სტატუსი">ორგანიზაციის სტატუსი</div>
                        </div>
                    </div>
                    {{-- რეგისტრაციის ადგილი --}}
                    <div class="filter-wrapper has-popup" data-popup-number="4">
                        <p class="firago firago--italic firago--sm firago--normal">რეგისტრაციის ადგილი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="რეგისტრაციის ადგილი">რეგისტრაციის ადგილი</div>
                            <div class="filter__dropdown">
                                <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა რეგიონი</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($regions as $region)
                                <label class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $region->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- სამოქმედო არეალი --}}
                    <div class="filter-wrapper has-popup" data-popup-number="5">
                        <p class="firago firago--italic firago--sm firago--normal">სამოქმედო არეალი</p>
                        <div class="filter filter--region">
                            <div class="filter__button" default="სამოქმედო არეალი">სამოქმედო არეალი</div>
                            <div class="filter__dropdown">
                                <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა რეგიონი</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach($regions as $region)
                                <label class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{ $region->id }}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{ $region->name }}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="filter-companies-button-mobile" class="button button--red filter-button">
                        <span class="d-inline-block">ძებნა</span>
                        <img src="{{ asset('img/icons/search-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- ორგანიზაციების ფილტრები მობილურზე-ს დასასრული -->
    </div>
    @endif
    <!-- ფილტრები და კატეგორიები მობილურზე-ს დასასრული -->

    <div class="popup filter-popup types-subtypes" data-popup-number="1">
        <div class="popup-content-wrapper">
            <div class="header-section right-dropdowns">
                <div class="firago firago--normal firago--sm">მოძებნეთ შესაძლებლობის ტიპი</div>
                <div class="form__group special filled">
                    <input type="text" class="form__input search-field">
                    <div class="form__group-arrow search-button">
                        <img src="{{ asset('img/icons/search-blue.svg') }}" alt="search" draggable="false">
                    </div>
                    <div class="dropdown-right municipalities">
                        <div class="dropdown-right__content">
                            @foreach ($oppTypes as $type)
                            @foreach ($type->subtypes as $subtype)
                            <label class="no-checkmark municipality" data-region-id="{{$type->id}}" data-municipality-id="{{$subtype->id}}">
                                <input name="area_municipalities[]" type="checkbox">
                                <img src="{{ asset('img/icons/pin-red.svg') }}" alt="checkmark" draggable="false">
                                <span class="first-name firago firago-sm">{{$subtype->name}}</span>
                                <span class="second-name firago firago-sm"></span>
                            </label>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="popup__close d-flex align-items-center">
                    <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
                    <img src="{{ asset('img/icons/x-lightblue.svg') }}" alt="close">
                </div>
            </div>

            <div class="selected-section">
                <div class="selected-values-wrapper">
                    @foreach ($oppTypes as $type)
                    <div class="selected-value" data-region-id="{{$type->id}}">
                        <div class="firago firago--normal firago--sm">{{$type->name}}:</div>
                        <div class="selected-municipalities popup-municipalities">
                            @foreach ($type->subtypes as $subtypes)
                            <div class="selected-municipality" data-municipality-id="{{$subtypes->id}}">
                                <div class="firago firago--normal firago--sm">{{$subtypes->name}}</div>
                                <img src="{{ asset('img/icons/x-white.svg') }}" class="remove-icon" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="select-section">
                <div class="filter__dropdown regions">
                    <label class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <div class="title">ყველა</div>
                    </label>
                    <div class="separator separator-static"></div>
                    @foreach ($oppTypes as $type)
                    <label class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="{{$type->id}}">
                        <span class="checkmark"></span>
                        <div class="title">{{$type->name}}</div>
                    </label>
                    @endforeach
                </div>
                <div class="municipalities-wrapper">
                    <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div>
                    <div class="municipality-sections-wrapper">
                        @foreach ($oppTypes as $type)
                        <div class="municipality-section" data-region-id="{{$type->id}}">
                            <div class="firago firago--normal firago--sm">{{$type->name}}</div>
                            <div class="filter__dropdown municipalities-dropdown">
                                <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">{{$type->name}}</div>
                                    <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" />
                                </label>
                                <label id="filter-by-subtypes" class="checkbox-container desktop checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="title">ყველა</div>
                                </label>
                                <div class="separator separator-static"></div>
                                @foreach ($type->subtypes as $subtype)
                                <label id="filter-by-subtypes" class="checkbox-container sub-item checkbox-container--red">
                                    <input type="checkbox" data-id="{{$subtype->id}}">
                                    <span class="checkmark"></span>
                                    <div class="title">{{$subtype->name}}</div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <!-- </div>
                </div> -->
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="buttons-section">
                <div class="button button--red button--gray cancel">
                    <span class="d-inline-block">გაუქმება</span>
                    <img src="{{ asset('img/icons/trash-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>

                <div class="button button--red save">
                    <span class="d-inline-block">შენახვა</span>
                    <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>

        </div>
    </div>

    <div class="popup filter-popup regions-municipalities" data-popup-number="2">
        <div class="popup-content-wrapper">
            <div class="header-section right-dropdowns">
                <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div>
                <div class="form__group special filled">
                    <input type="text" class="form__input search-field">
                    <div class="form__group-arrow search-button">
                        <img src="{{ asset('img/icons/search-blue.svg') }}" alt="search" draggable="false">
                    </div>
                    <div class="dropdown-right municipalities">
                        <div class="dropdown-right__content">
                            @foreach ($regions as $region)
                            @foreach ($region->municipalities as $municipality)
                            <label class="no-checkmark municipality" data-region-id="{{$region->id}}" data-municipality-id="{{$municipality->id}}">
                                <input name="area_municipalities[]" type="checkbox">
                                <img src="{{ asset('img/icons/pin-red.svg') }}" alt="checkmark" draggable="false">
                                <span class="first-name firago firago-sm">{{$municipality->name}}</span>
                                <span class="second-name firago firago-sm"></span>
                            </label>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="popup__close d-flex align-items-center">
                    <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
                    <img src="{{ asset('img/icons/x-lightblue.svg') }}" alt="close">
                </div>
            </div>

            <div class="selected-section">
                <div class="selected-values-wrapper">
                    @foreach ($regions as $region)
                    <div class="selected-value" data-region-id="{{$region->id}}">
                        <div class="firago firago--normal firago--sm">{{$region->name}}:</div>
                        <div class="selected-municipalities popup-municipalities">
                            @foreach ($region->municipalities as $municipality)
                            <div class="selected-municipality" data-municipality-id="{{$municipality->id}}">
                                <div class="firago firago--normal firago--sm">{{$municipality->name}}</div>
                                <img src="{{ asset('img/icons/x-white.svg') }}" class="remove-icon" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="select-section">
                <div class="filter__dropdown regions">
                    <label id="filter-by-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <div class="title">ყველა</div>
                    </label>
                    <div class="separator separator-static"></div>
                    @foreach ($regions as $region)
                    <label class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="{{$region->id}}">
                        <span class="checkmark"></span>
                        <div class="title">{{$region->name}}</div>
                    </label>
                    @endforeach
                </div>
                <div class="municipalities-wrapper">
                    <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div>
                    <div class="municipality-sections-wrapper">
                        @foreach ($regions as $region)
                        <div class="municipality-section" data-region-id="{{$region->id}}">
                            <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                            <div class="filter__dropdown municipalities-dropdown">
                                <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
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
            <!-- </div> -->

            <div class="buttons-section">
                <div class="button button--red button--gray cancel">
                    <span class="d-inline-block">გაუქმება</span>
                    <img src="{{ asset('img/icons/trash-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>

                <div class="button button--red save">
                    <span class="d-inline-block">შენახვა</span>
                    <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>

        </div>
    </div>

    <div class="popup filter-popup organization-type" data-popup-number="3">
        <div class="popup-content-wrapper">
            <div class="header-section right-dropdowns">
                <div class="popup__close d-flex align-items-center">
                    <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
                    <img src="{{ asset('img/icons/x-lightblue.svg') }}" alt="close">
                </div>
            </div>

            <div class="select-section">
                <div class="filter__dropdown">
                    <label id="filter-by-company-type-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <div class="title">ყველა სტატუსის მონიშვნა</div>
                    </label>
                    <div class="separator separator-static"></div>
                    @foreach ($companyStatuses as $status)
                    <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="{{$status->id}}">
                        <span class="checkmark"></span>
                        <div class="title">{{$status->name}}</div>
                    </label>
                    @endforeach

                    <!-- <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="local">
                        <span class="checkmark"></span>
                        <div class="title">ადგილობრივი</div>
                    </label>
                    <label id="filter-by-company-type" class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="international">
                        <span class="checkmark"></span>
                        <div class="title">საერთაშორისო</div>
                    </label> -->
                </div>
            </div>

            <div class="buttons-section">
                <div class="button button--red button--gray cancel">
                    <span class="d-inline-block">გაუქმება</span>
                    <img src="{{ asset('img/icons/trash-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>

                <div class="button button--red save">
                    <span class="d-inline-block">შენახვა</span>
                    <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>

        </div>
    </div>

    <div class="popup filter-popup regions-municipalities" data-popup-number="4">
        <div class="popup-content-wrapper">
            <div class="header-section right-dropdowns">
                <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div>
                <div class="form__group special filled">
                    <input type="text" class="form__input search-field">
                    <div class="form__group-arrow search-button">
                        <img src="{{ asset('img/icons/search-blue.svg') }}" alt="search" draggable="false">
                    </div>
                    <div class="dropdown-right municipalities">
                        <div class="dropdown-right__content">
                            @foreach ($regions as $region)
                            @foreach ($region->municipalities as $municipality)
                            <label class="no-checkmark municipality" data-region-id="{{$region->id}}" data-municipality-id="{{$municipality->id}}">
                                <input name="area_municipalities[]" type="checkbox">
                                <img src="{{ asset('img/icons/pin-red.svg') }}" alt="checkmark" draggable="false">
                                <span class="first-name firago firago-sm">{{$municipality->name}}</span>
                                <span class="second-name firago firago-sm"></span>
                            </label>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="popup__close d-flex align-items-center">
                    <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
                    <img src="{{ asset('img/icons/x-lightblue.svg') }}" alt="close">
                </div>
            </div>

            <div class="selected-section">
                <div class="selected-values-wrapper">
                    @foreach ($regions as $region)
                    <div class="selected-value" data-region-id="{{$region->id}}">
                        <div class="firago firago--normal firago--sm">{{$region->name}}:</div>
                        <div class="selected-municipalities popup-municipalities">
                            @foreach ($region->municipalities as $municipality)
                            <div class="selected-municipality" data-municipality-id="{{$municipality->id}}">
                                <div class="firago firago--normal firago--sm">{{$municipality->name}}</div>
                                <img src="{{ asset('img/icons/x-white.svg') }}" class="remove-icon" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="select-section">
                <div class="filter__dropdown regions">
                    <label id="filter-by-registration-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <div class="title">ყველა</div>
                    </label>
                    <div class="separator separator-static"></div>
                    @foreach ($regions as $region)
                    <label class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="{{$region->id}}">
                        <span class="checkmark"></span>
                        <div class="title">{{$region->name}}</div>
                    </label>
                    @endforeach
                </div>
                <div class="municipalities-wrapper">
                    <div class="firago firago--normal firago--sm">მოძებნეთ რეგისტრაციის ადგილი</div>
                    <div class="municipality-sections-wrapper">
                        @foreach ($regions as $region)
                        <div class="municipality-section" data-region-id="{{$region->id}}">
                            <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                            <div class="filter__dropdown municipalities-dropdown">
                                <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
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
                                <label id="filter-by-registration-municipalities" class="checkbox-container sub-item checkbox-container--red">
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
            <!-- </div> -->

            <div class="buttons-section">
                <div class="button button--red button--gray cancel">
                    <span class="d-inline-block">გაუქმება</span>
                    <img src="{{ asset('img/icons/trash-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>

                <div class="button button--red save">
                    <span class="d-inline-block">შენახვა</span>
                    <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>

        </div>
    </div>

    <div class="popup filter-popup regions-municipalities" data-popup-number="5">
        <div class="popup-content-wrapper">
            <div class="header-section right-dropdowns">
                <div class="firago firago--normal firago--sm">მოძებნეთ სამოქმედო არეალი</div>
                <div class="form__group special filled">
                    <input type="text" class="form__input search-field">
                    <div class="form__group-arrow search-button">
                        <img src="{{ asset('img/icons/search-blue.svg') }}" alt="search" draggable="false">
                    </div>
                    <div class="dropdown-right municipalities">
                        <div class="dropdown-right__content">
                            @foreach ($regions as $region)
                            @foreach ($region->municipalities as $municipality)
                            <label class="no-checkmark municipality" data-region-id="{{$region->id}}" data-municipality-id="{{$municipality->id}}">
                                <input name="area_municipalities[]" type="checkbox">
                                <img src="{{ asset('img/icons/pin-red.svg') }}" alt="checkmark" draggable="false">
                                <span class="first-name firago firago-sm">{{$municipality->name}}</span>
                                <span class="second-name firago firago-sm"></span>
                            </label>
                            @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="popup__close d-flex align-items-center">
                    <span class="firago firago--normal firago--smm mr-1">დახურვა</span>
                    <img src="{{ asset('img/icons/x-lightblue.svg') }}" alt="close">
                </div>
            </div>

            <div class="selected-section">
                <div class="selected-values-wrapper">
                    @foreach ($regions as $region)
                    <div class="selected-value" data-region-id="{{$region->id}}">
                        <div class="firago firago--normal firago--sm">{{$region->name}}:</div>
                        <div class="selected-municipalities popup-municipalities">
                            @foreach ($region->municipalities as $municipality)
                            <div class="selected-municipality" data-municipality-id="{{$municipality->id}}">
                                <div class="firago firago--normal firago--sm">{{$municipality->name}}</div>
                                <img src="{{ asset('img/icons/x-white.svg') }}" class="remove-icon" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="select-section">
                <div class="filter__dropdown regions">
                    <label id="filter-by-working-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                        <input type="checkbox">
                        <span class="checkmark"></span>
                        <div class="title">ყველა</div>
                    </label>
                    <div class="separator separator-static"></div>
                    @foreach ($regions as $region)
                    <label class="checkbox-container sub-item checkbox-container--red">
                        <input type="checkbox" data-id="{{$region->id}}">
                        <span class="checkmark"></span>
                        <div class="title">{{$region->name}}</div>
                    </label>
                    @endforeach
                </div>
                <div class="municipalities-wrapper">
                    <div class="firago firago--normal firago--sm">მოძებნეთ სამოქმედო არეალი</div>
                    <div class="municipality-sections-wrapper">
                        @foreach ($regions as $region)
                        <div class="municipality-section" data-region-id="{{$region->id}}">
                            <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                            <div class="filter__dropdown municipalities-dropdown">
                                <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                    <input type="checkbox">
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
                                <label id="filter-by-working-municipalities" class="checkbox-container sub-item checkbox-container--red">
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
            <!-- </div> -->

            <div class="buttons-section">
                <div class="button button--red button--gray cancel">
                    <span class="d-inline-block">გაუქმება</span>
                    <img src="{{ asset('img/icons/trash-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>

                <div class="button button--red save">
                    <span class="d-inline-block">შენახვა</span>
                    <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="registration" class="d-inline-block ml-2">
                </div>
            </div>

        </div>
    </div>

    <div class="popup popup-share">
        <div class="popup__content popup__content--sm popup__content--white">
            <div class="popup__close d-flex align-items-center">
                <span class="firago firago--normal firago--smm firago--dark mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-dark.svg') }}" alt="close">
            </div>
            <div class="firago firago--smm firago--blue mb-4">ლინკის გაზიარება</div>
            <div class="d-flex mb-5">
                <a href="https://www.facebook.com/dialog/share?app_id=189227409131004&href=" target="_blank" class="share-button share-button--facebook">
                    facebook
                </a>
                <a href="https://twitter.com/intent/tweet?url=" target="_blank" class="share-button share-button--twitter">
                    twitter
                </a>
            </div>
            <div class="firago firago--smm firago--blue mb-2 ml-2">ლინკი</div>
            <div class="d-flex share-link">
                <input type="text" class="share-link-container" id="input-to-copy" value="https://spectrum.chat/figma/help/keep-getting-figma-" readonly>
                <div class="button button--red copy-button active">კოპირება<img src="{{ asset('img/icons/copy-white.svg') }}" alt="copy" class="ml-3"></div>
                <div class="button button--red copied-button">დაკოპირებულია<img src="{{ asset('img/icons/check-white.svg') }}" alt="copy" class="ml-2"></div>
            </div>
        </div>
    </div>

    @if($errors->has('popup_email'))
    <div class="popup popup-error popup-active">
        <div class="popup__content popup__content--sm popup__content--white">
            <div class="popup__close d-flex align-items-center">
                <span class="firago firago--normal firago--smm firago--dark mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-dark.svg') }}" alt="close">
            </div>
            <div class="firago firago--smm firago--blue mb-4">დაფიქსირდა შეცდომა</div>
            <div class="firago firago--smm firago--blue mb-2">{{ trans($errors->first()) }}</div>
        </div>
    </div>
    @endif

    @if(isset($termsData))
    <div class="popup popup-terms">
        <div class="popup__content blue-layout-md">
            <div class="popup__close">
                <span class="firago firago--normal firago--smm firago--white mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-white.svg') }}" alt="close" draggable="false">
            </div>
            <div class="heading heading--fancy heading--fancy-white">{{ $termsData->terms_title }}</div>
            <div class="paragraphs">
                <p class="paragraph paragraph--lg mb-3">
                    {!! $termsData->terms_text !!}
                </p>
                <!--<p class="paragraph paragraph--lg mb-3">
                            ლორემ იპსუმ ავარდნილი შვილო ყრმობიდან ქექვით ოთხჯერ სნობები, წარუმატებლად დარბაზობა სათვალეები.
                            შემიყვარდით ნადებსა უდაბნო ეჭვებს გააწითლებდა დაგტირი ვახტანგი გამოსულების საბძელია, საფარიდან
                            მოწყენა გამობმულ. სწავლაა ვცადე მეტროპოლში, ვმოგზაურობდი დევისი ალფრედი შვილებსაც, კეთი
                        </p>
                        <p class="paragraph paragraph--lg mb-3">
                            ლორემ იპსუმ ავარდნილი შვილო ყრმობიდან ქექვით ოთხჯერ სნობები, წარუმატებლად დარბაზობა სათვალეები.
                            შემიყვარდით ნადებსა უდაბნო ეჭვებს გააწითლებდა დაგტირი ვახტანგი გამოსულების საბძელია, საფარიდან
                            მოწყენა გამობმულ. სწავლაა ვცადე მეტროპოლში, ვმოგზაურობდი დევისი ალფრედი შვილებსაც, კეთი
                        </p>-->
            </div>
        </div>
    </div>
    <div class="popup popup-privacy">
        <div class="popup__content blue-layout-md">
            <div class="popup__close">
                <span class="firago firago--normal firago--smm firago--white mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-white.svg') }}" alt="close" draggable="false">
            </div>
            <div class="heading heading--fancy heading--fancy-white">{{ $termsData->confidentiality_title }}</div>
            <div class="paragraphs">
                <p class="paragraph paragraph--lg mb-3">
                    {!! $termsData->confidentiality_text !!}
                </p>
                <!--<p class="paragraph paragraph--lg mb-3">
                            ლორემ იპსუმ ავარდნილი შვილო ყრმობიდან ქექვით ოთხჯერ სნობები, წარუმატებლად დარბაზობა სათვალეები.
                            შემიყვარდით ნადებსა უდაბნო ეჭვებს გააწითლებდა დაგტირი ვახტანგი გამოსულების საბძელია, საფარიდან
                            მოწყენა გამობმულ. სწავლაა ვცადე მეტროპოლში, ვმოგზაურობდი დევისი ალფრედი შვილებსაც, კეთი
                        </p>
                        <p class="paragraph paragraph--lg mb-3">
                            ლორემ იპსუმ ავარდნილი შვილო ყრმობიდან ქექვით ოთხჯერ სნობები, წარუმატებლად დარბაზობა სათვალეები.
                            შემიყვარდით ნადებსა უდაბნო ეჭვებს გააწითლებდა დაგტირი ვახტანგი გამოსულების საბძელია, საფარიდან
                            მოწყენა გამობმულ. სწავლაა ვცადე მეტროპოლში, ვმოგზაურობდი დევისი ალფრედი შვილებსაც, კეთი
                        </p>-->
            </div>
        </div>
    </div>
    @endif


    @if(!auth()->guard('company')->check() && !isset($noLoginForm) )
    <div class="popup popup-login">
        <div class="popup__content popup__content--login blue-layout-md">
            <div class="popup__close d-flex align-items-center justify-content-center">
                <!-- <span class="firago firago--normal firago--smm firago--white mr-1">დახურვა</span> -->
                <img src="{{ asset('img/icons/close-img-newblack.svg') }}" alt="close" draggable="false">
            </div>
            <div class="title-default">
                @if(!auth()->guard('web')->check())
                <div class="heading heading--md mb-4">იმისთვის რომ დაამატო შესაძლებლობა გაიარე ავტორიზაცია</div>
                @else
                <div class="heading heading--md mb-4">იმისთვის რომ დაამატო შესაძლებლობა გაიარე ავტორიზაცია როგორც ორგანიზაციამ</div>
                @endif
            </div>
            <!-- <div class="alternative-title">
                    <div class="heading heading--md mb-4">იმისთვის რომ გამოიწერო კატეგორია/ორგანიზაცია გაიარე ავტორიზაცია ან დარეგისტრირდი.</div>
                </div> -->
            <div class="subscribe-modal-title heading heading--md mb-4"></div>
            <div class="alternative-title heading heading--md mb-4">იმისთვის რომ გამოიწერო კატეგორია/ორგანიზაცია გაიარე ავტორიზაცია ან დარეგისტრირდი.</div>

            <div class="d-flex mb-5 authentication">
                <div class="login-container ">
                    <form action="/post-login" method="POST" class="form-login">
                        {{ csrf_field() }}
                        <div class="heading heading--fancy heading--fancy-white">ავტორიზაცია</div>
                        <div class="form__group">
                            <label for="popup-email" class="form__label">მეილი ან მობილურის ნომერი</label>
                            <input type="text" class="form__input" id="popup-email" name="email" autocomplete="off" value="@if(old('email')){{old('email')}}@endif" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">

                        </div>

                        <div class="form__group">
                            <label for="popup-password" class="form__label">პაროლი</label>
                            <input type="password" class="form__input" id="popup-password" name="password" pattern=".{8,}" autocomplete="off">

                            <div class="password-visible">
                                <img src="{{ asset('img/icons/eye-white-blue.svg') }}" alt="eye" draggable="false">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4 mt-1">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember" value="@if(old('remember')){{old('remember')}}@endif">
                                <span class="checkmark"></span>
                                <span class="firago firago--xs firago--normal firago--ls--xs">დამახსოვრება</span>
                            </label>
                            <a href="{{ url('/' . app()->getLocale() . '/password-reset/email-form') }}" class="firago  firago--xs no-underline firago--normal firago--ls--sm">დაგავიწყდა პაროლი?</a>
                        </div>
                        <!-- <div class="button button--red">ავტორიზაცია <img src="{{ asset('img/icons/exit.svg') }}" alt="login"></div> -->
                        <div class="button button--red d-flex align-items-center justify-content-center ">
                          ავტორიზაცია

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
                        <div class="go-back">
                            <img src="{{ asset('img/icons/back-white.svg') }}" alt="go back" draggable="false">
                        </div>
                        <div class="firago firago--md firago--normal mb-2 mt-2 line-height-1-3">არ ხარ დარეგისტრირებული? გაიარე რეგისტრაცია</div>
                        <a href="{{ url('/' . app()->getLocale() . '/org-registration') }}" class="button button--red">ორგანიზაციისთვის</a>
                        <a href="{{ url('/' . app()->getLocale() . '/user-registration') }}" class="button button--red">მომხმარებლისთვის</a>
                        <a href="{{ url('/' . app()->getLocale() . '/user-worker-registration') }}" class="button button--red"> ახალგაზრდული მუშაკისთვის</a>
                    </div>
                </div>
                <!-- <div class="d-flex-md justify-content-center">
                    <div class="link-fancy mt-4 open-registration-links">
                        <div class="title">არ გაქვს არსებული ექაუნთი?</div>
                        <div class="attribute">
                            <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    @endif

    @yield('content')
    <footer class="footer">
        <div class="partners">
            <div class="wrapper">
                <p class="firago firago--normal firago--sm mt-2 mb-2">ეს ვებსაიტი შექმნილია ევროკავშირის მხარდაჭერით. მის შინაარსზე სრულად პასუხისმგებელია კონტრაქტორი
                    და შესაძლოა, რომ იგი არ გამოხატავდეს ევროკავშირის შეხედულებებს</p>
                <img src="{{ asset('img/EU.png') }}" alt="EU">
                <img src="{{ asset('img/saveTheChildren.png') }}" alt="Save the Children">
                <img src="{{ asset('img/youthAgency.png') }}" alt="Youth Agency">

            </div>

        </div>
        <div class="wrapper">
            <div class="footer__content">
                <div class="terms">
                    <a class="privacy" href="#">Privacy Policy</a>
                    <a class="terms" href="#">Terms and conditions</a>
                </div>
                <div class="socials">
                    <a href="#" target=_blank>
                        youtube
                    </a>
                    @if(isset($insta_link) && $insta_link)
                    <a href="{{ $insta_link }}" target=_blank>
                        <!-- <img src="{{ asset('img/icons/instagram-mobile.svg') }}" alt="Instagram"> -->
                        instagram
                    </a>
                    @endif
                    @if(isset($fb_link) && $fb_link)
                    <a href="{{ $fb_link }}" target=_blank>
                        <!-- <img src="{{ asset('img/icons/facebook-mobile.svg') }}" alt="facebook"> -->
                        facebook
                    </a>
                    @endif
                    @if(isset($twitter_link) && $twitter_link)
                    <a href="{{ $twitter_link }}" target=_blank>
                        <!-- <img src="{{ asset('img/icons/twitter-mobile.svg') }}" alt="twitter"> -->
                        twitter
                    </a>
                    @endif
                </div>
                <form id="news-subscribe-form" action="{{ route('subscribe') }}" method="POST" hidden>
                    @csrf
                    @if(isset($auth) && $auth)
                    <input name="email" value="{{ $user->email }}">
                    @endif
                    <button type="submit">asdasd</button>
                </form>
                <a id="news-subscribe-btn" href="#" class="header__button margin-0" is-logged-in="{{ isset($auth) && $auth }}">
                    <span class="">სიახლეების გამოწერა</span>
                    <img src="{{ asset('img/icons/subscribe.svg') }}" alt="subscribe">
                </a>
            </div>
        </div>
        <div class="made-by-smartweb d-flex align-items-center justify-content-center">
          <p>Design by <a href="https://smartweb.ge/">Smartweb</a></p>
        </div>
    </footer>

    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>

    <script src="{{ asset('js/script.js?v=1.2') }}"></script>
    @if(isset($admin) && $admin)
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/cropper.js') }}"></script>
    <script src="{{ asset('js/admin/custom-script.js') }}"></script>
    <script src="{{ asset('js/admin/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/admin/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/22.0.0/classic/ckeditor.js"></script>
    @endif
    @yield('script')
</body>

</html>
