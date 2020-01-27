<div class="form-group mb-5
	@if(isset($hidden) && $hidden != '') hide @endif
    @if(isset($id) && in_array($id, config('table.force_exclude_fields')))
        hidden
    @endif
">
    <label for="{{ $id }}" class="cf-label">
        {{ $label }}
    </label>

    {{ $slot }}

    @form
    	@if(isset($help) && $help != '')
    	<div class="mt-2">
	    	@icon(['icon' => 'info', 'classes'=>'pull-left'])
	        <small class="cf-note">{{ $help ?? '' }}</small>
	    </div>
	    @endif
    @endform

    <div class="invalid-feedback">
        {{ $errors->first($id) ?? null }}
    </div>

    <div>{{ $extra ?? '' }}</div>


</div>
