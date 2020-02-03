<td class="text-center middle">
	@foreach($actions as $action)
		@can($action->permission(), $data)
			<?php $action->attributes($data); ?>
			@if(
            	in_array('index',
            		explode('.', \Route::current()->getName())
            	)
            )
			<a href="{{ (!$action->renderWithDialog()) ? $action->link($data->id, $data) : 'javascript:void(0)'  }}" class="{{ $action->getStyles() }}" {!! $action->getAttributes($data) !!}>
			    {!! $action->icon() !!}
		    </a>
		    @else
		    <a href="{{ (!$action->renderWithDialog()) ? $action->link($data->id, $data) : 'javascript:void(0)'  }}" class="{{ $action->getStyles('button') }}" {!! $action->getAttributes($data) !!}>
		    	{!! $action->icon() !!}
			    <span class="ml-2">{!! $action->label() !!}</span>
		    </a>
		    @endif
	     @endcan
	@endforeach
</td>
