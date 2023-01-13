@foreach($messages as $message)
    <div class="comment" data-message-id="{{$message->id}}">
        <div class="comment__votes">
            <div class="comment__vote comment__vote--up @if($message->isLikeduser(1)) active @endif">
                <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
                </svg>
                <div class="number">{{$message->likedUsers()->count()}}</div>
            </div>
            <div class="comment__vote comment__vote--down @if($message->isLikeduser(0)) active @endif">
                <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
                </svg>
                <div class="number">{{$message->dislikedUsers()->count()}}</div>
            </div>
        </div>
        <div class="comment__img comment__img--circle">
            <img src="{{ url('/storage/' . $message->getUserPicture()) }}" alt="upvote" draggable="false" />
        </div>
        <div class="comment__text">
            <div class="comment__author">{{ $message->getUserName()}}</div>
            <p class="comment__content">{!! $message->message !!}</p>
        </div>
        <div class="comment__actions">
            <div class="comment__date">{{$message->getDateString()}}</div>
        </div>
    </div>
@endforeach