<?php

use Vellum\Module\Quill;

Route::group(['middleware' => 'web'], function() {

    $modules = event(Quill::MODULE);

	foreach($modules as $module) {
		Route::resource($module['name'], 'Vellum\Controllers\ResourceController');
	}

});

