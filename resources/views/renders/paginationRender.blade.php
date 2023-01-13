@if($opportunityCount > $numberPerPage)
    <ul class="pagination" data-search-term="{{ $term }}">
        <li class="page-item prev @if($page == 1) disabled @endif">
            <p class="page-link" data-new-page="{{ $page-1 }}" tabindex="-1"><img src="{{ asset('img/icons/arrow-left-black.svg') }}" alt="previous"></p>
        </li>
        @php
            $numPages = intval($opportunityCount/$numberPerPage);
            if($opportunityCount%$numberPerPage > 0) {
                $numPages += 1;
            }
            $pagesBefore = false;
            $pagesAfter = false;

            $showRange = 1;
            $collapseRange = 4;
            $notFirstOrLast = function (int $i) use($numPages) {return $i != 1 && $i != $numPages;}
        @endphp
        @for($i = 1; $i <= $numPages; $i++)
            @if ($notFirstOrLast($i) && $i < $page - $showRange && $i < $numPages - $collapseRange + 1)
                @if (!$pagesBefore)
                    <li class="page-item ">
                        <p class="page-link" data-new-page="{{ ($page - $showRange + 1 )/2 }}">...<p>
                    </li>
                @endif
                @php $pagesBefore = true @endphp
            @elseif($notFirstOrLast($i) && $i > $page + $showRange && $i > $collapseRange)
                @if (!$pagesAfter)
                    <li class="page-item ">
                        <p class="page-link" data-new-page="{{ ($numPages + $i)/2 }}">...<p>
                    </li>
                @endif
                @php $pagesAfter = true @endphp    
            @else
                <li class="page-item @if($i == $page) active @endif @if($i == $numPages) last @endif">
                    <p class="page-link" data-new-page="{{ $i }}">{{ $i }}</p>
                </li>
            @endif
        @endfor
        <li class="page-item next @if($numPages == $page) disabled @endif">
            <p class="page-link" data-new-page="{{ $page + 1 }}"><img src="{{ asset('img/icons/arrow-right-black.svg') }}" alt="previous"></p>
        </li>
    </ul>
@endif
