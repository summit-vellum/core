<?php

use Vellum\Module\Quill;

Route::group(['middleware' => 'web'], function () {

	$modules = event(Quill::MODULE);

	foreach ($modules as $module) {
		Route::resource($module['name'], 'Vellum\Controllers\ResourceController');
		Route::post($module['name'] . '/unlock/{id}', 'Vellum\Controllers\ResourceController@unlock')->name($module['name'] . '.unlock');
	}
});
