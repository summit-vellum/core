<?php

namespace Vellum\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Vellum\Contracts\Shortcode;

class ShortcodesServiceProvider extends ServiceProvider
{
    protected $shortcodes;

    public function boot()
    {
        $segment = $this->app->request->segment(1);

        if(!$segment) return ;

        $this->app->bind(Shortcode::class, function() use ($segment) {
            $resource = 'Quill\Post\Shortcode\\'.Str::studly($segment).'Shortcode';
            return new $resource;
        });


        $this->loadShortcodes();

    }


    public function loadShortcodes()
    {
    	$shortcodes = config('shortcodes');

    	$this->shortcodes = collect($shortcodes)->map(function($shortcode){
    		return resolve($shortcode);
    	});

    	view()->composer('field::tinymce', function($view) {
    		$view->with('shortcodes', $this->shortcodes);
    	});
    }


    public function register() { }
}
