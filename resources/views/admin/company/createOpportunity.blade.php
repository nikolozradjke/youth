@extends('layouts.master')

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        {{dd($errors->all())}}
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

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
<!-- <div class="popup popup-resizable-pic popup-profile-pic">
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
            <label class="upload-button firago upload-tools" for="profile-pic">
                <div class="file-name mw-100">
                    <span class="lg">ატვირთვა</span>
                    <span class="md">+</span>
                </div>
                <input type="file" id="profile-pic" style="display: none;" name="image" accept=".jpg, .png, .jpeg">
            </label>
            <div class="img-src upload-tools">no file chosen</div>
            <div class="img-src--filled upload-tools">
                <div class="file-name"></div>
                <img src="{{ asset('img/icons/x-blue.svg') }}" alt="delete" class="delete-img">
            </div>
            <img src="" class="profile-pic-image" id="profile-pic-image" />
        </div>
        <div class="size-slider mt-5">
            <img src="{{ asset('img/icons/zoom-out.svg') }}" class="zoom-button zoom-out mr-3" />

            <div class="progress-line">
                <div class="handle"></div>
            </div>

            <img src="{{ asset('img/icons/zoom-in.svg') }}" class="zoom-button zoom-in ml-3" />
        </div>
        <div class="popup-buttons mt-7">
            <button type="button" class="button button--gray button-blue img-cancel non-submit">
                <span class="firago firago--sm firago--style-normal firago--500">გაუქმება</span>
            </button>
            <button type="submit" class="button button--red button--blue img-save ml-2">
                <span class="firago firago--sm firago--style-normal firago--500">მიმაგრება</span>
            </button>
        </div>
    </form>
</div>
</div> -->

<div class="popup popup-resizable-pic popup-opportunity-pic">
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
                <label class="upload-button firago upload-tools" for="opportunity-pic">
                    <div class="file-name mw-100">
                        <span class="lg">ატვირთვა</span>
                        <span class="md">+</span>
                    </div>
                    <input type="file" id="opportunity-pic" style="display: none;" name="image" accept=".jpg, .png, .jpeg">
                </label>
                <div class="img-src upload-tools">no file chosen</div>
                <div class="img-src--filled upload-tools">
                    <div class="file-name"></div>
                    <img src="{{ asset('img/icons/x-blue.svg') }}" alt="delete" class="delete-img">
                </div>
                <img src="" class="profile-pic-image" id="opportunity-pic-image" />
            </div>
            <div class="size-slider mt-5">
                <img src="{{ asset('img/icons/zoom-out.svg') }}" class="zoom-button zoom-out mr-3" />

                <div class="progress-line">
                    <div class="handle"></div>
                </div>

                <img src="{{ asset('img/icons/zoom-in.svg') }}" class="zoom-button zoom-in ml-3" />
            </div>
            <div class="popup-buttons mt-7">
                <button type="button" class="button button--gray button-blue img-cancel non-submit">
                    <span class="firago firago--sm firago--style-normal firago--500">გაუქმება</span>
                </button>
                <button type="submit" class="button button--red button--blue img-save ml-2">
                    <span class="firago firago--sm firago--style-normal firago--500">მიმაგრება</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="popup popup-delete-faq">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="title">
            <img src="{{ asset('img/icons/warning-grey.svg') }}" alt="warning">
            გსურთ კითხვის წაშლა?
        </div>
        <div class="buttons">
            <div class="btn btn--grey popup__close">
                გაუქმება
                <img src="{{ asset('img/icons/x-bordered-white.svg') }}" alt="cancel">
            </div>
            <div class="btn btn--red delete">
                წაშლა
                <img src="{{ asset('img/icons/bin-white.svg') }}" alt="delete">
            </div>
        </div>
    </div>
</div>

<div class="popup popup-delete-confirm">
    <div class="popup__content popup__content--sm popup__content--white">
        <div class="title">
            <img src="{{ asset('img/icons/warning-grey.svg') }}" alt="warning">
            <span class="title-text">გსურთ წაშლა?</span>
        </div>
        <div class="buttons">
            <div class="btn btn--grey popup__close">
                გაუქმება
                <img src="{{ asset('img/icons/x-bordered-white.svg') }}" alt="cancel">
            </div>
            <div class="btn btn--red delete">
                წაშლა
                <img src="{{ asset('img/icons/bin-white.svg') }}" alt="delete">
            </div>
        </div>
    </div>
</div>

