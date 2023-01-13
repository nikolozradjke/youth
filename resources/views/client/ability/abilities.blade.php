@extends('layouts.master')

@section('content')

  <section class="abilities-map-page">
    <div class="wrapper">
      <h2 class="heading heading--xl">შესაძლებლობების რუკა</h2>
      <p class="p">მოიძიე შესაძლებლობის რუკაზე აქტივობები ლოცაკიცეიბს მიხედვით</p>
      <div id="map" class="abilities-map"></div>
    </div>
	</section>

@endsection

@section('script')
    <script>
        const items = '{{ json_encode($response, JSON_UNESCAPED_UNICODE) }}';
    </script>
    
    <script src="{{ asset('js/abilities.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZ9T3k3ovMlu9-b0I0wpmJE93ztTPhfYE&callback=initMap"></script>
@endsection