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
		        <div class="btn-group btn-group-sm btn-block mb-2">
		        	<select class="selectpicker form-control" name="{{ $filter }}">
		        		<option value="0">-- Select {{ $filter }} --</option>
		                @foreach($values as $id=>$value)
		                    <option value="{{ $id }}"
		                    @if(request($filter) == $id)
		                    selected
		                    @endif
		                    >{{ $value }}</option>
		                @endforeach
		        	</select>
		        </div>
		        @endforeach
		   	</div>
		</div>
	@endif
</div>




@push('scripts')
<script type="text/javascript">
	$('.btn-filter').on('click', function(){
   		$('.dropdown-filter').addClass('show');
    });

    $('.btn-apply, .btn-cancel-filter').on('click', function(e){
        $('.dropdown-filter').removeClass('show');
    });
</script>
@endpush

