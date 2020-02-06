<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;
use Vellum\Models\Uam\Module;
use Vellum\Models\Uam\Permission;
use Vellum\Models\Uam\ModulePermission;
use Vellum\Module\Quill;

class UamModulePermissionGenerator extends Command
{

	use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modulePermission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates modules and module\'s permissions in UAM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->disk = Storage::disk('modules');
        $this->directories = $this->disk->directories();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	$modules = event(Quill::MODULE);

    	foreach ($modules as $key => $details) {
    		if (isset($details['module']) && isset($details['permissions']) && !empty($details['permissions'])) {
    			$module = Module::whereName($details['module'])->first();

		        if (!$module) {
		        	$moduleDetails = [
			        	'name' => $details['module'],
			        	'description' => isset($details['description']) ? $details['description'] : '',
			        	'platform_id' => env('PLATFORM_ID', 1), //add this to .env
			        	'editable' => 0
			        ];

		        	$module = new Module($moduleDetails);

			        if ($module->save()) {
			        	$this->info("\n".'Module: '.$module['name'].' ---saved in UAM');
			        	$this->addPermissions($details['permissions'], $module['id']);
			        }
		        } else {
		        	$this->info("\n".'Module: '.$module['name'].' ---exists in UAM');
		        	$this->addPermissions($details['permissions'], $module['id']);
		        }
    		}
    	}

    }

    public function addPermissions($permissions, $moduleId)
    {
    	foreach ($permissions as $key => $permission) {
        	$prmssn = Permission::whereName($permission['name'])->first();

        	if (!$prmssn) {
        		$prmssnDetails = [
        			'name' => $permission['name'],
        			'description' => $permission['description']
        		];

        		$prmssn = new Permission($prmssnDetails);
        		if ($prmssn->save()) {
        			$this->info('Permission: '.$permission['name'].' ---saved in UAM');
        			$this->addModulePermission($moduleId, $prmssn['id']);
        		}
        	} else {
        		$this->info('Permission: '.$permission['name'].' ---exists in UAM');
        		$this->addModulePermission($moduleId, $prmssn['id']);
        	}
        }
    }

    public function addModulePermission($moduleId, $permissionId)
    {
    	$modulePermission = ModulePermission::whereExists($moduleId, $permissionId)->first();

    	if (!$modulePermission) {
    		$modulePrmssnDtls = [
    			'module_id' => $moduleId,
    			'permission_id' => $permissionId
    		];

    		$modulePrmssn = new ModulePermission($modulePrmssnDtls);
    		if ($modulePrmssn->save()) {
    			$this->info('Module Id:'.$moduleId.' Permission Id:'.$permissionId.' ---saved in UAM');
    		}
    	} else {
    		$this->info('Module Id:'.$moduleId.' Permission Id:'.$permissionId.' ---already exists in UAM');
    	}
    }

}
