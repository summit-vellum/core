<?php

namespace Vellum\Contracts;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait HasStub
{

    protected $directories;

    protected $disk;

    protected $module;

    protected $modulePath;

    protected $mainModulePath;


    protected function setModulePath($module)
    {
        $this->modulePath .= $module.'/src/';
    }

     protected function setMainModulePath($module)
    {
        $this->mainModulePath .= $module;
    }

    protected function isModule($module)
    {
        return in_array($module, $this->directories);
    }

    protected function allModules()
    {
        return $this->directories;
    }

    protected function buildModuleDirectories()
    {
        $module  = $this->module;

        if($this->isModule($module))
        {
            $this->info('Module is already exists.');
            exit();
        }

        $source = $module.'/src/';
        $this->disk->makeDirectory($source);
        $this->disk->makeDirectory($source.'Models');
        $this->disk->makeDirectory($source.'Models/Policies');
        // $this->disk->makeDirectory($source.'Presenters');
        $this->disk->makeDirectory($source.'routes');
        $this->disk->makeDirectory($source.'Listeners');
        $this->disk->makeDirectory($source.'Resource');
        $this->disk->makeDirectory($source.'Events');
        $this->disk->makeDirectory($source.'Filters');
        $this->disk->makeDirectory($source.'Actions');
        $this->disk->makeDirectory($source.'config');
        $this->disk->makeDirectory($source.'Http');
        $this->disk->makeDirectory($source.'Http/Controllers');
        $this->disk->makeDirectory($source.'Http/Requests');
        $this->disk->makeDirectory($source.'database/migrations');
        $this->disk->makeDirectory($source.'database/factories');
        $this->disk->makeDirectory($source.'database/seeds');

        $this->info("{$this->module} module directory created successfuly.");
    }

    protected function rollback()
    {
		if($this->isModule($this->module))
        {
            $this->disk->deleteDirectory($this->module);

        	$this->info("Process successfully rollback, module deleted.");

        }
    }

    protected function getStub($type)
    {
        return File::get(base_path("core/src/resources/stubs/$type.stub"));
    }

