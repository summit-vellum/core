<div id="{{ $id }}" class="modal fade" role="dialog">
    <div class="modal-dialog confirm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close pull-left" data-dismiss="modal">&times;</button>
                <h5 class="modal-title text-center" data-title="" data-modal-header></h5>
            </div>

            <div class="modal-body py-5">
                <h4 class="modal-title text-center">
                    <strong><span data-modal-title></span></strong>
                    <br><small data-modal-author></small>
                    <small data-modal-subtext></small>
                </h4>

                <div class="text-center mt-5">
                    <button type="button" class="btn btn-outline cf-button mr-2" data-dismiss="modal" data-modal-dismiss></button>
                    <button type="button" class="btn btn-danger cf-button ml-2" data-ajax-button data-modal-continue></button>
                </div>
            </div>
        </div>
    </div>
</div>
