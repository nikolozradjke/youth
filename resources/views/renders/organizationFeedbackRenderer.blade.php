<div id="{{ $feedback->id }}" class="comment" data-comment-id="{{ $feedback->id }}">
    <div class="comment__img-container">
        <div class="comment__img comment__img--circle">
            <img src='{{ url("/storage/" . $feedback->user->getImagePath() )}}' alt="user-image" draggable="false" />
        </div>
        <div class="comment__author comment__author-mobile">{{ $feedback->user->first_name . ' ' . $feedback->user->last_name }}
            <a href="{{ $feedback->opportunity->getURL() }}" class="event-link">({{ $feedback->opportunity->name }})</a>
        </div>
    </div>
    <div class="comment__text">
        <div class="comment__author">{{ $feedback->user->first_name . ' ' . $feedback->user->last_name }}
            <a href="{{ $feedback->opportunity->getURL() }}" class="event-link">({{ $feedback->opportunity->name }})</a>
        </div>
        <p class="comment__content">{{ $feedback->message }}</p>
    </div>
</div>