    protected function model()
    {
        $modelTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNamePluralLowerCase}}',
            ],
            [
                $this->module,
                strtolower(Str::plural($this->module)),
            ],
            $this->getStub('Model'));

        $this->createStubToFile("Models/{$this->module}.php", $modelTemplate);
    }

    protected function modelPivot($pivotName)
    {
        $modelTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{pivotSingularNamePascalCase}}',
                '{{pivotSingularNameLowerCase}}',
            ],
            [
                $this->module,
                Str::studly($pivotName),
                $pivotName,
            ],
            $this->getStub('Model'));

        $this->createStubToFile("Models/".Str::studly($pivotName).".php", $modelTemplate);
    }

    protected function presenter()
    {
        $presenterTemplate = str_replace(
            ['{{moduleName}}'],
            [$this->module],
            $this->getStub('Presenter'));

        $this->createStubToFile("Presenters/{$this->module}Presenter.php", $presenterTemplate);
    }

    protected function config()
    {
        $moduleTemplate = str_replace(
            ['{{moduleName}}'],
            [$this->module],
            $this->getStub('Config'));

        $this->createStubToFile("config/".strtolower($this->module).".php", $moduleTemplate);
    }


    protected function routes()
    {
        $routeTemplate = str_replace(
            ['{{moduleNameSingularLowerCase}}'],
            [strtolower(Str::kebab($this->module))],
            $this->getStub('Route'));

        $this->createStubToFile("routes/".strtolower($this->module).".php", $routeTemplate);
    }

    protected function controller()
    {
        $controllerTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNamePluralLowerCase}}',
                '{{moduleNameSingularLowerCase}}'
            ],
            [
                $this->module,
                strtolower(Str::plural($this->module)),
                strtolower($this->module)
            ],
            $this->getStub('Controller')
        );

        $this->createStubToFile("Http/Controllers/{$this->module}Controller.php", $controllerTemplate);
    }

    protected function request()
    {
        $requestTemplate = str_replace(
            ['{{moduleName}}'],
            [$this->module],
            $this->getStub('Request')
        );

        $this->createStubToFile("Requests/{$this->module}Request.php", $requestTemplate);
    }

    protected function observer()
    {
        $observerTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNameSingularLowerCase}}'
            ],
            [
                $this->module,
                strtolower($this->module)
            ],
            $this->getStub('Observer')
        );

        $this->createStubToFile("Models/{$this->module}Observer.php", $observerTemplate);
    }

    protected function resource()
    {
        $resourceTemplate = str_replace(
            ['{{moduleName}}'],
            [$this->module],
            $this->getStub('Resource')
        );

        $this->createStubToFile("Resource/{$this->module}Resource.php", $resourceTemplate);
    }

    protected function serviceProvider()
    {
        $serviceProviderTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNamePluralLowerCase}}',
                '{{moduleNameSingularLowerCase}}'
            ],
            [
                $this->module,
                strtolower(Str::plural($this->module)),
                strtolower($this->module)
            ],
            $this->getStub('ServiceProvider')
        );

        $this->createStubToFile("{$this->module}ServiceProvider.php", $serviceProviderTemplate);
    }

    protected function authServiceProvider()
    {
        $authServiceProviderTemplate = str_replace(
            ['{{moduleName}}'],
            [$this->module],
            $this->getStub('AuthModuleServiceProvider')
        );

        $this->createStubToFile("{$this->module}AuthModuleServiceProvider.php", $authServiceProviderTemplate);
    }

    protected function policy()
    {
        $policyTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNameSingularLowerCase}}',
                '{{moduleNameSlug}}'
            ],
            [
                $this->module,
                strtolower($this->module),
                strtolower(Str::kebab($this->module))
            ],
            $this->getStub('Policy')
        );

        $this->createStubToFile("Models/Policies/{$this->module}Policy.php", $policyTemplate);
    }

    protected function registerModule()
    {
        $registerModuleTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNameSingularLowerCase}}'
            ],
            [
                $this->module,
                strtolower(Str::kebab($this->module))
            ],
            $this->getStub('RegisterModule')
        );

        $this->createStubToFile("Listeners/Register{$this->module}Module.php", $registerModuleTemplate);
    }

    protected function composer()
    {
        $this->info('This will create a vellum module package. Please provide the details for the module.');
        $description = $this->ask('Description');
        $name = $this->ask('Author');
        $email = $this->ask('Email');

        $composerTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{moduleNameSingularLowerCase}}',
                '{{description}}',
                '{{name}}',
                '{{email}}',
            ],
            [
                $this->module,
                strtolower($this->module),
                $description,
                $name,
                $email
            ],
            $this->getStub('Composer')
        );

        $this->createStubToFile("{$this->module}/composer.json", $composerTemplate, true);
    }

    protected function seed()
    {
    	$this->info('Creating seeder file.');
        $seederTemplate = str_replace(
        	[
        		'{{moduleName}}'
        	],
        	[
        		$this->module
        	],
        	$this->getStub('Seed')
        );

        $this->createStubToFile("database/seeds/{$this->module}TableSeeder.php", $seederTemplate);
    }

    protected function factory()
    {
    	$this->info('Creating factory file.');
        $factoryTemplate = str_replace(
        	[
        		'{{moduleName}}'
        	],
        	[
        		$this->module
        	],
        	$this->getStub('Factory')
        );

        $this->createStubToFile("database/factories/{$this->module}Factory.php", $factoryTemplate);
    }

    protected function migrate()
    {

        $module = strtolower($this->module);
        $migrationPath = 'modules/'.$this->modulePath.'database/migrations';
        $modulePlural = Str::plural($module);

        $this->info('Creating a migration scripts.');
        Artisan::call("make:migration create_{$module}_table --path={$migrationPath} --create={$modulePlural}");

        $this->seed();
        $this->factory();
        // Artisan::call("make:seeder {$this->module}TableSeeder");
        // Artisan::call("make:factory {$this->module}Factory --model={$this->module}");

        $hasPivot = $this->anticipate('Is your table requires pivot table(Yes or No)?',['Yes','No']);

        if(strtolower($hasPivot) === 'yes'){
        	$pivot = $this->ask('Pivot to what Module(table name)?');

	        if(!$this->isModule($pivot)) {
	            $this->info("{$pivot} module does not exists.");
	            exit();
	        }

	        $arrayNames = [strtolower($pivot), $module];
	        sort($arrayNames);
	        $pivotTableName = implode('_', $arrayNames);

	        Artisan::call("make:migration create_{$pivotTableName}_table --path={$migrationPath} --create={$pivotTableName}");

	        $this->modelPivot($pivotTableName);

	    }

        $this->info('Migration script created.');
    }

    protected function filter($name)
    {
        $filterTemplate = str_replace(
            [
                '{{moduleName}}',
                '{{filterName}}'
            ],
            [
                $this->module,
                $name
            ],
            $this->getStub('Filter')
        );

        $this->createStubToFile("Filters/{$name}Filter.php", $filterTemplate);
    }

    protected function action($name, $namespace)
    {

        $filename = "Actions/{$name}Action.php";
        $files = $this->disk->files($this->modulePath.'Actions');

        if(in_array($filename, $files)) {
            $this->info("{$filename} already exists, please enter a unique action name.");
            exit();
        }


        $filterTemplate = str_replace(
            [
                '{{actionName}}',
                '{{actionNameSingularLowerCase}}',
                '{{namespace}}'
            ],
            [
                $name,
                strtolower($name),
                $namespace
            ],
            $this->getStub('Action')
        );

        $this->createStubToFile($filename, $filterTemplate);
    }

    protected function createStubToFile($file, $template, $mainDirectory = false)
    {
    	$path = ($mainDirectory) ? $this->mainModulePath : $this->modulePath;

        $this->disk->put(
            $path . $file,
            $template
        );

        $this->info("$file created successfuly.");
    }

    protected function build()
    {
        $this->buildModuleDirectories();
        $this->composer();
        $this->model();
        $this->config();
        $this->routes();
        $this->policy();
        // $this->presenter();
        $this->controller();
        $this->request();
        $this->observer();
        $this->resource();
        $this->registerModule();
        $this->serviceProvider();
        // $this->authServiceProvider();
        $this->migrate();
    }
}
