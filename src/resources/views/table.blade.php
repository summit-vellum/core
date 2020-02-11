@includeWhen($collections->total() == 0, template('empty'))

@if($collections->total())
	<div class="row">
		<div class="col-md-12">
			<table class="table table-responsive table-bordered h6 table-articles">
				<thead class="thead-default">
					<tr>
						@foreach($attributes['collections'] as $key=>$column)
							<th class="text-center border-left-0
							{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}
							"> {!! display_column($column) !!} </th>
						@endforeach
						<th class="text-center border-left-0" width="22%">Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($collections as $row)
					<tr class="">
						@foreach($attributes['collections'] as $key => $column)
						<td class="{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}">
							@include(template('cell', ['attributes' => $column, 'data' => $row], 'vellum'))
						</td>
						@endforeach

						@actions(['module' => $module, 'actions' => $actions, 'data' => $row])

					</tr>
	    			@endforeach
				</tbody>
			</table>
			{{ $collections->appends(request()->input())->onEachSide(2)->links() }}
		</div>
	</div>
@endif
