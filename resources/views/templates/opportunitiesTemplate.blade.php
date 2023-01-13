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
        <div class="switch opportunity-switch">
            <div class="switch__item active" data-sort="schedule_date">უახლესი</div>
            <div class="switch__item" data-sort="start_date">მოახლოებული</div>
        </div>
    </div>
    @if(count($opportunities))
    <div class="events">
        @foreach($opportunities as $opportunity)
            @include('templates.opportunity')
        @endforeach
    </div>
    @endif
    <p class="firago firago--blue firago--mdd not-found mb-3" style="display: none">შესაძებლობები არ მოიძებნა</p>
    <!-- <div class="link-fancy-container"> -->
    @if(isset($showAllOpportunities) && $showAllOpportunities)
        <div class="d-flex justify-content-center">
            <a href="{{ url('/' . app()->getLocale() . '/events') }}" class="link-fancy m-h-auto mb-8 see-all-opportunities">
                <div class="title">ნახე ყველა შესაძლებლობა</div>
                <!-- <div class="attribute">
                    <img src="{{ asset('img/icons/arrow-right-double-white.svg') }}" alt="join us">
                </div> -->
            </a>
        </div>
    @elseif($opportunityCount > $numberPerPage)
        <nav id="opportunity-pagination" class="pagination-container opportunity-pagination">
            @include('renders.paginationRender',[
                'opportunityCount' => $opportunityCount,
                'numberPerPage'    => $numberPerPage,
                'page'             => $page,
                'term'             => ""
            ]) 
        </nav>
    @endif
    <!-- </div> -->
</div>