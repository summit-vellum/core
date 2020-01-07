

@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @form

        <textarea
            name="{{ $attributes['id'] }}"
            class="form-control" 
            id="{{ $attributes['id'] }}"
            @isset($attributes['required']) {{ 'required' }} @endisset
            />{{ old($attributes['id'], $value) }}</textarea>
    
    @else

        <details class="my-2">
            <summary class="text-primary mb-2">Show Post Content</summary>

            {!! $value !!}
        </details>

    @endform

@endinput


@form
    @push('scripts')
        <script src="{{ url('vendor/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector:'#{{ $attributes['id']}}',
                height: 500,
                width: '100%',
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css'
                ]
            });
        </script>
    @endpush
@endform