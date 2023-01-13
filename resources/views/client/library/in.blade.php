@extends('layouts.master')

@section('content')

<section class="organization-main library-in">
    <div class="tabs-wrapper">
        <div class="wrapper">
            <div class="switch switch--organization no-ajax library-in-switch">
                <div class="switch__item align-items-center" data-tab-index="0">
                  <img src="{{ asset('img/poetry.png') }}" alt="">
                 <span> ლიტერატურის კატალოგი</span>
                </div>
                <div class="switch__item align-items-center" data-tab-index="1">
                  <img src="{{ asset('img/seo.png') }}" alt="">  
                  <span>კვლევების კატალოგი</span>
                </div>
                <div class="switch__item align-items-center" data-tab-index="2">
                  <img src="{{ asset('img/study.png') }}" alt="">
                 <span> სასწავლო კაბინეტი</span>
                </div>
            </div>
        </div>
        <div class="tabs-container active">
            <div class="tab organization-tab library-poetry-cards" data-tab-index="0">
                <div class="wrapper">
                  <div class="poetry-selects">
                    <ul class="poetry-selects-list">
                      @forelse($library_categories as $cat)
                      @if(count($cat->children) < 1)
                      <li class="poetry-li {{ $loop->first ? 'active' : '' }}" data-poetry-tab-index="{{ $cat->id }}">
                        <div class="d-flex justify-content-between align-items-center">
                          <span>{{ $cat->name }}</span>
                        </div>
                        <div class="results"></div>
                      </li>
                      @else
                      <li class="poetry-li" >

                        <div class="d-flex justify-content-between align-items-center">
                          <span>{{ $cat->name }}</span>
                          <svg class="arrow" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M7.93875 3.47014e-07L4.5 3.09171L1.06125 4.63887e-08L-4.17071e-08 0.954147L4.5 5L9 0.954147L7.93875 3.47014e-07Z" fill="#000"></path>
                          </svg>
                        </div>

                        <ul class="poetry-li-in">
                          @foreach($cat->children as $child_cat)
                          <li  data-poetry-tab-index="{{ $child_cat->id }}">
                            <span>{{ $child_cat->name }}</span>
                            <div class="results"></div>

                          </li>
                          @endforeach
                        </ul>

                      </li>
                      @endif
                      @empty
                      @endforelse
                    </ul>
                  </div>
                  <div class="poetry-tab-wrapper">
                    
                    <div class="poetry-tab tab cards-wrapper active">
                    @forelse($literatures as $item)
                      <div class="library-card-download">
                        <div class="lib-card-img">
                          <img src="{{ asset('img/icons/pdf.svg') }}" alt="file" class="pdf">
                          <a href="{{ $item->file }}" download class="align-items-center justify-content-center">
                            <img src="{{ asset('img/icons/pdf-download.svg') }}" alt="download">
                          </a>
                        </div>
                        <h5>{{ $item->name }}</h5>
                        <span>{{ date_format($item->created_at, 'Y.m.d') }}</span>
                        
                      </div>
                    @empty
                    @endforelse
                    </div>
                  </div>
                </div>
            </div>
            <div class="tab organization-tab library-catalog-cards" data-tab-index="1">
                <div class="wrapper">
                  <div class="cards-wrapper">
                    @forelse($researches as $research)
                    <div class="library-card-download">
                      <div class="lib-card-img">
                        <img src="{{ asset('img/icons/pdf.svg') }}" alt="" class="pdf">
                        <a href="{{ $research->file }}" download class="align-items-center justify-content-center">
                          <img src="{{ asset('img/icons/pdf-download.svg') }}" alt="">
                        </a>
                      </div>
                      <h5>{{ $research->name }}</h5>
                      <span>{{ date_format($research->created_at, 'Y.m.d') }}</span>
                      
                    </div>
                    @empty
                    @endforelse
                  </div>
                </div>
            </div>
            <div class="tab organization-tab  library-activity-cards" data-tab-index="2">
                <div class="wrapper">
                  <h4>აქტივობები</h4>
                  <div class="library-activity-list">
                    @forelse($activities as $activity)
                    <div class="library-activity-card">
                      <div class="head">
                       <img src="{{ asset($activity->image) }}" alt="">

                      </div>
                      <div class="body">
                        <p>{{ $activity->name }}</p>
                        <p>{!! $activity->description !!}</p>
                        <div class="details">
                          <h5 class="d-flex align-items-center">
                            <img class="mr-1" src="{{ asset('img/icons/activity-calendar.svg') }}" alt="">

                            აქტივობის ხანგრძლივობა</h5>
                          <span>{{ $activity->duration }}</span>
                        </div>
                        <div class="details">
                          <h5 class="d-flex align-items-center">
                            <img class="mr-1" src="{{ asset('img/icons/activity-profile-2user.svg') }}" alt="">
                            გუნდის ზომა</h5>
                          <span>{{ $activity->team_size }}</span>
                        </div>
                        <div class="activity-level">
                          <h5 class="d-flex align-items-center">
                          <img class="mr-1" src="{{ asset('img/icons/activity-trend-up.svg') }}" alt="">
                            აქტივობის დონე</h5>
                           

                            <div>{{ $activity->activity_level }} </div>
                        </div>
                        <div class="activity-level">
                          <h5 class="d-flex align-items-center">
                          <img class="mr-1" src="{{ asset('img/icons/activity-trend-up.svg') }}" alt="">  
                          აქტივობის ზომა</h5>
                          <div>{!! $activity->activity_size !!} </div>
                        </div>
                        <div class="resources">
                          <h5 class="d-flex align-items-center">
                          <img class="mr-1" src="{{ asset('img/icons/activity-document.svg') }}" alt=""> 
                            მატერიალები</h5>
                          <div class="resources-grid">
                            @forelse($activity->medias as $media)
                            <a href="{{ $media->media_url }}" download class="resource-card">
                              <div class="pdf-img">
                                <img src="{{ asset('img/icons/pdf.svg') }}" alt="">
                              </div>
                              <h6>მონაწილეობის შესახებ</h6>
                            </a>
                            @empty
                            @endforelse
                          </div>
                        </div>
                      </div>
                    </div>
                    @empty
                    @endforelse
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
@section('script')


<script>
    const getLiteraturesRoute = "{{ route('getLiteraturesByCat') }}";
</script>

<script src="{{ asset('js/library-in.js') }}"></script>

@endsection

