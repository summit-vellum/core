@extends($page ?? 'vellum::default')

@section('title', 'Create New '. $details['title'])
@push('css')

@foreach(array_unique(Arr::flatten($attributes['assets']['style'])) as $key)
<link href="{{asset($key)}}" rel="stylesheet">
@endforeach
@endpush

@php
	$currentModule = $modules[array_search($module, array_column($modules, 'name'))];
	$navHeader = isset($currentModule['navHeader'])?$currentModule['navHeader']:'';
	$navHeaderField = (isset($currentModule['navHeader']) && isset($data->{$navHeader['field']})) ? $data->{$navHeader['field']} : '';
@endphp

@if($navHeader)
	@section('nav')
	@dialog(['id' => 'navHeaderExit',
			 'dialogClass'=> 'modal-confirm-idle',
			 'dismissStyle' => 'btn-success',
			 'dialogContClass' => 'hide',
			 'dialogTitleClass' => 'hide'
			])
	<li>
		@if(in_array($module, config('resource_lock')) && $navHeaderField)
		<a href="" data-toggle="modal" data-target="#navHeaderExit" data-ajax-modal='{"items":{"dismiss":"OK","header":"Exit this {{ $overrideModule?:$module }} first"}}'>
		@else
		<a href="{{ route($currentModule['name'].'.index') }}">
		@endif
			<span><strong>{{ $navHeader['left'] }}</strong></span>
			@icon(['icon' => 'arrow-right'])
			<span>
				<strong class="color-azure-radiance" nav-header-right>
					@if($navHeaderField)
						{{ $navHeaderField }}
					@else
						{{ $navHeader['right'] }}
					@endif
				</strong>
			</span>
		</a>
	</li>
	@stop
@endif

@section('content')

<form
	id="form-{{$module}}"
    class="needs-validation
    @if($errors->any()) {{ 'was-validated' }} @endif"
    novalidate
    action="{{ $routeUrl }}"
    method="post"
    enctype="multipart/form-data"
    >

    @csrf

    @empty($data)
        @method('POST')
     @else
        @method('PUT')
    @endempty

    @foreach($attributes['collections'] as $key => $field)
    	@php
    		$hasTemplate = isset($field['template']) ? true : false;

    		if ($hasTemplate && !isset($template)) {
    			$template = $field['template'];
    		}
    	@endphp

    	@section(isset($field['yieldAt']) ? $field['yieldAt'] : 'formFields')
			@includeIf(template($field['element'],[],'field'),
				[
	                'attributes' => $field,
	                'data' => $data,
	                'value' => $data ? ($data->$key) ?? '' : ''
	            ])
        @append
    @endforeach

    @if(!isset($template))
    <div class="container px-0 container-max-width">
    @endif

	    	@if(in_array($module, config('resource_lock')))
		       @section('left_actions')
		       		@if(isset($data) && !empty($data))
		       			<li>
				            @button(["element"=>"button", "onclick"=>"window.location='".route($module.'.index')."'", 'color'=>'red','label'=>'Exit', 'attr'=>arrayToHtmlAttributes(['data-url' => route($module . '.unlock', isset($data->id) ? $data->id : '')]), 'class' => 'btn-unlock btn-danger btn btn-primary mr-3 mt-2 px-5'])
				        </li>
			        @endif
		        @append
	        @endif

	        <div class="text-right float-right">
	            @form

	            	@section('actions')
	            		@if($module=='post')
	            			@include(template('checkSeo',[],'seoscore'))

	            			@if(isset($data) && !empty($data))

					        @else
					        	@include(template('syndicate.actionButton',[],'post'))
					        @endif

				        @include(template('publishBtns', [], 'post'), ['data'=>$data, 'status'=>config('status')])
				    @else
				    	<li>
					    	@button(['element'=>'button', 'color'=>'blue','label'=>'Save', 'onclick'=>'$("#form-'.$module.'").submit()', 'class'=>'btn btn-primary mr-3 mt-2 px-5'])
					    </li>
	        		@endif
	        	@append

	            @else

	                @actions(['module' => $module, 'actions' => $actions, 'data' => $data])

	            @endform

        </div>

	    @yield('formFields')

	    {!! $template ?? '' !!}

	@if(!isset($template))
	</div>
	@endif

</form>

@endsection

@push('scripts')

@foreach(array_unique(Arr::flatten($attributes['assets']['script'])) as $key)
<script type="text/javascript" src="{{asset($key)}}"></script>
@endforeach

@if(in_array($module, config('autosave')))
<script type="text/javascript">
    var asDelay = {{config('form.autosave') ?? 'false'}};
</script>
@endif

<script type="text/javascript" src="{{asset('vendor/vellum/js/custom.js')}}"></script>
<script type="text/javascript" src="{{asset('vendor/vellum/js/form.js')}}"></script>
@endpush
@form
    @push('scripts')
        <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                console.log(form.checkValidity());
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
        })();

        function readURL(input) {
            if (input.files && input.files[0]) {
                var imagePlaceholder = '#imagePreview-' + $(input).attr('id');
                var imageText = $(input).attr('id').replace('-uploader', '');
                var reader = new FileReader();

                reader.onprogress = function (e) {
                    $(imagePlaceholder).parent().removeClass('hidden');
                }

                reader.onload = function (e) {
                    $(imagePlaceholder).attr('src', e.target.result);
                    $(imagePlaceholder).parent().removeClass('hidden');
                    $(`#${imageText}`).val(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @endpush
@endform
