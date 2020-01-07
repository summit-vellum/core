
@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @slot('help')
        {{ $attributes['info'] ?? '' }}
    @endslot

    
    @form

        <textarea
            name="{{  $attributes['id'] }}"
            class="form-control" 
            id="{{  $attributes['id'] }}"
            @isset($attributes['required']) {{ 'required' }} @endisset
            />{{ old($attributes['name'], $value) }}</textarea>

    @else
            
        <div>
            {!! $value !!}
        </div>

    @endform

@endinput