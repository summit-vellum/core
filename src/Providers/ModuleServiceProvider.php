<?php

namespace Vellum\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Vellum\Composers\FilterComposer;
use Vellum\Contracts\FormRequestContract;
use Vellum\Contracts\Formable;
use Vellum\Contracts\Resource;
use Vellum\Module\Module;
use Vellum\Module\Quill;
use Vellum\Repositories\ResourceRepository;

class ModuleServiceProvider extends ServiceProvider
{

    private $module;

    public function boot()
    {

        $this->loadModuleSettings();
        $this->loadPackageSettings();

        $modules = event(Quill::MODULE);
        $shortcodes = event(Quill::SHORTCODE);

        $segment = $this->app->request->segment(1);

        $entity = Str::studly(Str::slug($segment,'_'));

        $moduleDetails = collect($modules)->filter(
            function($module) use ($segment) {
                return $module['name'] == $segment;
            })->first();

        if(!$moduleDetails) return;

        $this->module = $moduleDetails;

        $this->app->bind(Resource::class, function() use ($entity) {
            $resource = 'Quill\\'.$entity.'\Resource\\'.$entity.'Resource';

            if(class_exists($resource)) {
                return new ResourceRepository(new $resource);
            }
        });

        $this->app->bind(Formable::class, function() use ($entity) {
            $resource = 'Quill\\'.$entity.'\Resource\\'.$entity.'Resource';

            return new $resource;
        });

        $this->app->bind(FormRequestContract::class, function() use ($entity) {
            $resource = 'Quill\\'.$entity.'\Http\Requests\\'.$entity.'Request';

            return new $resource;
        });

        $this->app->singleton(Module::class, function($app) use($moduleDetails) {
            return new Module($moduleDetails);
        });

        Blade::if('form', function() {
            return request()->is('*/edit') || request()->is('*/create');
        });

        $this->app->extend('module', function() use($modules, $segment) {
            return collect($modules)->filter(function($module) use ($segment) {
                return $module['name'] == $segment;
            })->first();
        });

        view()->composer('*', function ($view) use($segment, $modules, $moduleDetails) {
            $view->with('module', $segment);
            $view->with('details', $moduleDetails);
            $view->with('modules', $modules);
        });

        view()->composer('filter', FilterComposer::class);

        view()->composer('field::tinymce', function($view) use($shortcodes){
            $shortcodeInstance = [];

            foreach(config('shortcodes') as $shortcode) {
                $shortcodeInstance[] = new $shortcode;
            }

            $view->with('shortcodes', $shortcodeInstance);
        });

    }

    public function register()
    {
    }

    /**
     *  Load all necessary global module configurations.
     *
     * @return void
     */
    public function loadModuleSettings()
    {
        // This will push the middleware forcely to the web variable array
        // in protected $middlewareGroups in Kernel.php
        app('router')->pushMiddlewareToGroup('web', \Vellum\Middleware\CleanParamRequests::class);
        // app('router')->pushMiddlewareToGroup('web', \Vellum\Middleware\ModuleAccess::class);

        // set the global default blade for pagination
        Paginator::defaultView('vendor.vellum.pagination.tailwind');
    }

    public function loadPackageSettings()
    {
       	$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'vellum');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/filters.php', 'filters');
        $this->mergeConfigFrom(__DIR__ . '/../config/shortcodes.php', 'shortcodes');
        $this->mergeConfigFrom(__DIR__ . '/../config/table.php', 'table');

		$this->publishes([
		    __DIR__.'/../resources/views' => resource_path('views/vendor/vellum'),
		], 'vellum.views');

		$this->publishes([
		    __DIR__.'/../config/filters.php' => config_path('filters.php'),
		    __DIR__.'/../config/shortcodes.php' => config_path('shortcodes.php'),
		    __DIR__.'/../config/table.php' => config_path('table.php'),
		], 'vellum.config');

		$this->publishes([
		    __DIR__.'/../public' => public_path('vendor/vellum'),
		], 'vellum.public');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Vellum\Commands\ModuleGenerator::class,
                \Vellum\Commands\FilterGenerator::class,
                \Vellum\Commands\ActionGenerator::class
            ]);
        }
    }
}
