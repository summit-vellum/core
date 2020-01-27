@if(isset($isRaw))
	@include('vellum::icons.'.$icon)
@else
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon {{ isset($classes) ? $classes : '' }}">@include('vellum::icons.'.$icon)</svg>
@endif
