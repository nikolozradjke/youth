@extends('layouts.master')

@section('content')

<section class="add-to-library-page">
  <div class="wrapper">
    <h3 class="page-title">ჩემი პროფილი</h3>
    <div class="add-to-lib-grid">
      <div class="profile-card">
        <img class="mb-2" src="{{ asset('/storage/' . $user->getImagePath()) }}">
        <h4 class="mb-2">
            {{ $guard == 'web' ? $user->first_name . ' ' . $user->last_name : $user->name }}
        </h4>
        <a href="{{ route('profile')  }}" class="button btn--red justify-content-center">
          <svg class="mr-1" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 6C7.38071 6 8.5 4.88071 8.5 3.5C8.5 2.11929 7.38071 1 6 1C4.61929 1 3.5 2.11929 3.5 3.5C3.5 4.88071 4.61929 6 6 6Z" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10.2951 11C10.2951 9.065 8.37008 7.5 6.00008 7.5C3.63008 7.5 1.70508 9.065 1.70508 11" stroke="#000" stroke-width="0.875" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          ჩემი პროფილი
        </a>
      </div>
      <div class="add-section">
        <h3>დაამატე ფაილი ბიბლიოთეკაში</h3>
        <p>ლიტერაურის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>




          <div class="select-catalog">
            <h5 class="title">აირჩიე მიმართულება</h5>
            <div class="radio-btns">
              <label for="literature" class="d-flex align-items-center justify-content-center">
                <input type="radio" name="catalog-type" id="literature" checked>
                <img src="{{ asset('img/poetry.png') }}" alt="">
                <h6>ლიტერატურის კატალოგი</h6>
                <p>ლიტერაურის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
              </label>

              <label for="research" class="d-flex align-items-center justify-content-center">
                <input type="radio" name="catalog-type" id="research">
                <img src="{{ asset('img/seo.png') }}" alt="">
                <h6>კვლევების კატალოგი</h6>
                <p>ლიტერაურის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
              </label>

              <label for="study" class="d-flex align-items-center justify-content-center">
                <input type="radio" name="catalog-type" id="study">
                <img src="{{ asset('img/study.png') }}" alt="">
                <h6>სასწავლო კაბინეტი</h6>
                <p>ლიტერაურის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
              </label>
            </div>
          </div>
          <div class="forms">
            <form action="{{ route('StoreLibrary') }}" method="POST" class="catalog-form literature active" enctype="multipart/form-data">
                @csrf
              <div class="file-category">
                <h5 class="sub-name">კატეგორია</h5>

                <div class="form__group  select__group">
                  <select name="lib_cat" id="category" class="form__select form__input  input-bg">
                    <option value="{{ null }}" selected>მიუთითეთ კატეგორია</option>
                    @forelse($lib_categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @empty
                    @endforelse
                  </select>
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">ფაილის სახელწოდება</h5>

                <div class="form__group">
                  <input name="name" class="form__input" placeholder="ჩაწერეთ" type="text">
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">ფაილის მიმაგრება</h5>
                <p>
                აქ შეგიძლიათ ატვირთოთ ის დოკუმენტაცია, რომელიც საჭირო ან საინტერესო იქნება თქვენი აუდიტორიისთვის.
                </p>


                <div class="file-inputs-wrapper">
                  <div class="file-inputs-toolbar mb-2 desktop">
                      <div type="button" class="button button-white button--transparent add-file-input non-submit justify-content-center">
                          <img src="{{ asset('img/icons/add.svg') }}" alt="plus">
                          <span class="ml-2 firago firago--dark firago--smm firago--upp firago--style-normal firago--600">ფაილის ატვირთვა...</span>
                      </div>
                  </div>

                    <div class="file-inputs s12">
                    </div>
                </div>
              </div>

              <div class=" submit-block  d-flex align-items-center justify-content-end">
                <button type="submit" class="add-file-submit button btn--red">ფაილის ატვირთვა</button>
              </div>
            </form>
            <form action="{{ route('StoreResearch') }}" method="POST" enctype="multipart/form-data" class="catalog-form research ">
                @csrf

              <div class="file-category">
                <h5 class="sub-name">ფაილის სახელწოდება</h5>

                <div class="form__group">
                  <input name="name" class="form__input" placeholder="ჩაწერეთ" type="text">
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">ფაილის მიმაგრება</h5>
                <p>
                აქ შეგიძლიათ ატვირთოთ ის დოკუმენტაცია, რომელიც საჭირო ან საინტერესო იქნება თქვენი აუდიტორიისთვის.
                </p>


                <div class="file-inputs-wrapper">
                  <div class="file-inputs-toolbar mb-2 desktop">
                      <div type="button" class="button button-white button--transparent add-file-input non-submit justify-content-center">
                          <img src="{{ asset('img/icons/add.svg') }}" alt="plus">
                          <span class="ml-2 firago firago--dark firago--smm firago--upp firago--style-normal firago--600">ფაილის ატვირთვა...</span>
                      </div>
                  </div>

                    <div class="file-inputs s12">
                    </div>
                </div>
              </div>

              <div class="submit-block d-flex align-items-center justify-content-end">
                <button type="submit" class="add-file-submit button btn--red">ფაილის ატვირთვა</button>
              </div>
            </form>
            <form action="{{ route('StoreStudyCabinet') }}" method="POST" class="catalog-form study" enctype="multipart/form-data">
                @csrf
              <div class="profile-pic profile-pic__registration  ml-1">
                  
                  <input class="profile-pic-uploader" name="image" type="file" id="inputFile" accept=".png, .jpg, .jpeg">
                  <div class="pic-container">
                      <img id="uploadedImage" src="{{ asset('img/icons/admin-panel-camera.svg') }}" alt="profile-picture">
                      <span>ფოტოს ატვირთვა</span>
                      <p>
                        <span>ფორმატი: PNG, JPEG </span>
                        <span>რეზოლუცია: 1200X900 </span>
                        <span>მოცულობა: 5MB</span>
                      </p>
                  </div>                  
              </div>
              <div class="file-category">
                <h5 class="sub-name">აქტივობის სახელი</h5>
                <div class="form__group">
                  <input class="form__input" name="name" placeholder="ჩაწერეთ" type="text">
                </div>

              </div>
              
              <div class="file-category">
                <h5 class="sub-name">აქტივობის აღწერა</h5>
                <div class="form__group">
                  <textarea class="form__input" name="description" id="" cols="30" rows="10"></textarea>
                </div>

              </div>

              <div class="file-category">
                <h5 class="sub-name">აქტივობის ხანგრძლივობა</h5>
                <div class="form__group">
                  <input class="form__input" name="duration" placeholder="ჩაწერეთ" type="text">
                </div>

              </div>

              <div class="file-category">
                <h5 class="sub-name">გუნდის ზომა</h5>

                <div class="form__group">
                  <input class="form__input" name="team_size" placeholder="ჩაწერეთ" type="text">
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">აქტივობის ზომა</h5>

                <div class="form__group">
                  <input class="form__input" name="activity_size" placeholder="ჩაწერეთ" type="text">
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">აქტივობის დონე</h5>

                <div class="form__group">
                  <input class="form__input" name="activity_level" placeholder="ჩაწერეთ" type="text">
                </div>
              </div>

              <div class="file-category">
                <h5 class="sub-name">ფაილის მიმაგრება</h5>
                <p>
                აქ შეგიძლიათ ატვირთოთ ის დოკუმენტაცია, რომელიც საჭირო ან საინტერესო იქნება თქვენი აუდიტორიისთვის.
                </p>


                <div class="file-inputs-wrapper">
                  <div class="file-inputs-toolbar mb-2 desktop">
                      <div type="button" class="button button-white button--transparent add-file-input non-submit justify-content-center">
                          <img src="{{ asset('img/icons/add.svg') }}" alt="plus">
                          <span class="ml-2 firago firago--dark firago--smm firago--upp firago--style-normal firago--600">ფაილის ატვირთვა...</span>
                      </div>
                  </div>

                    <div class="file-inputs s12">
                    </div>
                </div>
              </div>

              <div class="submit-block d-flex align-items-center justify-content-end">
                <button type="submit" class="add-file-submit button btn--red">ფაილის ატვირთვა</button>
              </div>
            </form>
          </div>
      </div>
      <!-- <div class="result-btns">
        <div class="btn  btn--grey  draft-submit justify-content-center">
            <span  class="mr-1">შენახვა</span>

            <img src="{{ asset('img/icons/folder-admin-panel.svg') }}" alt="save" draggable="false">

        </div>
        <div class="btn btn--white btn--border-red submit-for-view justify-content-center">
            <span class="mr-1">ნახვა</span>
            <img src="{{ asset('img/icons/eye-admin-panel-see.svg') }}" alt="view" draggable="false">

        </div>

      </div> -->
    </div>
  </div>
</section>



<script>

  function callUploadActions(selector){
    $(`${selector} .add-file-input`).on("click", function (e) {
      e.preventDefault();

      var inputHtml =
        '<div class="file-field input-field">\n            <div class="btn">\n                <input type="file" name="file[]">\n            </div>\n            <div class="file-path-wrapper">\n                <p class="uploaded-value firago firago--style-normal firago--500 firago--smm firago--dark"></p>\n            <div class="admin-page-remove-uploaded-file d-flex align-items-center justify-content-center">    <img class="remove-input" src="/img/icons/delete-admin-panel.svg" alt="minus"></div>\n            </div>\n        </div>';
      $(`${selector}  .file-inputs`).append(inputHtml);
      setTimeout(function () {
        $(`${selector} .file-inputs .file-field:last-child input`).on(
          "blur",
          function () {
            if ($(this).val() == "") {
              $(this).parents(".file-field").remove();
            }
          }
        );
        $(`${selector} .file-inputs .file-field:last-child input`).on(
          "change",
          function (e) {
            if ($(this).val() == "") {
              $(this).parents(".file-field").remove();
            } else {
              $(this)
                .parents(".file-field")
                .find(".file-path-wrapper")
                .addClass("active");
              $(this)
                .parents(".file-field")
                .find(".file-path-wrapper p")
                .text(e.target.files[0].name);


              if(selector==='.research' || selector==='.literature'){

                
                $(`${selector} .add-file-input`).css('display', 'none')
              }
            }
          }
        );
        $(`${selector} .file-inputs .file-field:last-child input`).click();
      }, 500);
    });
  }
  callUploadActions('.literature')
  callUploadActions('.research')
  callUploadActions('.study')

  $(document).on(
    "click",
    ".file-inputs .file-field .remove-input",
    function () {
      $this = $(this);

      if($(this)[0].closest('form').getAttribute('class').includes('literature')){
        
        $(`.literature .add-file-input`).css('display', 'flex')

      }

      if($(this)[0].closest('form').getAttribute('class').includes('research')){
        

        $(`.research .add-file-input`).css('display', 'flex')
        
      }
      
 
      var input =
        '<input type="hidden" name="deleted_files[]"></input>';
      $this.parents(".file-inputs").prepend(input);
      $this.parents(".file-field").remove();

    }
  );

  $('.radio-btns input').on("change", function (e) {
    // console.log($(this).id, e.target.id)

    $('.forms .catalog-form').removeClass('active');
    $(`.forms .catalog-form.${e.target.id}`).addClass('active');
  });
  // $('.research  .file-inputs').on('DOMSubtreeModified', function(){
  //   console.log('changed');
  //   if( $('.research  .file-field').length==0 ){
  //     $(`.research .add-file-input`).css('display', 'block')
  //   }else{
  //     $(`.research .add-file-input`).css('display', 'none')
  //   }
  // });
 


</script>
@endsection
