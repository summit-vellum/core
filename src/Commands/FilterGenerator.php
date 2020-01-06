<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;

class FilterGenerator extends Command
{

    use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {filter : Filter class name.} {module : The module you want to save the filter.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vellum Filter';

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
        $filter = $this->argument('filter');
        $this->module = $this->argument('module');
        $this->modulePath .= $this->module.'/src/';

        if(!$this->isModule($this->module)) {
            $this->info("{$this->module} module does not exists.");
            exit();
        }

        $this->filter($filter);

        $this->info("New filter created for {$this->module} module.");
    }


}
