
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
            id="{{ $attributes['id'] }}" 
            style="width: auto;"
            @isset($attributes['required']) {{ 'required' }} @endisset
            >
            <option value=""> -- </option>
        <div class="media">
            <img class="align-self-center mr-3 rounded-circle" src="..." alt="Generic placeholder image">
            <div class="media-body">
            </div>
        </div>
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

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script>
        $('select').selectpicker();
    </script>
@endpush