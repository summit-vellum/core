<div class="flex" role="group" aria-label="First group">

    @foreach($actions as $action)

        
        @can($action->permission(), $data)

            
            @if(
            	in_array('index', 
            		explode('.', \Route::current()->getName())
            	)
            )
            
                <a href="{{ $action->link($data->id, $data) }}" class="{{ $action->getStyles() }}" {{ $action->getAttributes($data) }}>
                    {!! $action->icon() !!}
                </a>

            @else

                <a href="{{ $action->link($data->id, $data) }}" class="{{ $action->getStyles('button') }}" {{ $action->getAttributes($data) }}>
                {!! $action->icon() !!}
                    <span class="ml-2">{{ $action->label() }}</span>
                </a>

            @endif


        @endcan    



    @endforeach

</div>
