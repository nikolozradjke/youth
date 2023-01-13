@php
$url = url('/' . app()->getLocale() . '/event/' . $opportunity->id);
if(isset($category))
{
$url .= '?category-id=' . $category->id;
}


@endphp

    <div class="single-card">
        <!-- <div class="date-container">
            
            
        </div> -->
        <a class="card-image-wrapper" href="{!! route('opportunity', ['id' => $opportunity->id]) !!}">
            <div class="card-img" style="background-image: url({{ asset('/storage/' . $opportunity -> getImagePath()) }})"></div>
        </a>
        <div class="card-info">
            <a href="{!! route('opportunity', ['id' => $opportunity->id]) !!}">
                <div class="info-title" title="{{ $opportunity->name }}">
                        {{ $opportunity->name }}
                </div>
            </a>
            <div class="d-flex align-items-start justify-content-between card-info-add-block">
              @if(!is_null($opportunity->company_id))
              <a class="card-info-and-fav" href="{!! route('organization', ['id' => $opportunity->company->id]) !!}">
                  <div class="info-company">
                      <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->company->getImagePath()) }})"></div>
                      <div class="company-name" title="{{ $opportunity->company->name }}">
                          {{ $opportunity->company->name }}
                      </div>
                  </div>
              </a>
              @else
                  <div class="info-company">
                      <div class="company-img" style="background-image: url({{ asset('/storage/' . $opportunity->user->getImagePath()) }})"></div>
                      <div class="company-name" title="{{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name}}">
                          {{ $opportunity->user->first_name . ' ' . $opportunity->user->last_name}}
                      </div>
                  </div>
              @endif
              <div action="{{ $opportunity->favorite ? 'remove-favorite' : 'add-favorite' }}" class="url-button favorites-btn @if(empty($user)) disabled @elseif ($opportunity -> favorite) selected @endif" data-opportunity-id="{{ $opportunity->id }}">
                  @include('svg.heart-black')
              </div>

            </div>
            <div class="d-flex align-items-center justify-content-between opportunity-date-place">
              <div class="location-wrapper">
                  <div class="icon-pin">
                      @include('svg.location-marker')
                  </div>
                  <div class="info-location">
                      @if($opportunity->address)
                      {!! $opportunity->address !!}
                      @else
                      <div>ონლაინ ღონისძიება</div>
                      @endif
                  </div>
              </div>
              
                <div class="d-flex align-items-center justify-content-center info-date">{{ $opportunity->getDateString() }}</div>
              
            </div>
            
        </div>
    </div>