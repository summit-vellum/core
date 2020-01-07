


@input(['id' => $attributes['id']])
    @slot('label')
        {{ $attributes['name'] }}
    @endslot

    @slot('help')
        {{ $attributes['info'] ?? '' }}
    @endslot

{{-- // data-target-input="nearest" --}}

    @form

        <div class="input-group date"  style="max-width: 18rem;">
            <input
                name="{{ $attributes['id'] }}"
                type="text" 
                value="{{ old($attributes['id'], $value) }}" 
                class="form-control" 
                id="{{ $attributes['id'] }}"
                style="width: auto;"
                @isset($attributes['required']) {{ 'required' }} @endisset
                />
                <div class="input-group-append">
                    <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                    </span>
                </div>
        </div>

    @else 

        <div class="my-2">
            {!! $value !!}
        </div>

    @endform

@endinput


@push('css')
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
@endpush

@push('scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <script type="text/javascript">
        // $('.input-group.date').datepicker({
        //     format: "M dd, yyyy",
        //     maxViewMode: 2,
        //     todayBtn: "linked",
        //     clearBtn: true
        // });
        $(function () {
            $('.input-group.date').datetimepicker();
        });
    </script>
@endpush