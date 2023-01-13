@extends('layouts.master')

@section('content')

<div class="popup popup-resizable-pic popup-profile-pic">
    <div class="popup__content popup__content--white">
        <div class="popup-header">
            <div class="title firago firago--upp firago--style-normal firago--mdd">ატვირთე ფოტო</div>
            <div class="popup__close d-flex align-items-center">
                <span class="firago firago--style-normal firago--500 firago--smm firago--blue mr-1">დახურვა</span>
                <img src="{{ asset('img/icons/x-light-blue.svg') }}" alt="close">
            </div>
        </div>
        <div class="line mb-3"></div>
        <form action="{{ url('/' . app()->getLocale() . '/admin/update-company') }}" method="POST" enctype="multipart/form-data" class="profile-img-upload">
            @csrf
            @method('patch')
            <div class="uploader-container file-uploader">
                <label class="upload-button firago upload-tools active" for="file-input">
                    <div class="file-name mw-100">
                        <span class="lg">ატვირთვა</span>
                        <span class="md">+</span>
                    </div>
                    <input type="file" id="file-input" class='raw-file-input' style="display: none;" name="image" accept=".jpg, .png, .jpeg">
                </label>
                <div class="img-src upload-tools active">no file chosen</div>
                <!-- <div class="img-src--filled upload-tools">
                    <div class="file-name"></div>
                    <img src="{{ asset('img/icons/x-blue.svg') }}" alt="delete" class="delete-img">
                </div> -->
                <div class="rendered-raw-container">
                    <div class='profile-pic-raw-container rendered-raw-wrapper'>
                        <img src="" class="profile-pic-image" id="profile-pic-raw" />
                    </div>
                    <div class='btn btn--grey crop-button' id="crop-button">
                        <span>მოჭრა</span>
                    </div>
                </div>
                <div class="profile-pic-cropped-container cropped-container" id='profile-pic-cropped'>
                    <img class="cropped-image" src="" alt="">
                    <div class='btn btn--grey' id="enable-crop">
                        <span>რედაქტირება</span>
                    </div>
                    <input type="text" name="prof_image_base64" hidden id='org-profile-image'>
                </div>
            </div>
            <div class="popup-buttons mt-7">
                <button type="button" class="button button--gray button-blue img-cancel non-submit active">
                    <span class="firago firago--sm firago--style-normal firago--500">გაუქმება</span>
                </button>
                <button class="button non-submit save button--red button--blue img-save ml-2">
                    <span class="firago firago--sm firago--style-normal firago--500">შენახვა</span>
                </button>
            </div>
        </form>
    </div>
</div>
<div class="popup popup-delete-opp">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="title">
            <img src="{{ asset('img/icons/warning-grey.svg') }}" alt="warning">
            გსურთ შესაძლებლობის წაშლა?
        </div>
        <div class="buttons">
            <div class="btn btn--grey popup__close">
                გაუქმება
                <img src="{{ asset('img/icons/x-bordered-white.svg') }}" alt="cancel">
            </div>
            <form method="POST" action="{{ url('/admin/opportunity/delete') }}">
                @csrf
                <input type="hidden" name="id" value="" />
                <button type="submit" class="btn btn--red delete">
                    წაშლა
                    <img src="{{ asset('img/icons/bin-white.svg') }}" alt="delete">
                </button>
            </form>
        </div>
    </div>
</div>

