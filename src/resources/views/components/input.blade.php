
<div class="flex item-center border-b py-5
    @if(isset($id) && in_array($id, config('table.force_exclude_fields')))
        hidden
    @endif
">
    <label for="{{ $id }}" class="w-40 text-gray-500 font-semibold text-sm">
        {{ $label }}
    </label>

    <div 
        class="flex-auto w-4/5">

        {{ $slot }}
        
        @form
            <small class="font-sm text-gray-500 block mt-1">{{ $help ?? '' }}</small>
        @endform

        <div class="invalid-feedback">
            {{ $errors->first($id) ?? null }}
        </div>

        <div>{{ $extra ?? '' }}</div>
    </div>

</div>