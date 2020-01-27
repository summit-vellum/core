<?php

namespace Vellum\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;
use Quill\Permission\Listeners\RegisterPermission;
use Vellum\Module\Quill;
use Illuminate\Support\Arr;

class AuthModuleServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // policies...
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($class) { 
            $classBaseName = class_basename($class);
            $className = explode('\\', $class)[1];
            $path = "Quill\\{$className}\Models\Policies\\{$className}Policy";

            return $path;
        });

        $permissionsEvent = event(Quill::PERMISSION);
        $collapse = Arr::collapse($permissionsEvent);
        $flatten = Arr::flatten($collapse); 
        $permissions = array_unique($flatten);
        foreach ($permissions as $key) {
            $key = strtolower($key);
            $policy = "Quill\\Permission\\Models\\Gates\\PermissionGate@{$key}";
            Gate::define("{$key}", $policy);
        }
    }
}
