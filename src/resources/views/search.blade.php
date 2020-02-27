<form role="form" class="form-horizontal">
	<div class="row mb-2">
		@if($searchables)
		<div class="col-md-3">
			<div>
                <label class="sr-only" for="search">Search</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search {{ ucfirst($module) }} {{ isset($searchables) ? 'by '.commaAndOrSeperator($searchables) : '' }}" value="{{ request()->get('search') }}">
            </div>
		</div>
		<div class="col-md-1">
			<div class="form-group">
				<button name="submit" class="btn btn-primary form-controler">Search</button>
			</div>
		</div>
		@endif

        @include(template('filter'))

	</div>
</form>

