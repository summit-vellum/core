@extends($page ?? 'vellum::default')

@section('title', $details['title'])

@push('css')
<style>
    #filter:not(checked)~.filter-menu {
        display: none;
    }

    #filter:checked~.filter-menu {
        display: inline-block;
    }
</style>
@endpush

@section('content')
	@dialog(['id' => 'deleteResourceDialog'])

	<section class="container">
		@include(template('maintenance'))
	    @include(template('search'))
	    <div class="row">
	    	<div class="col-md-12">
			    @include(template('table', ['collections' => $collections, 'attributes' => $attributes]))
			</div>
		</div>
	</section>

    @section('actions')
    	@button(['action'=>'create', 'color'=>'blue','label'=>'+ New'])
    @append

@endsection

@push('scripts')
<script src="{{asset('vendor/vellum/js/custom.js')}}"></script>
@endpush
