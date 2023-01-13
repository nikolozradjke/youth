
<div class="wrapper">
    <div class="events pt-5">
        <p class="firago firago--blue firago--mdd not-found mb-3" style="display: none">ორგანიზაციები არ მოიძებნა</p>
        @foreach ($companies as $company)
            @include('templates.organization')
        @endforeach
    </div>
</div>