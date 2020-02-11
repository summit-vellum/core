<{{ $element ?? 'a' }}

@if(isset($element) && $element == 'button')
type="submit" value="Submit"
	@if(isset($onclick) && $onclick != '')
		onclick="{{ $onclick }}"
	@endif
@else
href="{{ route($module.'.'.($action ?? 'index')) }}"
@endif

class="btn btn-primary mr-3 mt-2 px-5 {{ isset($class) ? $class : '' }}" {!! isset($attr) ? $attr : '' !!}>
	@if(isset($icon))
    	@icon(['icons' => $icon])
    @endif
    <span>{{ $label }}</span>
</{{ $element ?? 'a' }}>
