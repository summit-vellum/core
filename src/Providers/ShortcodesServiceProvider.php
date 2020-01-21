<?php

namespace Vellum\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Vellum\Contracts\Shortcode;
use Vellum\Repositories\ResourceRepository;

class ShortcodesServiceProvider extends ServiceProvider
{
    protected $shortcodes;

    public function boot()
    {
        $segment = $this->app->request->segment(2);
        $module = $this->app->request->segment(1);
        $module = Str::studly(Str::slug($module, '_'));

        if(!$segment || in_array($segment, ['create','edit','delete'])) return ;

        $this->app->bind(Shortcode::class, function() use ($segment, $module) {
            $shortcode = 'Quill\\'.$module.'\Shortcode\\'.Str::studly($segment).'Shortcode';
            $resource = 'Quill\\' . $module . '\Resource\\' . $module . 'Resource';

            return new $shortcode(new ResourceRepository(new $resource));
        });
    }

    public function register() { }
}
