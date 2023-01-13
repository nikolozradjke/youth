<div class="user-area-nav @if(isset($className)) {{ $className }} @endif">
    <div class="go-back">
        <img src="{{ asset('img/icons/back-white.svg') }}" alt="go back" draggable="false">
    </div>
    @if(isset($pageTitle))
        <div class="page-title heading heading--fancy heading--fancy-white">{{ $pageTitle }}</div>
    @endif
    <a href="/"><img src="{{ asset('img/icons/x-white.svg') }}" alt="close" draggable="false"></a>
</div>