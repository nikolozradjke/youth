@extends('layouts.master')

@section('content')

<div class="wrapper search-main">
    <div class="heading heading--md heading--blue mb-2">ძიების შედეგი “<span>{{ $term }}</span>” ზე</div>
    <div class="heading heading--sm heading--fade-blue mb-4">ნაპოვნია <span>{{ $opportunityCount }}</span> შესაძლებლობა და <span>{{$companyCount}}</span> ორგანიზაცია</div>
    <div class="switch search-switch">
        <div class="switch__item switch-organization @if(!($companyCount && !$opportunityCount)) active @endif">შესაძლებლობები</div>
        <div class="switch__item switch-events @if($companyCount && !$opportunityCount) active @endif">ორგანიზაციები</div>
    </div>
    <div>
        <div class="search-tab search-tab--events @if(!($companyCount && !$opportunityCount)) active @endif">
            <div class="heading heading--fancy">შესაძლებლობები</div>
            <div class="events">
                @foreach($opportunities as $opportunity)
                    @include('templates.opportunity')
                @endforeach
            </div>
            @if($opportunityCount > $numberPerPage)
                <nav class="pagination-container opportunity-pagination">
                    <ul class="pagination" data-search-term="{{ $term }}">
                        <li class="page-item prev @if($page == 1) disabled @endif">
                            <p class="page-link" data-new-page="{{ $page-1 }}" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-white.svg') }}" alt="previous"></p>
                        </li>
                        @php
                        $numPages = intval($opportunityCount/$numberPerPage);
                        if($opportunityCount%$numberPerPage > 0) {
                        $numPages += 1;
                        }
                        @endphp
                        @for($i = 1; $i <= $numPages; $i++) <li class="page-item @if($i == $page) active @endif @if($i == $numPages) last @endif">
                            <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                            </li>
                            @endfor
                            <li class="page-item next @if($page == $numPages) disabled @endif">
                                <p class="page-link" data-new-page="{{ $page+1 }}"><img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="previous"></p>
                            </li>
                    </ul>
                </nav>
            @endif
        </div>
        <div class="search-tab search-tab--organizations @if($companyCount && !$opportunityCount) active @endif">
            <div class="heading heading--fancy">ორგანიზაციები</div>
            @if(count($searchCompanies))
                <div class="blue-container search-company-wrapper">
                    @foreach($searchCompanies as $searchedCompany)
                        <div class="subscibed-organization bordered-container">
                            <div class="organization-img">
                                <img src="{{ asset('/storage/' . $searchedCompany->getImagePath()) }}" alt="organization img">
                            </div>
                            <div class="organization-title">
                                <a href="{{ url('/' . app()->getLocale() . '/organization/' . $searchedCompany->id) }}">
                                    <h4 class="heading heading--md mb-1 text-red">{{$searchedCompany->name}}</h4>
                                </a>
                                <div class="subs-amount">{{($searchedCompany->users->count()+$searchedCompany->subscriberCompanies->count())}} გამომწერი</div>
                            </div>
                        </div>
                    @endforeach
                    @if($companyCount > $companyNumberPerPage)
                        <nav class="pagination-container company-pagination">
                            <ul class="pagination" data-search-term="{{ $term }}">
                                <li class="page-item prev @if($page == 1) disabled @endif">
                                    <p class="page-link" data-new-page="{{ $page-1 }}" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-white.svg') }}" alt="previous"></p>
                                </li>
                                @php
                                    $companyNumPages = intval($companyCount/$companyNumberPerPage);
                                    if($companyCount%$companyNumberPerPage > 0) {
                                        $companyNumPages += 1;
                                    }
                                @endphp
                                @for($j = 1; $j <= $companyNumPages; $j++)
                                    <li class="page-item @if($j == $page) active @endif @if($j == $companyNumPages) last @endif">
                                        <p class="page-link" data-new-page="{{ $j }}">{{ $j }}</p>
                                    </li>
                                @endfor
                                <li class="page-item next @if($page == $companyNumPages) disabled @endif">
                                    <p class="page-link" data-new-page="{{ $page+1 }}"><img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="previous"></p>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

@endsection