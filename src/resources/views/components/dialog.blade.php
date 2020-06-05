<div id="{{ $id }}" class="modal fade" role="dialog">
    <div class="modal-dialog confirm {{ $dialogClass ?? '' }}">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                <h5 class="modal-title text-center" data-title="" data-modal-header>{{ $header ?? '' }}</h5>
            </div>

            <div class="modal-body py-5">
                <h4 class="modal-title text-center {{ $dialogTitleClass ?? '' }}">
                    <strong><span data-modal-title>{{ $title ?? '' }}</span></strong>
                    <br><small data-modal-author></small>
                    <small data-modal-subtext></small>
                </h4>

                <div class="text-center mt-5">
                    <button type="button" class="btn {{ $dismissStyle ?? 'btn-outline'}} cf-button mr-2 {{ $dismissClass ?? '' }}" data-dismiss="modal" data-modal-dismiss>{{ $dismissText ?? '' }}</button>
                    <button type="button" class="btn btn-danger cf-button ml-2 {{ $dialogContClass ?? '' }}" data-ajax-button data-modal-continue>{{ $continueText ?? '' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
