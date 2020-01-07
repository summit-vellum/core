<div class="bg-white rounded-lg shadow-md">


	@includeWhen($collections->total() == 0, 'vellum::empty')

	@if($collections->total())

    <div class="px-4 py-2 clearfix">
        <div class="float-left text-sm text-gray-500">
            <span class="mt-1 inline-block">
                Diplaying {{ $collections->firstItem() }} to {{ $collections->lastItem() }} out of {{ $collections->total() }}
            </span>
        </div>
        {{-- Display filter blade here... --}}
        @include('vellum::filter')
        {{-- End filter blade... --}}
    </div>

    <div class="table w-full">

        <div class="table-row border-b-2 border-t-2">

            @foreach($attributes['collections'] as $key=>$column)
                <div class="table-cell font-bold p-3 text-xs uppercase
                    text-gray-600 bg-gray-100 border-b border-t
                    border-gray-300
                    {{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}
                    ">
                    {!! display_column($column) !!}
                </div>
            @endforeach
            <div class="table-cell font-semibold p-3 text-sm text-gray-600 bg-gray-100 border-b border-t border-gray-300 w-16"></div>

        </div>

        @foreach($collections as $row)

	        <div class="table-row">
	            @foreach($attributes['collections'] as $key => $column)
	            <div class="table-cell p-3 border-b border-gray-300
                    {{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}
                    ">
	                @include('vellum::cell', ['attributes' => $column, 'data' => $row])
	            </div>
	            @endforeach
	            <div class="table-cell p-3 border-b border-gray-300 text-right w-16">
	                @actions(['module' => $module, 'actions' => $actions, 'data' => $row])
	            </div>
	        </div>

        @endforeach

    </div>

	{{ $collections->appends(request()->input())->onEachSide(2)->links() }}


	@endif

</div>
