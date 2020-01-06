<?php

namespace Vellum\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider 
{
    protected $modules;

    public function boot()
    {
        $segment = $this->app->request->segment(1);
        
        if(!$segment) return null;
        
        $this->registerActions();
        
    }

    public function registerActions()
    {
        Blade::include('includes.actions', 'actions');
        Blade::include('button', 'button');
        Blade::include('icons.icon', 'icon');
        Blade::component('components.input', 'input');
    }

    public function register() { }
}
