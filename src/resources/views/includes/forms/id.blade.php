
@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @slot('help')
        {{ $attributes['info'] ?? '' }}
    @endslot
    

    @form

        <input
            name="{{ $attributes['name'] }}"
            type="text" 
            value="{{ old($attributes['name'], $value) }}" 
            class="form-control"
            id="{{ $attributes['name'] }}"
            autocomplete="off" 
            @isset($attributes['required']) {{ 'required' }} @endisset
            />

    @else

        <div class="my-2">
            {!! $value !!}
        </div>

    @endform

@endinput