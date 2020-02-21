@includeWhen($collections->total() == 0, template('empty'))
@dialog(['id' => 'unlockResourceDialog'])

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
					<tr class="{{ $row->trashed() ? 'article-disabled' : '' }}" data-id="{{ $row->id }}" table-row>
						@foreach($attributes['collections'] as $key => $column)
							@php
								$fieldSelected = isset($column['fieldSelected']) ? $column['fieldSelected'] : '';
							@endphp
							<td class="{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}" data-field-selected="{{ $fieldSelected }}">
								@include(template('cell', [], 'vellum'), ['attributes' => $column, 'data' => $row])
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
