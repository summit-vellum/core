<div class="col-md-8 text-right">
	<strong>{{ $collections->total() }} results</strong>

	@if(isset($filters) && !empty($filters))
		<div class="btn-group ml-2 text-left">
			<button type="button" class="btn btn-secondary dropdown-toggle btn-flat btn-filter">
		        @icon(['icon' => 'arrow-left'])
		        Filter
		   	</button>
		   	<div class="dropdown dropdown-filter hide">
		   		<div class="clearfix mb-2">
		            <span class="btn btn-secondary dropdown-toggle btn-flat pull-right mb-2 btn-sm btn-cancel-filter" data-toggle="dropdown">
						@icon(['icon' => 'arrow-right'])
						Filter
		            </span>
		        </div>

		        @foreach($filters as $filter => $values)

		        	@if($renderAsHtml[$filter] == 1)
		        		{{ $filtersLabel[$filter] }}
		        		{!! html_entity_decode($values)  !!}
		        	@else
		        		<div class="btn-group btn-group-sm btn-block mb-2">
		        			{{ $filtersLabel[$filter] }}
				        	<select class="selectpicker form-control" name="{{ $filter }}">
				        		<option value="">{{ ucfirst(str_replace('_', ' ', $filter)) }}</option>
				                @foreach($values as $id=>$value)
				                    <option value="{{ $id }}"
				                    @if(request($filter) != null && request($filter) == $id)
				                    selected
				                    @endif
				                    >{{ $value }}</option>
				                @endforeach
				        	</select>
				        </div>
		        	@endif

		        @endforeach

		        <input type="submit" class="btn btn-primary btn-sm btn-apply" value="Apply">
				<a href="#" class="btn btn-default btn-sm btn-cancel-filter">Cancel</a>

		   	</div>
		</div>
	@endif

</div>

@push('css')

@foreach(array_unique(Arr::flatten($filtersCss)) as $key)
<link href="{{asset($key)}}" rel="stylesheet">
@endforeach

@endpush


@push('scripts')

@foreach(array_unique(Arr::flatten($filtersJs)) as $key)
<script type="text/javascript" src="{{asset($key)}}"></script>
@endforeach

<script type="text/javascript">
	$('.btn-filter').on('click', function(){
   		$('.dropdown-filter').addClass('show');
    });

    $('.btn-apply, .btn-cancel-filter').on('click', function(e){
        $('.dropdown-filter').removeClass('show');
    });
</script>

@endpush

