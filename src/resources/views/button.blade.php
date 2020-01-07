<{{ $element ?? 'a' }} 

@if(isset($element) && $element == 'button')
type="submit" value="Submit"
@else
href="{{ route($module.'.'.($action ?? 'index')) }}" 
@endif

class="bg-{{ $color }}-500 rounded px-4 py-2 text-white hover:bg-{{ $color }}-600 font-semibold shadow inline-flex items-center">
    @icon(['icons' => $icon])
    <span>{{ $label }}</span>
</{{ $element ?? 'a' }}>
