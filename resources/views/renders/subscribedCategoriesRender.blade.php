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