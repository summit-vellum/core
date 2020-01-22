<?php

namespace Vellum\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    }
}
