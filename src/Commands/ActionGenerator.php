<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;

class ActionGenerator extends Command
{

    use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:action {action : Action name.} {module=false : The module you want to save the filter.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vellum Action';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $action = $this->argument('action');
        $namespace = 'Vellum\Actions';

        $this->module = $this->argument('module');
        $this->modulePath = '/';
        $this->disk = Storage::disk('core');


        if($this->module !== "false") {
            $this->disk = Storage::disk('modules');
            $this->directories = $this->disk->directories();

            $this->modulePath = $this->module.'/src/';
            $namespace = 'Quill\\' . $this->module . '\Actions';

            if(!$this->isModule($this->module)) {
                $this->info("{$this->module} module does not exists.");
                exit();
            }
        }

        $this->action($action, $namespace);

        $this->info("New Action created for {$this->module} module.");
    }


}
