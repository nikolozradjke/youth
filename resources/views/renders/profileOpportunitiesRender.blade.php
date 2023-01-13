@foreach($opportunities as $opportunity)
    <div class="event event--light">
        <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__img">
            <img src="{{ url('/storage/' . $opportunity->getImagePath()) }}" alt="eventimg">
        </a>
        <div class="event__bottom">
            <div class="event__date">{!!$opportunity->getDateString()!!}</div>
            <div class="event__desc">
                <div class="top">
                    <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__title">
                        <h3>{{$opportunity->name}}</h3>
                    </a>
                    <a href="{{ url('/' . app()->getLocale() . '/event/' . $opportunity->id) }}" class="event__host">
                        <h4>{{$opportunity->company->name}}</h4>
                    </a>
                </div>
            </div>
        </div>
    </div>  
@endforeach