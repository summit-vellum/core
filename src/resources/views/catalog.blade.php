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

<div class="">

    <h1 class="text-4xl font-bold mb-5 mt-10">{{ $details['title'] }}</h1>

    <form action="">

        <div class="flex mb-10">

            <div class="w-3/4">
                @include('vellum::search')
            </div>

            @can('create', $details['model'])

            <div class="w-1/4 text-right">

                @button(['action'=>'create', 'icon'=>'plus','color'=>'blue','label'=>'Create new'])

            </div>

            @endcan

        </div>

        @include('vellum::table', ['collections' => $collections, 'attributes' => $attributes])

    </form>

</div> 
@endsection


@push('scripts')
<script>
    $(function() {
        $('.btn-delete').click(function(e) {



            $.ajax({
                url: $(this).attr('href'),
                type: 'POST',
                data: {
                    _method: "delete",
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(status) {
                    console.log(status);
                }
            });
            e.preventDefault();
        });
    });
</script>
@endpush