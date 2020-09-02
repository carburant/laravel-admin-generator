<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ComponentMakeCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:make:component {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin views (index, form, partial action & partial name)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = Str::ucfirst(Str::lower($this->getNameInput()));

        $stub = $this->files->get(__DIR__ . '/stubs/resources/js/components/admin-index.stub');

        $path = resource_path('js/components/Admin/' . $name . '/Index.vue');

        $this->makeDirectory($path);

        $this->files->put($path, $stub);

        $this->info('Component created successfully.');
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return trim($this->argument('name'));
    }

    /**
     * Build the directory for the class if necessary.
     *
     * @param  string  $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

}
