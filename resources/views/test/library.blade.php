@extends('layouts.master')

@section('content')

  <section class="library-page">
    <div class="wrapper">
      <h2 class="heading heading--xl">ბიბლიოთეკა</h2>
      <p class="p">აირჩიე მიმართულება და განაგრძე</p>

      <div class="library-grid">
        <div class="library-card  align-items-center justify-content-center">
          <img src="{{ asset('img/poetry.png') }}" alt="">
          <h4>ლიტერატურის კატალოგი</h4>
          <p>ლიტერაურის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
          <a href="#">განაგრძე</a>
        </div>
        <div class="library-card  align-items-center justify-content-center">
          <img src="{{ asset('img/seo.png') }}" alt="">
          <h4>კვლევების კატალოგი</h4>
          <p>კვლევის კატალოგის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
          <a href="#">განაგრძე</a>
        </div>
        <div class="library-card align-items-center justify-content-center">
          <img src="{{ asset('img/study.png') }}" alt="">
          <h4>სასწავლო კაბინეტი</h4>
          <p>სასწავლო კაბინეტის მოკლე დახასიათება და აღწერა არის სარურველი სანამ მომხმარებელი გადავა შიდა გვერდზე</p>
          <a href="#">განაგრძე</a>
        </div>
      </div>
    </div>
	</section>

@endsection