@input(['id' => $name])
    @slot('label')
        {{ $data['label'] }}
    @endslot

    @slot('help')
        {{ $data['help'] ?? '' }}
    @endslot
    
    <select 
        name="{{ $name }}" 
        class="custom-select" 
        id="{{ $name }}" 
        style="width: auto;"
        @isset($attributes['required']) {{ 'required' }} @endisset
        >
        <option value=""> -- </option>
    
        @foreach($data['values'] as $id => $val)
            <option value="{{ $id }}" {{ (old($name, $value) == $id) ? "selected" : "" }}>{{ $val }}</option>
        @endforeach
    </select>
@endinput