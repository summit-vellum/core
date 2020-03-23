<div class="form-group mb-5
	@if(isset($hidden) && $hidden != '') hide @endif
    @if(isset($id) && in_array($id, config('table.force_exclude_fields')))
        hidden
    @endif
">
    @if(!(isset($customLabel) && $customLabel != '') && isset($label))
    <label for="{{ $id }}" class="cf-label {{ $labelClasses ?? '' }}">
        {{ $label ?? '' }}
    </label>
    @endif

    @if(isset($required) && $required != '')
        <small class="cf-note pull-right mt-1" style="color:red;"><i>Required!</i></small>
    @endif


    @if(isset($customLabel) && $customLabel != '')
        <div class="input-group">
            <div for="{{ $id }}" class="{{ $customLabel }}">
                {{ $label }}
            </div>
            {{ $slot }}
        </div>
    @else

        {{ $slot }}

    @endif

    @form
        @if((isset($help) && $help != '') || isset($maxCount) && $maxCount != '')
    	<div class="mt-2" id="help-{{ $id }}">
    		@if(isset($help) && $help != '')
	            @icon(['icon' => 'info', 'classes'=>'help-info pull-left'])
	            @icon(['icon' => 'validated-check', 'classes'=>'help-validated-check pull-left hide'])
	            @icon(['icon' => 'validated-error', 'classes'=>'help-validated-error pull-left hide'])
		        <small class="cf-note"
	                help-original="{{ $help  }}"
	                help-maxed="{{ $maxCountHelp ?? '' }}"
	                >{!! html_entity_decode($help)  !!}</small>
            @endif
            @if(isset($maxCount) && $maxCount != '')
	            <small class="cf-note pull-right">
	                <span id="count-{{ $id }}">0</span>/{{ $maxCount }}
	            </small>
	        @endif
	    </div>
	    @endif
    @endform

    <div class="invalid-feedback">
        {{ $errors->first($id) ?? null }}
    </div>

    <div>{{ $extra ?? '' }}</div>


</div>
