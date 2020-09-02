<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ContentMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make:admin-content {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin content type';

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
     * @return int
     */
    public function handle()
    {
        $name = Str::ucfirst(Str::lower(trim($this->argument('name'))));
        $controllerName = $name . 'Controller';

        $this->call('admin:make:model', ['name' => $name, '-m' => true]);
        $this->call('make:model', ['name' => "{$name}Translation", '-m' => true]);

        $this->call('admin:make:controller', ['name' => $controllerName]);
        $this->call('admin:make:ajax-controller', ['name' => $controllerName]);

        $this->call('admin:make:request', ['name' => $name]);
        $this->call('admin:make:policy', ['name' => $name . 'Policy']);

        $this->call('admin:make:view', ['name' => $name]);
        $this->call('admin:make:component', ['name' => $name]);
    }
}