<!-- BEGIN: Page Main-->
<div id="main" class="company-admin-panel-page">
    <div class="wrapper no-padding-md">
        <div class="cover-wrapper">
            <img id="cover-image" src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" original-src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" original-style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" class="cover" />
            <form id="cover-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company-cover') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cover_top_position" />
                <input type="hidden" name="cover_left_position" />
                <input type="file" id="cover-raw" name="cover_image" style="display: none;" accept=".jpg, .png, .jpeg">
                <div type="button" class="button button--gray add-cover non-submit active admin-profil-add-cover">
                    <!-- <span class="mr-2">ფოტოს ატვირთვა</span> -->
                    <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="upload cover">
                </div>
                <input type="text" id="cover-image-base64" name="cover_image_base64" hidden>
            </form>
            <div class="rendered-raw-container">
                <div class='profile-pic-raw-container rendered-raw-wrapper'>
                    <img src="" class="profile-pic-image" id="profile-pic-raw" />
                </div>
            </div>
            <div class="profile-pic-cropped-container cropped-container" id='profile-pic-cropped'>
                <img class="cropped-image" src="" alt="">
            </div>
            <div class="confirm-upload">
                <div class="cover-button cancel firago firago--sm firago--normal active">
                    გაუქმება
                </div>
                <div class="cover-button crop-button firago firago--sm firago--normal active">
                    მოჭრა
                </div>
                <div class="cover-button save firago firago--sm firago--normal">
                    შენახვა
                </div>
            </div>
        </div>
        <!-- <div class="cover-wrapper">
            <img id="cover-image" src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" original-src="@if($user->cover_image) {{asset($user->cover_image)}}  @else {{asset('/img/company-cover.png')}} @endif" style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" original-style="top: {{$user->cover_top_position}}; left: {{$user->cover_left_position}};" class="cover" />
            <form id="cover-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/update-company-cover') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cover_top_position" />
                <input type="hidden" name="cover_left_position" />
                <input type="file" id="cover" name="cover_image" style="display: none;" accept=".jpg, .png, .jpeg">
                <div type="button" class="button button--gray">
                    <span class="mr-2">ფოტოს ატვირთვა</span>
                    <img src="{{ asset('img/icons/camera.svg') }}" alt="upload cover">
                </div>
            </form>
            <div class="confirm-upload">
                <div class="cover-button cancel firago firago--sm firago--normal">
                    გაუქმება
                </div>
                <div class="cover-button save firago firago--sm firago--normal">
                    შენახვა
                </div>
            </div>
            <div class="drag-wrapper">
                <img src="{{ asset('img/icons/drag.svg') }}" alt="drag">
                <span class="firago firago--sm firago--500 ml-2">Drag to reposition</span>
            </div>
        </div> -->
    </div>
    <div class="wrapper no-padding-md">
        <div class="company-info">
            <div class="section">
                <div class="profile-pic">
                    <div class="pic-container">
                        <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="profile-picture">
                    </div>
                    <div class="profile-pic-upload cropper-popup-trigger">
                        <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="img upload">
                        <div class="firago firago--xs firago--normal">ატვირთე ფოტო</div>
                    </div>
                </div>
                <a href="{{url('/' . app()->getLocale() . '/admin/profile')}}" class="company-name firago--upp firago--mdd text-blue firago--bold">{{$user->name}}</a>
            </div>
           
            <div class="org-profile-action-btns">
              <a href="{{url('/' . app()->getLocale() . '/admin/profile')}}" class="button button--white mb-2">
                  <img src="{{ asset('img/icons/admin-panel-edit-2.svg') }}" alt="update profile">
                  <span class="ml-1">პროფილის რედაქტირება</span>
              </a>
              <a href="{{url('/' . app()->getLocale() . '/admin/opportunity/create')}}" class="button button--red justify-content-center">
                  <img src="{{ asset('img/icons/admin-panel-add-square.svg') }}" alt="add opportunity">
                  <span class="ml-1">შექმენი შესაძლებლობა</span>
              </a>
            </div>
        </div>
      
    </div>
    <div class="wrapper">
        <div class="row">
            <div class="col s12">
                <div class="container">

                    <!-- Content Area Starts -->
                    <div class="content-area">
                        <div class="app-wrapper">
                            <div class="tools">
                                <!-- <a href="{{url('/' . app()->getLocale() . '/admin/opportunity/create')}}" class="button button--red">
                                    <span class="mr-2">შექმენი შესაძლებლობა</span>
                                    <img src="{{ asset('img/icons/plus-white.svg') }}" alt="add opportunity">
                                </a> -->
                                <form action="{{ url('/' . app()->getLocale() . '/admin/opportunities/search/') }}" method="GET" class="datatable-search">
                                    <input name="term" type="text" placeholder="მოძებნე შესაძლებლობა" value="{{ old("term", request()->input("term")) }}" class="app-filter text-blue firago--sm" id="global_filter">
                                    <button type="submit" class="search-button">
                                        <img src="{{ asset('img/icons/search-white.svg') }}" alt="search opportunitites">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
      <div class="section org-profile-projects-stats  d-flex align-items-center mb-5 flex-wrap">
          <div class="ongoing-wrapper d-flex align-items-center mr-3">
              <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები </p>
              <p class="count firago firago--normal firago--md firago--500 text-blue"> ({{$ongoingOpportunitiesCount}})</p>
          </div>
          <div class="finished-wrapper  d-flex align-items-center">
              <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები </p>
              <p class="count firago firago--normal firago--md firago--500 text-blue"> ({{$finishedOpportunitiesCount}})</p>
          </div>
          <div class="line"></div>
      </div>
    </div>
    <div class="opportunities-table wrapper">
        <div class="table-head">
            <div class="table-row">
                <div class="photo">ფოტო</div>
                <div class="name">სახელი</div>
                <div class="status">სტატუსი</div>
                <div class="start-date">დაწყების თარიღი</div>
                <div class="end-date">დასრულების თარიღი</div>
                <div class="end-date">...</div>
            </div>
        </div>
        <div class="table-body">
            @foreach($opportunities as $opportunity)
            <div class="table-row">
                <div class="photo entry">
                  <a href="{{ url('/event/' . $opportunity->id) }}">
                    <div class="photo-holder @if($opportunity->end_date->isPast()) finished @endif" style="background-image: url({{asset('storage/' . $opportunity->getImagePath())}})">
                      <span>ნახვა</span>
                    </div>
                  </a>
                </div>
                <div class="name entry">
                    <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="name-text">
                        {{ $opportunity->name }}
                    </a>
                    
                </div>
                <div class="status entry">
                    <span class="entry-title-mob">სტატუსი</span>
                    <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="status-text firago firago--normal firago--500 firago--sm">
                        <div class="status-row align-items-center">
                            @if($opportunity->is_draft)
                            <div class="status-circle unpublished"></div>
                            <p class="status-text">სამუშაო ვერსია</p>
                            @elseif(!$opportunity->schedule_date->isPast())
                            <div class="status-circle unpublished"></div>
                            <p class="status-text">გამოსაქვეყნებელი</p>
                            @elseif($opportunity->end_date->isPast())
                            <div class="status-circle finished"></div>
                            <p class="status-text">დასრულებული</p>
                            @else
                            <div class="status-circle ongoing"></div>
                            <p class="status-text">მიმდინარე</p>
                            @endif
                        </div>
                    </a>
                </div>
                <div class="start-date entry">
                    <span class="entry-title-mob">დაწყების თარიღი</span>

                    <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="firago firago--normal firago--500 firago--sm">
                        {{ $opportunity->start_date->format('d-m-Y') }}
                    </a>
                </div>
                <div class="end-date entry">
                    <span class="entry-title-mob">დასრულების თარიღი</span>

                    <a href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}" class="firago firago--normal firago--500 firago--sm">
                        {{ $opportunity->end_date->format('d-m-Y') }}
                    </a>
                </div>
                <div class="actions entry">
                    <div class="opportunity-buttons">
                        <!-- <a class="opportunity-button view" href="{{ url('/event/' . $opportunity->id) }}">
                            <p class="opportunity-button-text firago firago--normal firago--500 firago--sm">ნახვა</p>
                        </a> -->
                        <!-- <div class="separator"></div> -->
                        <a class="opportunity-button edit  d-flex align-items-center mb-1" href="{{ url('/admin/opportunity/edit/' . $opportunity->id) }}">
                            <img src="{{ asset('img/icons/admin-panel-edit-block.svg') }}" alt="edit">
                            <p class="opportunity-button-text firago firago--normal firago--500 firago--sm ml-1">რედაქტირება</p>
                        </a>
                        <div class="separator"></div>
                        <div class="opportunity-button delete-button delete d-flex align-items-center" data-opp-id='{{ $opportunity->id }}'>
                            <img src="{{ asset('img/icons/admin-panel-trush-square.svg') }}" alt="delete">

                            <p class="opportunity-button-text firago firago--normal firago--500 firago--sm ml-1">წაშლა</p>
                        </div>
                        <!-- <form method="POST" action="{{ url('/admin/opportunity/delete') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $opportunity->id }}" />
                            <button type="submit" class="opportunity-button delete-button delete">
                                <p class="opportunity-button-text firago firago--normal firago--500 firago--sm">წაშლა</p>
                            </button>
                        </form> -->
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="wrapper">
        <div class="pagination-wrapper">
            {{$opportunities->links()}}
        </div>
    </div>
    <!-- Content Area Ends -->

    <div class="wrapper">
        <div class="content-overlay"></div>
    </div>

</div>
<!-- END: Page Main-->

@endsection