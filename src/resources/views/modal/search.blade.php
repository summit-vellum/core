<form role="form" autocomplete="off">
    <div class="col-md-10 pl-0 mb-3">
        <input type="text" class="cf-input" name="search" placeholder="{{ isset($placeholder) ? $placeholder : '' }}">
        <input type="hidden" name="type" value="{{ isset($type) ? $type : '' }}">
    </div>
    <div class="col-md-2 px-0 mb-3">
        <input type="submit" name="submit" value="Search" class="btn btn-primary btn-block cf-button">
    </div>
</form>
