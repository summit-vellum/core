<?php

namespace Vellum\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Vellum\Contracts\HasStub;

class PusherEventGenerator extends Command
{

    use HasStub;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pusherEvent {pusherEvent : PusherEvent class name.} {module : The module you want to save the filter.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Pusher Event inside your module';

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
        $pusherEvent = $this->argument('pusherEvent');
        $this->module = $this->argument('module');
        $this->modulePath .= $this->module.'/src/';

        if (!$this->isModule($this->module)) {
            $this->info("{$this->module} module does not exists.");
            exit();
        }

        if ($this->fileExists('public/pusher/pusher-main.js')) {
        	$this->info('pusherMain.js file already exists and will not be overridden');
        } else {
        	$this->pusherMainJs();
        }

        $this->pusherEvent($pusherEvent);
        $this->pusherEventJs($pusherEvent);

        $this->info("New pusher event created for {$this->module} module.");
    }


}
