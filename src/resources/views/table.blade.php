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
					<tr class="{{ $row->trashed() ? 'article-disabled' : '' }}">
						@php
							$dashboardNotifCount = 1;
							$colspanCount = count(array_column($attributes['collections'], 'displayDashboardNotif'));
							$resourceLocked = (in_array($module, config('resource_lock')) && $row->resourceLock) ? true : false;
						@endphp

						@foreach($attributes['collections'] as $key => $column)
							@if(in_array($module, config('autosave')) && $row->autosaves &&
							(isset($column['displayDashboardNotif']) && $column['displayDashboardNotif']))
								@if($dashboardNotifCount == 1)
									@if(auth()->user()->id == $row->autosaves->user->id)
									<td colspan="{{ $colspanCount }}" class="{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }} danger text-center middle">
										You were not able to close this {{ $module }} correctly. Auto-save has been enabled.
									</td>
									@endif
								@endif

								@php $dashboardNotifCount++; @endphp
							@elseif($resourceLocked && (isset($column['displayDashboardNotif']) && $column['displayDashboardNotif']))
								@if($dashboardNotifCount == 1)
									<td class="{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }} warning text-center middle" colspan="{{ $colspanCount }}">
										@if(auth()->user()->id == $row->resourceLock->user->id)
											You are currently editing this {{ $module }}
										@else
											{{ $row->resourceLock->user->name }} is currently editing this {{ $module }}
											@can('update')
											<a href="" class="pull-right unlock" data-toggle="modal" data-target="#unlockResourceDialog" data-ajax-modal='{"items":{"title":"","author":"","header":"Are you sure you want to unlock this {{ $module }}? {{ $row->resourceLock->user->name }} is currently editing it.","dismiss":"Cancel and go back","continue":"Continue and unlock","subtext":""},"params":{"url":"{{ route($module.".unlock", $row->id) }}","type":"POST"}}'>@icon(['icon' => 'unlock'])</a>
											@endcan
										@endif
									</td>
								@endif

								@php $dashboardNotifCount++; @endphp
							@else
								<td class="{{ array_key_exists('hideFromIndex', $column) ? 'hidden' : '' }}">
									@if(isset($column['displayAsEdit']) && $column['displayAsEdit'])
										@php
											$editRoute = route($module.'.edit', $row->id);
											$disabled = '';
										@endphp

										@can('update')
											@if($resourceLocked && auth()->user()->id != $row->resourceLock->user->id)
												<?php $disabled = 'disabled'; ?>
											@endif
										@endcan

										@cannot('update')
											<?php $disabled = 'disabled'; ?>
										@endcan

										<a href="{{ $editRoute }}" class="{{ $disabled}}">
											<strong>@include(template('cell', [], 'vellum'), ['attributes' => $column, 'data' => $row])</strong>
										</a>
									@else
										@include(template('cell', [], 'vellum'), ['attributes' => $column, 'data' => $row])
									@endif
								</td>

							@endif
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
