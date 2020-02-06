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
    	@if(isset($maxCharacters) && $maxCharacters != '')
            <small class="cf-note pull-right">
                <span id="count-{{ $id }}">0</span>/{{ $maxCharacters }}
            </small>
        @endif

        @if(isset($help) && $help != '')
    	<div class="mt-2" id="help-{{ $id }}">
	    	@icon(['icon' => 'info', 'classes'=>'pull-left'])
	        <small class="cf-note" help-original="{{ $help  }}" help-maxed="{{ $maxCharactersHelp ?? '' }}" >{{ $help  }}</small>
	    </div>
	    @endif
    @endform

    <div class="invalid-feedback">
        {{ $errors->first($id) ?? null }}
    </div>

    <div>{{ $extra ?? '' }}</div>


</div>
