
@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @slot('help')
        {{ $attributes['info'] ?? '' }}
    @endslot

    
    @form

        <select 
            name="{{ $attributes['id'] }}" 
            class="custom-select" 
            id="{{ $attributes['id'] }}" 
            style="max-width: 20rem;"
            @isset($attributes['required']) {{ 'required' }} @endisset
            >
            <option value=""> -- </option>
        
            @foreach($attributes['options'] as $id => $val)
                <option value="{{ $id }}" {{ (old($attributes['name'], $value) == $id) ? "selected" : "" }}>{{ $val }}</option>
            @endforeach
        </select>

    @else
        
        <div class="my-2">
            {!! $value !!}
        </div>

    @endform

@endinput