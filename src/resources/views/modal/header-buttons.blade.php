<button type="button" class="btn btn-outline cf-button pull-left" close-modal>{{ isset($leftBtnTxt) ? $leftBtnTxt : 'Cancel' }}</button>
<button type="button" class="btn btn-success cf-button pull-right" {!!  isset($attributes) ? $attributes : '' !!}>{{ isset($rightBtnTxt) ? $rightBtnTxt : 'Add to Content' }}</button>
