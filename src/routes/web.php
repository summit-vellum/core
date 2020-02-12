<?php

use Vellum\Module\Quill;

Route::group(['middleware' => 'web'], function () {

	$modules = event(Quill::MODULE);

	foreach ($modules as $module) {
		Route::resource($module['name'], 'Vellum\Controllers\ResourceController');

		Route::post($module['name'] . '/unlock/{id}', 'Vellum\Controllers\ResourceController@unlock')->name($module['name'] . '.unlock');
		Route::any($module['name'] . '/check-unique', 'Vellum\Controllers\ResourceController@checkUnique')->name($module['name'] . '.unique');
		Route::any($module['name'] . '/to-slug', 'Vellum\Controllers\ResourceController@toSLug')->name($module['name'] . '.slug');
		Route::get($module['name'] . '/autosave/{id}/edit', 'Vellum\Controllers\AutosaveController@edit')->name($module['name'] . '.autosave.edit');
		Route::post($module['name'] . '/autosave/{id}', 'Vellum\Controllers\AutosaveController@create')->name($module['name'] . '.autosave.create');
		Route::put($module['name'] . '/autosave/{id}', 'Vellum\Controllers\AutosaveController@update')->name($module['name'] . '.autosave.update');
	}
});
