<div class="mb-6 mt-3 shadow-lg py-3 px-3 flex bg-white" data-selected>
    @for($i=0;$i<4;$i++)
        @include('vellum::modal.selected-items', [
            'data'=> isset($selected->data[$i]) ? $selected->data[$i] : []
        ])
    @endfor
</div>
