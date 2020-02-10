<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;
use Vellum\Module\Quill;

class OverrideResourceModule extends Command
{

	use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'override:moduleResource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a file that will override {Module}Resource.php for custom rendering of fields. Set {Module}Resource you want to be overriden on config/site.php';

    /**
    Example on how to override a {Module}Resource
    'override_module_resource'    => ['{ModuleNameHere}', 'Gallery']
     */

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->site = config('site');
         $this->disk = Storage::disk('app');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$activeModules = array_column(event(Quill::MODULE), 'module');

    	$modules = isset($this->site['override_module_resource']) ? $this->site['override_module_resource'] : [];

    	if (!$modules) {
    		$this->info('Make sure main_module_slug array exists and has value in config/site.php');
    		exit();
    	}

    	foreach ($modules as $module) {
    		if (!in_array($module, $activeModules)) {
    			$this->info("{$module} module does not exists. Will not be overriden");
    			continue;
    		}

    		$moduleResourcePath = app_path("Resource/{$module}/{$module}RootResource.php");
    		if (file_exists(app_path("Resource/{$module}/{$module}RootResource.php"))) {
    			$this->info("{$moduleResourcePath} already exists. Will not be overriden");
    			continue;
    		}

    		$this->module = $module;
    		$this->resource(true);
    	}
    }
}
