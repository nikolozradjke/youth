@foreach($opportunities as $opportunity)
<div class="table-row">
    <div class="photo entry">
        <div class="photo-holder" style="background-image: url({{asset('storage/' . $opportunity->getImagePath())}})">
        </div>
    </div>
    <div class="name entry">
        <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="name-text firago firago--smm text-blue">
            {{ $opportunity->name }}
        </a>
        <div class="opportunity-buttons">
            <a class="opportunity-button view" href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}">
                <p class="opportunity-button-text firago firago--normal firago--500 firago--sm">ნახვა</p>
            </a>
            <div class="separator"></div>
            <a class="opportunity-button edit" href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}">
                <p class="opportunity-button-text firago firago--normal firago--500 firago--sm">რედაქტირება</p>
            </a>
            <div class="separator"></div>
            <form method="POST" action="{{ url('/admin/opportunity/delete') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $opportunity->id }}" />
                <button type="submit" class="opportunity-button delete-button delete">
                    <p class="opportunity-button-text firago firago--normal firago--500 firago--sm">წაშლა</p>
                </button>
            </form>
        </div>
    </div>
    <div class="status entry">
        <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="status-text firago firago--normal firago--500 firago--sm">
            @if($opportunity->end_date->isPast())
                <div class="status-row">
                    <div class="status-circle finished"></div>
                    <p class="status-text">დასრულებული</p>
                </div>
            @else
                <div class="status-row">
                    <div class="status-circle ongoing"></div>
                    <p class="status-text">მიმდინარე</p>
                </div>
            @endif
        </a>
    </div>
    <div class="start-date entry">
        <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="firago firago--normal firago--500 firago--sm">
            {{ $opportunity->start_date->format('d-m-Y') }}
        </a>
    </div>
    <div class="end-date entry">
        <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="firago firago--normal firago--500 firago--sm">
            {{ $opportunity->end_date->format('d-m-Y') }}
        </a>
    </div>
</div>
@endforeach