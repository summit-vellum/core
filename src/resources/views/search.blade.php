<form role="form" class="form-horizontal">
	<div class="row mb-2">
		<div class="col-md-3">
			<div>
                <label class="sr-only" for="search">Search</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Search Article by ID or Title" value="">
            </div>
		</div>
		<div class="col-md-1">
			<div class="form-group">
				<button name="submit" class="btn btn-primary form-controler">Search</button>
			</div>
		</div>

        @include(template('filter'))

	</div>
</form>
