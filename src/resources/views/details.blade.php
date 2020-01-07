@extends('page')

@section('title', 'New Post')

@section('content')
    <h1 class="text-3xl font-thin mb-5 mt-10">{{ $page_title }}</h1>
    
    <div class="bg-white rounded-lg shadow-md">

        @foreach($fields as $key=>$field)
            <div class="form-group row">
                <label for="{{ $field['id'] }}" class="col-sm-2 col-form-label col-form-label text-right">
                    {{ $field['name'] }}
                </label>

                <div class="col-sm-10">
                    {!! $data->$key !!}
                </div>

            </div>
        @endforeach

        <div class="text-right mb-5">
            <a href="{{ route($module.'.index') }}" title="Back to list" class="btn btn-lg btn-link float-left inline-block"><i class="fas fa-long-arrow-alt-left"></i> Go back to list</a>
            <a href="{{ route($module.'.edit', $data->id) }}" class="btn btn-primary btn-lg inline-block">Edit this Post</a>
        </div>
        
    </div>

@endsection


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
            var reader = new FileReader();

            reader.onload = function (e) {
                $(imagePlaceholder).attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
@endpush