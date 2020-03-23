<{{ $element ?? 'a' }}

@if(isset($element) && $element == 'button')
type="submit" value="Submit"
	@if(isset($onclick) && $onclick != '')
		onclick="{{ $onclick }}"
	@endif
@else
	@if(isset($link))
	href="{{ $link }}"
	@else
	href="{{ route($module.'.'.($action ?? 'index')) }}"
	@endif
@endif

class="{{ isset($class) ? $class : '' }}" {!! isset($attr) ? $attr : '' !!}>
	@if(isset($icon))
    	@icon(['icons' => $icon, 'classes' => ($iconClasses) ?? '' ])
    @endif
    <span class="{{ $spanClass ?? '' }}">{{ $label }}</span>
</{{ $element ?? 'a' }}>
