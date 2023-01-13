@foreach($searchCompanies as $searchedCompany)
    <div class="subscibed-organization bordered-container">
        <div class="organization-img">
            <img src="{{ asset('/storage/' . $searchedCompany->getImagePath()) }}" alt="organization img">
        </div>
        <div class="organization-title">
            <a href="{{ url('/' . app()->getLocale() . '/company/' . $searchedCompany->id) }}">
                <h4 class="heading heading--md mb-1 text-red">{{$searchedCompany->name}}</h4>
            </a>
            <div class="subs-amount">{{($searchedCompany->users->count()+$searchedCompany->subscriberCompanies->count())}} გამომწერი</div>
        </div>
    </div>
@endforeach