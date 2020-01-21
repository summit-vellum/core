@if ($paginator->hasPages())
<!-- <div class=""> -->
    <ul class="clearfix pagination text-xs bg-gray-100 font-semibold w-full rounded-bl-lg rounded-br-lg border-t border-gray-300 uppercase" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="float-left text-center py-2 px-4 text-gray-400 font-semibold" class="disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
            	<span class="py-2 flex item-center">
	                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mx-3"><path class="heroicon-ui" d="M14.7 15.3a1 1 0 0 1-1.4 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.4 1.4L11.42 12l3.3 3.3z"/></svg>
	                <span>{!! __('pagination.previous') !!}</span>
            	</span>
            </li>
        @else
            <li class="float-left text-center py-2 text-gray-600 font-semibold hover:bg-gray-300">
                <a class="py-2 px-4 flex item-center rounded-tl rounded-bl" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mx-3"><path class="heroicon-ui" d="M14.7 15.3a1 1 0 0 1-1.4 1.4l-4-4a1 1 0 0 1 0-1.4l4-4a1 1 0 0 1 1.4 1.4L11.42 12l3.3 3.3z"/></svg>
                <span>{!! __('pagination.previous') !!}</span></a>
            </li>
        @endif

      <!--   {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="flex-grow text-center py-2 text-gray-600 font-semibold" class="disabled" aria-disabled="true"><span class="py-2 px-4 bg-blue-100">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="flex-grow text-center py-2 text-gray-600 font-semibold bg-gray-400" class="active" aria-current="page"><span class="py-2 px-4">{{ $page }}</span></li>
                    @else
                        <li class="flex-grow text-center py-2 text-gray-600 font-semibold hover:bg-gray-300"><a class="py-2 px-4" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach -->

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="float-right text-center py-2 text-gray-600 font-semibold hover:bg-gray-300">
                <a class="py-2 px-4 hover:bg-gray-300 flex item-center " href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}"><span>{!! __('pagination.next') !!}</span> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mx-3"><path class="heroicon-ui" d="M9.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"/></svg></a>
            </li>
        @else
            <li class="float-right flex item-center text-center py-2 text-gray-600 font-semibold hover:bg-gray-300 hover:bg-gray-300" class="disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                <span>{!! __('pagination.next') !!}</span> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-4 h-4 mx-3"><path class="heroicon-ui" d="M9.3 8.7a1 1 0 0 1 1.4-1.4l4 4a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4-1.4l3.29-3.3-3.3-3.3z"/></svg>
            </li>
        @endif
    </ul>
<!-- </div> -->
@endif
