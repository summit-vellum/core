
@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @slot('help')
        {{ $attributes['info'] ?? '' }}
    @endslot

    @form
    
        <div class="custom-file" style="width: auto;">
            <input type="text" name="{{ $attributes['id'] }}" value="{{ old($attributes['id'], $value) }}" >
            <input 
                type="file" 
                class="custom-file-input" 
                id="{{ $attributes['id'] }}" 
                style="width: auto;"
                @isset($attributes['required']) {{ 'required' }} @endisset
                onchange="readURL(this);"
                >
            <label class="custom-file-label" for="{{ $attributes['id'] }}">Choose file...</label>
        </div>

    @endform

    @slot('extra')
        @includeIf('includes.forms.imagePreview', [
            'id' => $attributes['id'],
            'image' => old($attributes['id'], $value) ]
            )
    @endslot

@endinput