<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;

class ModuleGenerator extends Command
{

    use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vellum module';

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
        $this->module = $this->argument('module');

        if ($this->module == 'Resource') {
        	$this->info('Module name forbidden due to overriding of {Module}Resource feature.');
        	exit();
        }

        $this->modulePath .= $this->module.'/src/';
        $this->build();

        $this->info('New Vellum module created.');
    }
}
