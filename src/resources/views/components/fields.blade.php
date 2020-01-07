

<h1>{{ $title }}</h1>

@foreach($fields as $key=>$value)
    <div class="form-row">
    {{ 'includes.forms.'.$value['type'] }}
        @include('includes.forms.'.$value['type'], ['name' => $key, 'data' => $value])
        <!-- <div class="valid-feedback">
            Looks good!
        </div>
        <div class="invalid-feedback">
            Please provide a valid!
        </div> -->
    </div>
@endforeach