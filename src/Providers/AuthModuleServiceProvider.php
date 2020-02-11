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
    	$this->site = config('site');
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($class) {
            $classBaseName = class_basename($class);
            $className = explode('\\', $class)[1];

            //for when {Module}Resource is overriden
            if ($className == 'Resource') {
            	$className = explode('\\', $class)[2];
            }

            $path = "Quill\\{$className}\Models\Policies\\{$className}Policy";


            return $path;
        });

        $permissionsEvent = event(Quill::PERMISSION);
        $permissions = Arr::collapse($permissionsEvent);
        foreach ($permissions as $moduleName => $gates) {
            foreach ($gates as $gates) {
                $policy = "Quill\\{$moduleName}\\Models\\Gates\\{$moduleName}Gate@{$gates}";
                Gate::define("{$gates}", $policy);
            }
        }
    }
}
