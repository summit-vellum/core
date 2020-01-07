<div class="card mt-3" style="width: 20rem;">{{-- 
    <div class="card-header">Image Preview</div> --}}
    @if(empty($image))
        <img src="https://fakeimg.pl/250x100/" class="card-img-top" alt="..." id="imagePreview-{{ $id }}">
    @else
        <img src="{{ $image ?? 'https://fakeimg.pl/250x100/' }}" class="card-img-top" alt="..." id="imagePreview-{{ $id }}">
    @endif
    <!-- <div class="card-body">
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    </div> -->
</div>