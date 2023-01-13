@if ($comment->user)
<div id="opportunity-comment-{{$comment->id}}" class="comment" data-comment-id="{{$comment->id}}">
    <div class="comment__votes">
        <div id='comment-1-{{$comment->id}}' class="comment__vote comment__vote--up {{ ($auth && $comment->upVotesUsers($guard)->contains($user->id)) ? 'active' : ''}}" data-opportunity-comment-id={{$comment->id}}>
            <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg" data-popup-message='კომენტარის შეფასებისთვის გაიარე ავტორიაზაცია'>
                <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
            </svg>
            <div id="vote-count-1-{{$comment->id}}">{{ $comment->upVotesCount()}} </div>
        </div>
        <div id='comment-0-{{$comment->id}}' class="comment__vote comment__vote--down {{ ($auth && $comment->downVotesUsers($guard)->contains($user->id)) ? 'active' : ''}}" data-opportunity-comment-id={{$comment->id}}>
            <svg viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg" data-popup-message='კომენტარის შეფასებისთვის გაიარე ავტორიაზაცია'>
                <path d="M14.6832 21.0012H6.85271V10.6661H0.536133L10.7679 0.537597L20.9998 10.6661H14.6832V21.0012Z" fill="#A7A8AD" />
            </svg>
            <div id="vote-count-0-{{$comment->id}}">{{ $comment->downVotesCount()}}</div>
        </div>
    </div>
    <div class="comment__img comment__img--circle">
        <img src="{{ url("/storage/" . $comment->user->getImagePath() )}}" alt="upvote" draggable="false" />
    </div>
    <!-- <div class="comment__text">
        <div class="comment__author">{{$comment->user->first_name}} {{$comment->user->last_name}}</div>
        <p class="comment__content">{{$comment->text}}</p>
    </div> -->
    <div class="comment__text">
        <div class="comment__author">{{$comment->user->first_name}} {{$comment->user->last_name}}</div>
        <!-- <p class="comment__content">{{$comment->text}}</p> -->
        <textarea class="comment__content" name="" readonly>{{$comment->text}}</textarea>
    </div>
    <div class="comment__actions">
        <div class="comment__date">{{$comment->getDateString()}}</div>
        @if ($auth && $guard == 'web' && $user->id == $comment->user->id )
        <!-- <button class="comment__button comment__button--submit-edit">
            <svg viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5 5H6.5V4H7.5V5ZM5.5 5H4.5V4H5.5V5ZM3.5 5H2.5V4H3.5V5ZM9 0.5H1C0.734784 0.5 0.48043 0.605357 0.292893 0.792893C0.105357 0.98043 0 1.23478 0 1.5V10.5L2 8.5H9C9.26522 8.5 9.51957 8.39464 9.70711 8.20711C9.89464 8.01957 10 7.76522 10 7.5V1.5C10 0.945 9.55 0.5 9 0.5Z" />
            </svg>
        </button> -->
        <div class="buttons-container edit-submit">
            <button class="comment__button comment__button--edit">
                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.3213 2.97007C11.5596 2.73177 11.5596 2.33461 11.3213 2.10853L9.89147 0.678725C9.66539 0.440425 9.26822 0.440425 9.02992 0.678725L7.90564 1.7969L10.197 4.08825L11.3213 2.97007ZM0.5 9.20865V11.5H2.79135L9.5493 4.73594L7.25795 2.44459L0.5 9.20865Z" fill="#686B6F" />
                </svg>
            </button>
            <button class="comment__button comment__button--submit-edit hidden">
                <span>შენახვა</span>
                <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.7168 11.0466L1.44839 6.69475L0 8.17145L5.7168 14L18 1.47671L16.5516 0L5.7168 11.0466Z" fill="white" />
                </svg>
            </button>
        </div>
        <div class="buttons-container delete-cancel">
            <button class="comment__button comment__button--delete" data-comment-id={{$comment->id}}>
                <svg viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.05556 1.11111H6.91667L6.30556 0.5H3.25L2.63889 1.11111H0.5V2.33333H9.05556V1.11111ZM1.11111 10.2778C1.11111 10.6019 1.23988 10.9128 1.46909 11.142C1.6983 11.3712 2.00918 11.5 2.33333 11.5H7.22222C7.54638 11.5 7.85725 11.3712 8.08646 11.142C8.31567 10.9128 8.44444 10.6019 8.44444 10.2778V2.94444H1.11111V10.2778Z" fill="white" />
                </svg>
            </button>
            <button class="comment__button comment__button--cancel hidden">
                <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 1.30571L7.19429 0.5L4 3.69429L0.805714 0.5L0 1.30571L3.19429 4.5L0 7.69429L0.805714 8.5L4 5.30571L7.19429 8.5L8 7.69429L4.80571 4.5L8 1.30571Z" fill="white" />
                </svg>
            </button>
        </div>
        <!-- <button class="comment__button comment__button--edit">
            <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.3213 2.97007C11.5596 2.73177 11.5596 2.33461 11.3213 2.10853L9.89147 0.678725C9.66539 0.440425 9.26822 0.440425 9.02992 0.678725L7.90564 1.7969L10.197 4.08825L11.3213 2.97007ZM0.5 9.20865V11.5H2.79135L9.5493 4.73594L7.25795 2.44459L0.5 9.20865Z" fill="#686B6F" />
            </svg>
        </button> -->
        <!-- <button class="comment__button comment__button--delete" data-comment-id={{$comment->id}}>
            <svg viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.05556 1.11111H6.91667L6.30556 0.5H3.25L2.63889 1.11111H0.5V2.33333H9.05556V1.11111ZM1.11111 10.2778C1.11111 10.6019 1.23988 10.9128 1.46909 11.142C1.6983 11.3712 2.00918 11.5 2.33333 11.5H7.22222C7.54638 11.5 7.85725 11.3712 8.08646 11.142C8.31567 10.9128 8.44444 10.6019 8.44444 10.2778V2.94444H1.11111V10.2778Z" fill="white" />
            </svg>
        </button> -->
        @endif
    </div>
</div>
@endif
