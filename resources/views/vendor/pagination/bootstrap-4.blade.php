@if ($paginator->hasPages())
    <ul class="pagination mt-5 text-center" role="navigation">
        <div class="mx-auto">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
{{--             <li class="page-item d-inline-block disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="page-link" aria-hidden="true">&lsaquo;</span>
            </li> --}}
        @else
            <li class="page-item d-inline-block">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fas fa-long-arrow-alt-left"></i></a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item d-inline-block disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item d-inline-block active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item d-inline-block"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item d-inline-block">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"><i class="fas fa-long-arrow-alt-right"></i></a>
            </li>
        @else
{{--             <li class="page-item d-inline-block disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="page-link" aria-hidden="true">&rsaquo;</span>
            </li> --}}
        @endif
        </div>
    </ul>
@endif