<!-- BEGIN: Page Main-->
<div id="main" class="opportunity-page">
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
                    <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="img upload">

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
    </div>
    <div class="wrapper no-padding-md">
        <!-- <div class="company-info">
        <div class="section">
            <div class="profile-pic">
                <div class="pic-container">
                    <img src="{{ asset('/storage/' . $user->getImagePath()) }}" alt="profile-picture">
                </div>
                <div class="profile-pic-upload">
                    <img src="{{ asset('img/icons/camera.svg') }}" alt="img upload">
                    <div class="firago firago--xs firago--normal">ატვირთე ფოტო</div>
                </div>
            </div>
            <p class="company-name firago--upp firago--mdd text-blue firago--bold">{{$user->name}}</p>
        </div>
        <div class="section">
            <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები</p>
            <p class="count firago firago--normal firago--md firago--500 text-blue">{{$ongoingOpportunitiesCount}}</p>
            <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები</p>
            <p class="count firago firago--normal firago--md firago--500 text-blue">{{$finishedOpportunitiesCount}}</p>
        </div>
        <a href="{{url('/' . app()->getLocale() . '/admin/profile')}}" class="button button--white">
            <span class="mr-2">პროფილის რედაქტირება</span>
            <img src="{{ asset('img/icons/user-red.svg') }}" alt="update profile">
        </a>
    </div> -->
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
            <!-- <div class="section">
                <div class="ongoing-wrapper">
                    <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები</p>
                    <p class="count firago firago--normal firago--md firago--500 text-blue">{{$ongoingOpportunitiesCount}}</p>
                </div>
                <div class="finished-wrapper">
                    <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები</p>
                    <p class="count firago firago--normal firago--md firago--500 text-blue">{{$finishedOpportunitiesCount}}</p>
                </div>
            </div> -->
            <div class="org-profile-action-btns">
              <a href="{{url('/' . app()->getLocale() . '/admin/opportunities')}}" class="button button--red">
                  <img src="{{ asset('img/icons/opportunities-white.svg') }}" alt="update profile">
                  <span class="ml-1">შესაძლებლობების სია</span>
              </a>
            </div>
        </div>
    </div>

    <div class="wrapper">
      <div class="section org-profile-projects-stats  d-flex align-items-center mt-8 mb-5 flex-wrap">
          <div class="ongoing-wrapper  d-flex align-items-center mr-3">
              <p class="ongoing firago firago--normal firago--md firago--500 text-blue">მიმდინარე შესაძლებლობები</p>
              <p class="count firago firago--normal firago--md firago--500 text-blue">({{$ongoingOpportunitiesCount}})</p>
          </div>
          <div class="finished-wrapper d-flex align-items-center">
              <p class="finished firago firago--normal firago--md firago--500 text-blue">დასრულებული შესაძლებლობები</p>
              <p class="count firago firago--normal firago--md firago--500 text-blue">({{$finishedOpportunitiesCount}})</p>
          </div>
      </div>
    </div>

    <div class="mobile-navigation-opp-admin">
        <div class="sidebar sidebar-with-progress-bar mobile">
            <div class="progress-bar">
                <div class="circle active firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="1">1</div>
                <div class="line" data-tab-index="2"></div>
                <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="2">2</div>
                <div class="line" data-tab-index="3"></div>
                <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="3">3</div>
                <div class="line" data-tab-index="4"></div>
                <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="4">4</div>
                <div class="line" data-tab-index="5"></div>
                <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="5">5</div>
            </div>
        </div>

        <div class="menu-mobile-admin">
            <div class="menu-mobile-item current">შესაძლებლობის შესახებ</div>
            <!-- <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" alt="arrow" class="icon"> -->
            <div class="menu-mobile-dropdown">
                <div class="menu-mobile-item active" data-tab-index="1">
                    შესაძლებლობის შესახებ
                </div>
                <div class="menu-mobile-item" data-tab-index="2">
                    ინფორმაცია
                </div>
                <div class="menu-mobile-item" data-tab-index="3">
                    ადაპტირებულობა
                </div>
                <div class="menu-mobile-item" data-tab-index="4">
                    მედია და კითხვა-პასუხი
                </div>
                <div class="menu-mobile-item" data-tab-index="5">
                    კონტაქტი
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <div class="row">
            <div class="col s12">
                <div class="container">

                    <!-- Content Area Starts -->
                    <div class="content-area">



                        <div class="app-wrapper opportunity-wrapper">

                            <form id="main-form" class="tab-form" method="POST" action="{{ url('/' . app()->getLocale() . '/admin/opportunity/store') }}" enctype="multipart/form-data">

                                <input type="hidden" name="opportunity_id" value="{{ $newOpportunityID }}">
                                <!-- <div class="form-group-wrapper event-title-wrapper mt-5 mb-4">
                                    <div class="left">
                                        <label for="name_ka" class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark add-required--black">შესაძლებლობის სახელი
                                        </label>
                                        <div class="form__group form__group--full form__group--admin mt-1">
                                            <input type="text" class="form__input opportunity-title pick-for-validation" id="name_ka" name="name_ka" value="{{old('name_ka')}}" pattern="[a-zA-Z0-9]+|[ა-ჰ]">
                                            <div class="form__tooltip form__tooltip--error">
                                                <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                <div>აუცილებელი ველი</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="draft-buttons">
                                        <div class="btn btn--white btn--border-red draft-submit">
                                            <span>შენახვა</span>

                                            <img src="{{ asset('img/icons/document-red.svg') }}" alt="save" draggable="false">
                                        </div>
                                        <div class="btn btn--grey submit-for-view">
                                            <span>ნახვა</span>
                                            <img src="{{ asset('img/icons/eye-white.svg') }}" alt="view" draggable="false">
                                        </div>
                                        <script>
                                            $('.draft-submit').on('click', function() {
                                                $(this).closest('form').attr('target', "_self");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/storeDraft') }}");
                                                $('.tab-form').trigger('submit');
                                            })

                                            $('.submit-for-view').on('click', function() {
                                                $(this).closest('form').attr('target', "_blank");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/showPreview') }}");
                                                $('.tab-form').trigger('submit');

                                                $(this).closest('form').attr('target', "_self");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/store') }}");
                                            })
                                        </script>
                                    </div>
                                </div> -->

                                <div class="main-content-wrapper">
                                    <div class="draft-buttons">
                                        
                                        <div class="btn btn--grey submit-for-view justify-content-center">
                                            <span class="mr-1">ნახვა</span>
                                            <img src="{{ asset('img/icons/eye-admin-panel-see.svg') }}" alt="view" draggable="false">
                                            
                                        </div>
                                        <div class="btn btn--white btn--border-red draft-submit justify-content-center">
                                            <span  class="mr-1">შენახვა</span>

                                            <img src="{{ asset('img/icons/folder-admin-panel.svg') }}" alt="save" draggable="false">
                                            
                                        </div>
                                        <script>
                                            $('.draft-submit').on('click', function() {
                                                $(this).closest('form').attr('target', "_self");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/storeDraft') }}");
                                                $('.tab-form').trigger('submit');
                                            })

                                            $('.submit-for-view').on('click', function() {
                                                $(this).closest('form').attr('target', "_blank");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/showPreview') }}");
                                                $('.tab-form').trigger('submit');

                                                $(this).closest('form').attr('target', "_self");
                                                $(this).closest('form').attr('action', "{{ url('/' . app()->getLocale() . '/admin/opportunity/store') }}");
                                            })
                                        </script>
                                    </div>

                                    <div class="sidebar sidebar-with-progress-bar">
                                        <div class="progress-bar">
                                            <div class="circle active firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="1">1</div>
                                            <div class="line" data-tab-index="2"></div>
                                            <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="2">2</div>
                                            <div class="line" data-tab-index="3"></div>
                                            <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="3">3</div>
                                            <div class="line" data-tab-index="4"></div>
                                            <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="4">4</div>
                                            <div class="line" data-tab-index="5"></div>
                                            <div class="circle firago firago--upp firago--style-normal firago--smm firago--600 firago--blue" data-tab-index="5">5</div>
                                        </div>
                                        <div class="menu">
                                            <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600 active" data-tab-index="1">
                                                შესაძებლობის შესახებ
                                            </div>
                                            <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600" data-tab-index="2">
                                                ინფორმაცია
                                            </div>
                                            <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600" data-tab-index="3">
                                                ადაპტირებულობა
                                            </div>
                                            <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600" data-tab-index="4">
                                                მედია და კითხვა-პასუხი
                                            </div>
                                            <div class="sidebar-item firago firago--upp firago--smm firago--dark firago--style-normal firago--600" data-tab-index="5">
                                                კონტაქტი
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab active" data-tab-index="1">
                                        <div class="form-group-wrapper event-title-wrapper mb-4">
                                            <div class="left">
                                                <label for="name_ka" class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark add-required--black admin-panel-opp-page-title">შესაძლებლობის სახელი
                                                </label>
                                                <div class="form__group form__group--full form__group--admin mt-1">
                                                    <input type="text" class="form__input opportunity-title pick-for-validation" id="name_ka" name="name_ka" value="{{old('name_ka')}}" pattern="[a-zA-Z0-9]+|[ა-ჰ]" placeholder="შეიყვანეთ შესაძლებლობის სახელი">
                                                    <div class="form__tooltip form__tooltip--error">
                                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                        <div>აუცილებელი ველი</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 admin-panel-opp-page-title">შესაძლებლობის მთავარი ფოტო</p>

                                        <div class="section photo-section opp-image-section mb-4">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">ატვირთული ფოტო განთავსდება შესაძლებლობის ბარათზე და შიდა გვერდზე.</div>
                                            <div class="photo-wrapper">
                                                <div class="photo-container">
                                                    <input type="file" name="image" id="opp-image-file" accept="image/jpeg, image/png" hidden data-default-image='/img/opp-default-image.png'>
                                                    <!-- <img src="{{ asset('img/event-photo.png') }}" class="uploaded-photo" id='opp-image-displayed' /> -->
                                                    <div class="rendered-raw-container cropper-box">
                                                        <div class='rendered-raw-wrapper'>
                                                            <img src="" class="opp-image" />
                                                        </div>
                                                    </div>
                                                    <div class="cropped-container cropper-box">
                                                        <img class="cropped-image" src="" alt="">
                                                        <input type="text" hidden id='opportunity-image' name='img_base64'>
                                                    </div>
                                                </div>
                                                <div class="upload-buttons">
                                                    <div class="btn btn--red non-submit opp-image-upload active justify-content-center">
                                                        
                                                        <img src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="upload photo">
                                                        <span>ფოტოს ატვირთვა</span>
                                                    </div>
                                                    <div class="btn btn--red crop-button">
                                                        <span>მოჭრა</span>
                                                        <img src="{{ asset('img/icons/crop-white.svg') }}" alt="crop image">
                                                    </div>
                                                    <div class="btn btn--red enable-crop">
                                                        <span>რედაქტირება</span>
                                                        <img src="{{ asset('img/icons/pencil-white-filled.svg') }}" alt="edit image">
                                                    </div>
                                                    <div class="btn btn--white btn--border-red opp-image-remove">
                                                        <span>წაშლა</span>
                                                        <img src="{{ asset('img/icons/bin-red.svg') }}" alt="delete image">
                                                    </div>
                                                </div>
                                                <div class="info-wrapper">
                                                    <div class="photo-info">
                                                        <div>ფორმატი:</div>
                                                        <div>png, jpeg</div>
                                                    </div>
                                                    <div class="photo-info">
                                                        <div>მოცულობა:</div>
                                                        <div>5 mb</div>
                                                    </div>
                                                    <div class="photo-info">
                                                        <div>რეზოლუცია:</div>
                                                        <div>1200x900</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">შესაძლებლობის აღწერა</p>

                                        <div class="section description-section mb-4">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">აღწერეთ თქვენი შესაძლებლობა. იცოდით, აღწერაში რომ ფოტოებისა და სხვა მრავალი ელემენტის ჩასმა შეგიძლიათ?</div>
                                            <div class="form__group form__group--admin contains-editor">
                                                <textarea id="description_ka" name="description_ka" class="description form__input" placeholder="აღწერე შესაძლებლობა"></textarea>
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div>აუცილებელი ველი</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 admin-panel-opp-page-title">აირჩიეთ შესაძლებლობის დაწყების, დასრულებისა და გამოქვეყნების თარიღი</p>

                                        <div class="section dates-section mb-4">
                                            <div class="form__group form__group--half form__group--admin mr-2">
                                                <label for="start_date" class="form__label firago firago--style-normal firago--500 firago--smm add-required--black">დაწყების თარიღი
                                                </label>
                                                <input type="text" class="form__input hasDatepicker input-bg" style="background-image: url(/img/icons/chevron-down-black.svg);" id="start_date" pattern=".{1}" name="start_date" placeholder="დაწყების თარიღი" readonly>
                                                <!-- <div class="password-visible active">
                                                <img src="{{ asset('img/icons/chevron-down-black.svg') }}" alt="chevron" draggable="false">
                                            </div> -->
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div>აუცილებელი ველი</div>
                                                </div>
                                            </div>
                                            <div class="form__group form__group--half form__group--admin mr-2">
                                                <label for="start_date" class="form__label firago firago--style-normal firago--500 firago--smm add-required--black">დასრულების თარიღი
                                                </label>
                                                <input type="text" class="form__input hasDatepicker input-bg" style="background-image: url(/img/icons/chevron-down-black.svg);" id="end_date" pattern=".{1}" name="end_date" placeholder="დასრულების თარიღი" readonly>
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div>აუცილებელი ველი</div>
                                                </div>
                                            </div>
                                            <div class="form__group form__group--half form__group--admin">
                                                <label for="start_date" class="form__label firago firago--style-normal firago--500 firago--smm add-required--black">გამოქვეყნების თარიღი
                                                </label>
                                                <input type="text" class="form__input hasDatepicker input-bg" style="background-image: url(/img/icons/chevron-down-black.svg);" id="schedule_date" pattern=".{1}" name="schedule_date" placeholder="გამოქვეყნების თარიღი" readonly>
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div>აუცილებელი ველი</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 admin-panel-opp-page-title">ფაილების მიმაგრება</p>

                                        <div class="section description-section mb-4">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">აქ შეგიძლიათ ატვირთოთ ის დოკუმენტაცია, რომელიც საჭირო ან საინტერესო იქნება თქვენი აუდიტორიისთვის. ყველა ატვირთული ფაილის გადმოწერა შესაძლებელი იქნება შესაძლებლობის შიდა გვერდზე “ფაილების გადმოტვირთვა” ღილაკზე დაჭერით.</div>
                                            <div class="permanent-tooltip form__tooltip mb-7">
                                                <img src="{{ asset('img/icons/warning-blue.svg') }}" alt="warning" draggable="false">
                                                <div class="firago firago--blue firago--style-normal firago--500 firago--sm line-height-1">თითოეული ფაილის მოცულობა არ უნდა აღემატებოდეს 30 მეგაბაიტს</div>
                                            </div>
                                            <div class="file-inputs-wrapper">
                                                <div class="file-inputs-toolbar mb-2 desktop">
                                                    <div type="button" class="button button-white button--transparent add-file-input non-submit justify-content-center">
                                                        <img src="{{ asset('img/icons/add.svg') }}" alt="plus">
                                                        <span class="ml-2 firago firago--dark firago--smm firago--upp firago--style-normal firago--600">ფაილის ატვირთვა...</span>
                                                    </div>

                                                    <div type="button" class="button button-white button--red remove-all-file-inputs non-submit">
                                                        <img src="{{ asset('img/icons/delete-admin-panel.svg') }}" alt="red x">
                                                        <span class="ml-2 firago firago--smm firago--upp firago--style-normal firago--600">ყველას გასუფთავება</span>
                                                    </div>
                                                </div>
                                                <div class="file-inputs-toolbar mb-2 mobile">
                                                    <div type="button" class="btn btn--white button--transparent add-file-input non-submit justify-content-center">
                                                        <img src="{{ asset('img/icons/add.svg') }}" alt="plus">
                                                        <span class="ml-2 firago firago--smm firago--upp firago--style-normal firago--600">ფაილის ატვირთვა...</span>
                                                    </div>

                                                    <div type="button" class="btn btn--red btn--white remove-all-file-inputs non-submit">
                                                      <img src="{{ asset('img/icons/delete-admin-panel.svg') }}" alt="red x">
                                                      <span class="ml-2 firago firago--smm firago--upp firago--style-normal firago--600">ყველას გასუფთავება</span>
                                                    </div>
                                                </div>
                                                <div class="file-inputs s12">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-buttons create-tab-buttons mt-2 mb-9">
                                            <div class="next-step-button button button--red non-submit">
                                                <span class="mr-2">გაგრძელება</span>
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
                                            </div>
                                        </div>
                                        <!-- <div class="next-step-button button button--red non-submit">
                                            <span class="mr-2">გაგრძელება</span>
                                            <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="save">
                                        </div> -->
                                    </div>
                                    <div class="tab tab--categories select-section-wrapper" data-tab-index="2">

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">კატეგორიები</p>

                                        <p class="firago firago--style-normal firago--500 firago--sm firago--dark mb-3 lower-label">
                                            მიუთითეთ ის კატეგორია, რომელიც ფიქრობთ რომ თქვენს შესაძლებლობას შეესაბამება
                                        </p>
                                        <div class="select-section simple required-checkboxes mb-4">
                                            <div class="filter__dropdown">
                                                <label id="filter-by-company-type-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                    <div class="title">ყველა კატეგორია</div>
                                                </label>
                                                <div class="separator separator-static"></div>
                                                @foreach ($categories as $category)
                                                <label id="filter-by-categories" class="checkbox-container sub-item checkbox-container--red">
                                                    <input name="categories[]" value={{$category->id}} type="checkbox" data-id="{{$category->id}}">
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$category->name}}</div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">ტიპები და ქვეტიპები</p>

                                        <p class="firago firago--style-normal firago--500 firago--sm firago--dark mb-3 lower-label">
                                            მიუთითეთ ის ტიპი და ქვეტიპი, რომელიც ფიქრობთ რომ თქვენს შესაძლებლობას შეესაბამება
                                        </p>

                                        <div class="select-section required-checkboxes select-section--admin mb-4">
                                            <div class="filter__dropdown regions opp-page-main-dropdowns">
                                                <label id="filter-by-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                    <div class="title">ყველა</div>
                                                </label>
                                                <div class="separator separator-static"></div>
                                                @foreach ($types as $type)
                                                <label class="checkbox-container sub-item checkbox-container--red">
                                                    <input type="checkbox" data-id="{{$type->id}}">
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$type->name}}</div>
                                                </label>
                                                @endforeach
                                            </div>
                                            <div class="municipalities-wrapper opp-page-results-dropdown">
                                                <div class="municipality-sections-wrapper">
                                                    @foreach ($types as $type)
                                                    <div class="municipality-section" data-region-id="{{$type->id}}">
                                                        <div class="firago firago--normal firago--sm">{{$type->name}}</div>
                                                        <div class="filter__dropdown municipalities-dropdown">
                                                            <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <div class="title">{{$type->name}}</div>
                                                                <!-- <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" /> -->
                                                            </label>
                                                            <label class="checkbox-container desktop checkbox-container--red all-checkmark uncheck-all">
                                                                <input type="checkbox">
                                                                <span class="checkmark"></span>
                                                                <div class="title">ყველა</div>
                                                            </label>
                                                            <div class="separator separator-static"></div>
                                                            @foreach ($type->subtypes as $subtype)
                                                            <label id="filter-by-municipalities" class="checkbox-container sub-item checkbox-container--red">
                                                                <input name="subtypes[]" value="{{$subtype->id}}" type="checkbox" data-id="{{$subtype->id}}">
                                                                <span class="checkmark"></span>
                                                                <div class="title">{{$subtype->name}}</div>
                                                            </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">რეგისტრაციის ტიპი</p>

                                        <div class="section registration-type-section mb-4">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">აირჩიეთ რეგისტრაციის ერთერთი ტიპი</div>

                                            <div class="registration-types required-checkboxes">
                                                <div class="registration-type left-type active">
                                                    <div class="header-row mb-4">
                                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark admin-panel-opp-page-title">მარტივი რეგისტრაცია</p>
                                                        <label class="checkbox-container sub-item">
                                                            <input type="radio" class="toggle left" name="registration_type" value="simple" checked autocomplete="off">
                                                            <span class="checkmark radio"></span>
                                                        </label>
                                                    </div>

                                                    <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">ასეთი რეგისტრაციით თქვენს შესაძლებლობაზე არ იქნება მონაწილეთა რაოდენობაზე შეზღუდვა.</div>
                                                    <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-2">ყველა მსურველი შეძლებს დარეგისტრირებას “რეგისტრაცია” ღილაკზე დაჭერით</div>
                                                </div>

                                                <div class="registration-type right-type">
                                                    <div class="header-row mb-4">
                                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark admin-panel-opp-page-title">აპლიკაციის შევსებით</p>
                                                        <label class="checkbox-container sub-item">
                                                            <input type="radio" class="toggle right" name="registration_type" value="application" autocomplete="off">
                                                            <span class="checkmark radio"></span>
                                                        </label>
                                                    </div>

                                                    <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">ჩაწერეთ აპლიკაციის URL</div>
                                                    <div class="form__group form__group--admin">
                                                        <input type="text" class="form__input" id="application_url" name="application_url" value="{{old('application_url')}}" placeholder="აპლიკაციის URL" disabled>
                                                        <div class="form__tooltip form__tooltip--error hidden">
                                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                            <div>აუცილებელი ველი</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">მიუთითეთ ასაკობრივი შუალედი</p>

                                        <div class="section age-range-section mb-9">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">მიუთითეთ შესაძლებლობაზე დასწრების მსურველთა მინიმალური ან მაქსიმალური ასაკი (ასეთის არსებობის შემთხვევაში)</div>

                                            <div class="age-row min-age-row mb-3">
                                                <div class="form__group form__group--admin mr-6">
                                                    <input type="number" class="form__input" id="min_age" min="0" max="100" name="min_age" pattern="[0-9]{1}">
                                                    <div class="form__tooltip form__tooltip--error">
                                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                        <div>აუცილებელი ველი</div>
                                                    </div>
                                                </div>
                                                <label for="has-min-age" class="checkbox-container">
                                                    <input type="checkbox" id="has-min-age" name="has-min-age">
                                                    <span class="checkmark radio"></span>
                                                    <div class="title firago firago--style-normal firago--500 firago--smm">არ აქვს მინიმალური ასაკობრივი ზღვარი</div>
                                                </label>
                                            </div>

                                            <div class="age-row max-age-row">
                                                <div class="form__group form__group--admin mr-6">
                                                    <input type="number" class="form__input" min="0" max="100" id="max_age" name="max_age" pattern="[0-9]{1}">
                                                    <div class="form__tooltip form__tooltip--error">
                                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                        <div>აუცილებელი ველი</div>
                                                    </div>
                                                </div>
                                                <label for="has-max-age" class="checkbox-container">
                                                    <input type="checkbox" id="has-max-age" name="has-max-age">
                                                    <span class="checkmark radio"></span>
                                                    <div class="title firago firago--style-normal firago--500 firago--smm">არ აქვს მაქსიმალური ასაკობრივი ზღვარი</div>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="tab-buttons create-tab-buttons mt-2 mb-9 justify-content-between">
                                            <div class="prev-step-button button button--red non-submit">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="back">
                                                <span class="ml-2">უკან დაბრუნება</span>
                                            </div>
                                            <div class="next-step-button button button--red non-submit">
                                                <span class="mr-2">გაგრძელება</span>
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="tab tab--disabilitie-admin" data-tab-index="3">
                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">შესაძლებლობის ადაპტირებულობა</p>

                                        <p class="firago firago--style-normal firago--500 firago--sm firago--dark mb-3 lower-label">
                                            მიუთითეთ, იქნება თუ არა თქვენი შესაძლებლობა შ.შ.მ. პირებისთვის რაიმე სახით ადაპტირებული
                                        </p>

                                        <div class="select-section simple required-checkboxes mb-4">
                                            <div class="filter__dropdown">
                                                <label id="filter-by-company-type-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                    <input type="checkbox">
                                                    <span class="checkmark"></span>
                                                    <div class="title">ყველას მონიშვნა</div>
                                                </label>
                                                <div class="separator separator-static"></div>
                                                @foreach ($disabilities as $disability)
                                                <label class="checkbox-container sub-item checkbox-container--red">
                                                    <input name="disabilities[]" value={{$disability->id}} type="checkbox" data-id="{{$disability->id}}">
                                                    <span class="checkmark"></span>
                                                    <div class="title">{{$disability->type}}</div>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- <div class="separator-line mb-6 mt-6"></div> -->

                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">დაფარვის არეალი</p>

                                        <p class="firago firago--style-normal firago--500 firago--sm firago--dark mb-3 lower-label">
                                            მონიშნეთ, თუ რომელ რეგიონებზე და მუნიციპალიტეტებზე გავრცელდება თქვენი შესაძლებლობა
                                        </p>

                                        <div class="select-section-wrapper ">
                                            <div class="select-section mb-11 required-checkboxes select-section--admin">
                                                <div class="filter__dropdown regions opp-page-main-dropdowns">
                                                    <label id="filter-by-municipalities-all" class="checkbox-container checkbox-container--red all-checkmark uncheck-all">
                                                        <input type="checkbox">
                                                        <span class="checkmark"></span>
                                                        <div class="title">ყველა</div>
                                                    </label>
                                                    <div class="separator separator-static"></div>
                                                    @foreach ($regions as $region)
                                                    <label class="checkbox-container sub-item checkbox-container--red">
                                                        <input name="regions[]" value={{$region->id}} type="checkbox" data-id="{{$region->id}}">
                                                        <span class="checkmark"></span>
                                                        <div class="title">{{$region->name}}</div>
                                                    </label>
                                                    @endforeach
                                                </div>
                                                <div class="municipalities-wrapper opp-page-results-dropdown">
                                                    <div class="municipality-sections-wrapper">
                                                        @foreach ($regions as $region)
                                                        <div class="municipality-section" data-region-id="{{$region->id}}">
                                                            <div class="firago firago--normal firago--sm">{{$region->name}}</div>
                                                            <div class="filter__dropdown municipalities-dropdown">
                                                                <label class="checkbox-container mobile checkbox-container--red all-checkmark uncheck-all">
                                                                    <input type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                    <div class="title">{{$region->name}}</div>
                                                                    <!-- <img src="{{ asset('/img/icons/chevron-down-blue.svg') }}" /> -->
                                                                </label>
                                                                <label class="checkbox-container desktop checkbox-container--red all-checkmark uncheck-all">
                                                                    <input type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                    <div class="title">ყველა</div>
                                                                </label>
                                                                <div class="separator separator-static"></div>
                                                                @foreach ($region->municipalities as $municipality)
                                                                <label id="filter-by-municipalities" class="checkbox-container sub-item checkbox-container--red">
                                                                    <input name="municipalities[]" value="{{$municipality->id}}" type="checkbox" data-id="{{$municipality->id}}">
                                                                    <span class="checkmark"></span>
                                                                    <div class="title">{{$municipality->name}}</div>
                                                                </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-buttons create-tab-buttons mt-2 mb-9 justify-content-between">
                                            <div class="prev-step-button button button--red non-submit">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="back">
                                                <span class="ml-2">უკან დაბრუნება</span>
                                            </div>
                                            <div class="next-step-button button button--red non-submit">
                                                <span class="mr-2">გაგრძელება</span>
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab tab-media" data-tab-index="4">
                                        <!-- <section class="section-media"> -->
                                        <!-- <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1">ატვირთე მედია</p>
                                        <div class="edit-container mb-3">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm">ტვირთეთ შესაძლებლობის ფოტო და ვიდეო მასალა</div>
                                            <div class="media-edit-actions">
                                                <div class="action-button delete">
                                                    წაშლა
                                                    <img src="{{ asset('img/icons/bin-red.svg') }}" alt="delete">
                                                </div>
                                                <div class="action-button edit active">
                                                    ჩასწორება
                                                    <img src="{{ asset('img/icons/pencil-gray.svg') }}" alt="edit">
                                                </div>
                                                <div class="action-button confirm">
                                                    დადასტურება
                                                    <img src="{{ asset('img/icons/check-gray.svg') }}" alt="confirm">
                                                </div>
                                                <div class="action-button cancel">
                                                    გაუქმება
                                                    <img src="{{ asset('img/icons/x-gray.svg') }}" alt="cancel">
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="dropzone dropzone-previews">
                                            <div class="dropzone-new-image-wrapper">
                                                <div class="dropzone dropzone-new-image">
                                                    <img src="{{ asset('img/icons/plus-gray-boxed.svg') }}" alt="add">
                                                    ფოტოს დამატება
                                                </div>
                                                <div class="dropzone-new-image-fake">
                                                    <img src="{{ asset('img/icons/plus-gray-boxed.svg') }}" alt="add">
                                                    ფოტოს დამატება
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- </section> -->
                                        <section class="section-faq">
                                            <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-3 admin-panel-opp-page-title">ატვირთეთ კითხვები</p>
                                            <div class="faq-new faq-single mb-5">
                                                <div class="faq-question">
                                                    <p class="faq-title lower-label">ჩაწერეთ კითხვა</p>
                                                    <input type="text" class='faq-input'>
                                                </div>
                                                <div class="faq-answer">
                                                    <p class="faq-title lower-label">ჩაწერეთ პასუხი</p>
                                                    <textarea class='faq-input faq-textarea' rows="10"></textarea>
                                                </div>
                                                <div class="button button--red add-faq"><img src="{{ asset('img/icons/add.svg') }}" alt="add"  class="mr-1" draggable="false">დამატება</div>
                                            </div>
                                            <div class="faq-added">
                                                <p class="faq-title admin-panel-opp-page-title">დამატებული</p>
                                            </div>
                                        </section>
                                        <div class="tab-buttons create-tab-buttons mt-2 mb-9 justify-content-between">
                                            <div class="prev-step-button button button--red non-submit">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="back">
                                                <span class="ml-2">უკან დაბრუნება</span>
                                            </div>
                                            <div class="next-step-button button button--red non-submit">
                                                <span class="mr-2">გაგრძელება</span>
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="next">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab" data-tab-index="5">
                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 add-required--black admin-panel-opp-page-title">შესაძლებლობის განხორციელების ფორმა</p>
                                        <div class="section event-type-section mb-6">
                                            <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">აირჩიეთ ერთ-ერთი</div>

                                            <div class="event-types">
                                                <div class="event-type left-type active">
                                                    <div class="header-row mb-4">
                                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark admin-panel-opp-page-title">ფიზიკურ სივრცეში</p>
                                                        <label class="checkbox-container sub-item">
                                                            <input type="radio" class="toggle left" name="execution__form" value="simple" checked autocomplete="off">
                                                            <span class="checkmark radio"></span>
                                                        </label>
                                                    </div>

                                                    <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-9">შესაძლებლობა განხორცილდება ფიზიკურ სივრცეში. ბენეფიციარებს შეეძლებათ ქვემოთ მითითებულ მისამართზე ვიზიტი.</div>
                                                </div>

                                                <div class="event-type right-type">
                                                    <div class="header-row mb-4">
                                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark admin-panel-opp-page-title">ვირტუალურ სივრცეში</p>
                                                        <label class="checkbox-container sub-item">
                                                            <input type="radio" class="toggle right" name="execution__form" value="application" autocomplete="off">
                                                            <span class="checkmark radio"></span>
                                                        </label>
                                                    </div>

                                                    <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-3">ელექტრონული ბმული</div>
                                                    <div class="form__group form__group--admin">
                                                        <input type="text" class="form__input" id="zoom_link" name="zoom_link" value="{{old('zoom_link')}}" placeholder="zoom link" disabled>
                                                        <div class="form__tooltip form__tooltip--error hidden">
                                                            <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                            <div>აუცილებელი ველი</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="opportunity-location-wrapper">

                                            <div class="section address-section">
                                                <div class="form__group form__group--full form__group--admin">
                                                    <label for="address_ka" class="form__label align-left firago firago--style-normal firago--500 firago--smm add-required--black admin-panel-opp-page-title">მისამართი სიტყვიერად</label>
                                                    <input type="text" class="form__input" id="address_ka" name="address_ka" value="{{old('address_ka')}}" pattern=".{1}">
                                                    <div class="form__tooltip form__tooltip--error">
                                                        <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                        <div>აუცილებელი ველი</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="section map-section mb-5">

                                                <div class="lower-label firago firago--style-normal firago--500 firago--smm mb-1 add-required--black admin-panel-opp-page-title">მონიშნეთ მისამართი რუკაზე:</div>

                                                <div class="map-container">
                                                    <div id='map' class="col s12"></div>
                                                </div>

                                                <input id="latitude" name="latitude" type="hidden">
                                                <input id="longitude" name="longitude" type="hidden">
                                            </div>

                                            <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-1 admin-panel-opp-page-title">პირდაპირი ტრანსლაციის ბმული:</p>

                                            <div class="section live-section">

                                                <div class="form__group form__group--admin">
                                                    <label for="live_url" class="form__label align-left firago firago--style-normal firago--500 firago--smm">Facebook live, YouTube Live ან სხვა</label>
                                                    <input type="text" class="form__input ignore" id="live_url" name="live_url" value="{{old('live_url')}}">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="separator-line mb-6 mt-6"></div>


                                        <p class="capital-label firago firago--mdd firago--style-normal firago--upp firago--dark mb-3 admin-panel-opp-page-title">სხვა საკონტაქტო ინფორმაცია</p>

                                        <div class="section contact-section mb-9">
                                            <div class="form__group  form__group--admin mb-2">
                                                <label for="email" class="form__label align-left firago firago--style-normal firago--500 firago--smm add-required--black">ელ.ფოსტა
                                                    <!-- <span class="required">
                                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                                </span> -->
                                                </label>
                                                <input type="text" class="form__input" id="email" name="email" value="{{old('email')}}" pattern="^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$">
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div alt-text='ელ-ფოსტა უკვე დარეგისტრირებულია' default-text='გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი'>გთხოვთ მიუთითოთ ელ. ფოსტის სწორი მისამართი</div>
                                                </div>
                                            </div>

                                            <div class="form__group  form__group--admin mb-2">
                                                <label for="phone" class="form__label align-left firago firago--style-normal firago--500 firago--smm">მობილურის ნომერი
                                                    <!-- <span class="required">
                                                    <img src="{{ asset('img/icons/required-red.svg') }}" alt="required" draggable="false">
                                                </span> -->
                                                </label>
                                                <input type="tel" class="form__input" id="phone" name="phone" value="{{old('phone')}}">
                                                <div class="form__tooltip form__tooltip--error">
                                                    <img src="{{ asset('img/icons/warning-red.svg') }}" alt="warning" draggable="false">
                                                    <div alt-text='ნომერი უკვე დარეგისტრირებულია' default-text='გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი'>გთხოვთ, მიუთითოთ 9 ნიშნა რიცხვი</div>
                                                </div>
                                            </div>

                                            <div class="form__group  form__group--admin mb-2">
                                                <label for="web_page" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ვებ-გვერდი</label>
                                                <input type="text" class="form__input" id="web_page" name="web_page" value="{{old('web_page')}}" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                            </div>

                                            <div class="form__group  form__group--admin mb-2">
                                                <label for="fb_page" class="form__label align-left firago firago--style-normal firago--500 firago--smm">ფეისბუქი</label>
                                                <input type="text" class="form__input" id="fb_page" name="fb_page" value="{{old('fb_page')}}" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                            </div>

                                            <div class="form__group  form__group--admin  mb-2">
                                                <label for="twitter_page" class="form__label align-left firago firago--style-normal firago--500 firago--smm">Twitter</label>
                                                <input type="text" class="form__input" id="twitter_page" name="linkedin_page" value="{{old('linkedin_page')}}" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                            </div>

                                            <div class="form__group form__group--admin">
                                                <label for="twitter_page" class="form__label align-left firago firago--style-normal firago--500 firago--smm">Linkedin</label>
                                                <input type="text" class="form__input" id="linkedin_page" name="linkedin_page" value="{{old('linkedin_page')}}" pattern="^(?:http(s)?:\/\/)?[\w.-]+(?:\.[\w\.-]+)+[\w\-\._~:/?#[\]@!\$&'\(\)\*\+,;=.]{0,}|^$">
                                            </div>
                                        </div>

                                        <div class="tab-buttons create-tab-buttons mt-2 mb-9 justify-content-between">
                                            <div class="prev-step-button button button--red non-submit">
                                                <img src="{{ asset('img/icons/arrow-right-white.svg') }}" alt="back">
                                                <span class="ml-2">უკან დაბრუნება</span>
                                            </div>
                                            <div class="submit-button button button--red non-submit">
                                                <span class="mr-2">შენახვა</span>
                                                <img src="{{ asset('img/icons/save-icon-white.svg') }}" alt="save">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                    <!-- Content Area Ends -->
                </div>
                <div class="content-overlay"></div>
            </div>
        </div>
    </div>
</div>
<!-- END: Page Main-->

@endsection
