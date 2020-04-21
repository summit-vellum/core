@if(isset($isRaw))
	@include(($iconModule ?? 'vellum').'::icons.'.$icon)
@else
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon {{ isset($classes) ? $classes : '' }}">@include(($iconModule ?? 'vellum').'::icons.'.$icon)</svg>
@endif
