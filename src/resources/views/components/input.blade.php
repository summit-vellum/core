<div class="{{ (isset($attributes['yieldAt'])) ? $attributes['yieldAt'] : 'form-group mb-5' }}
	{{ (isset($attributes['inputClass'])) ? $attributes['inputClass'] : '' }}
	@if(isset($hidden) && $hidden != '') hide @endif
    @if(isset($id) && in_array($id, config('table.force_exclude_fields')))
        hidden
    @endif
">
	@if(isset($attributes['labelSection']))
		@section($attributes['labelSection'])
	@endif

	    @if(isset($label))
	    <label for="{{ $id }}" class="cf-label {{ $labelClasses ?? '' }}">
	        {{ $label ?? '' }}
	    </label>
	    @endif

    @if(isset($attributes['labelSection']))
    	@append
    @endif

    @if(isset($required) && $required != '')
        <small class="cf-note pull-right mt-1" style="color:red;"><i>Required!</i></small>
    @endif

    @if(isset($attributes['container']) && $attributes['container']['sectionName'])
		@section($attributes['container']['sectionName'])
	@endif

	    @if(isset($customLabel) && $customLabel != '')
	        <div class="input-group">
	            <div class="{{ $customLabelClasses }}">
	                {{ $customLabel }}
	            </div>
	            {{ $slot }}
	        </div>
	    @else

	        {{ $slot }}

	    @endif

    @if(isset($attributes['container']) && $attributes['container']['sectionName'])
    	@append
    @endif

    @if(isset($attributes['container']) && isset($attributes['container']['view']))
    	{!! $attributes['container']['view'] !!}
    @endif

    @form

    	@if(isset($attributes['infotextSection']))
    		@section($attributes['infotextSection'])
    	@endif

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

		@if(isset($attributes['infotextSection']))
	    	@append
	    @endif

    @endform

    <div class="invalid-feedback">
        {{ $errors->first($id) ?? null }}
    </div>

    <div>{{ $extra ?? '' }}</div>


</div>

