@foreach($companies as $company)
<div class="subscibed-organization bordered-container" href="{{ url('/' . app()->getLocale() . '/organization/' . $company->id) }}">
    <div class="organization-img">
        <img src="{{ asset('/storage/' . $company->getImagePath()) }}" alt="organization img">
    </div>
    <div class="organization-title">
        <h4 class="heading heading--md mb-1 text-red">{{ $company->name }}</h4>
        <div class="subs-amount">{{ $company->users_count + $company->subscriberCompanies_count }} გამომწერი</div>
    </div>
    <div class="delete subs-delete" data-company-id="{{ $company->id }}">
        <div class="subs-delete__text firago firago--normal firago--sm">გამოწერის გაუქმება</div>
        <div class="subs-delete__img"><img src="{{ asset('img/icons/unsubscribe-white.svg') }}" alt="unsubscribe"></div>
    </div>
</div>
@endforeach