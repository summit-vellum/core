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
	@include('vellum::maintenance')
    @include('vellum::search')
    @include('vellum::table', ['collections' => $collections, 'attributes' => $attributes])

    @section('actions')
    	@button(['action'=>'create', 'color'=>'blue','label'=>'+ New'])
    @append
@endsection

@push('scripts')
<script src="{{asset('vendor/vellum/js/custom.js')}}"></script>
@endpush