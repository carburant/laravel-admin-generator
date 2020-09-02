<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ViewMakeCommand extends Command
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
    protected $signature = 'admin:make:view {name}';

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

        $pluralLowerName = Str::lower(Str::plural($name));

        $stubs = [
            'index.stub' => [
                'DummyTitle' => Str::plural($name),
                'DummyRouteName' => $pluralLowerName,
                'DummyComponentName' => $pluralLowerName,
            ],
            'form.stub' => [
                'DummyTitle' => Str::plural($name),
                'DummyRouteName' => $pluralLowerName,
                'DummyModelVarName' => Str::lower($name)
            ],
            'partials/action.stub' => [
                'DummyRouteName' => $pluralLowerName,
            ],
            'partials/name.stub' => [
                'DummyRouteName' => $pluralLowerName,
            ]
        ];

        foreach($stubs as $file => $dummy) {
            $stub = $this->files->get(__DIR__ . '/stubs/resources/views/' . str_replace('/', '-', $file));
            $stub = str_replace(array_keys($dummy), array_values($dummy), $stub);

            $path = resource_path('views/admin/' . $pluralLowerName . '/' . str_replace('stub', 'blade.php', $file));

            $this->makeDirectory($path);

            $this->files->put($path, $stub);
        }

        $this->info('Resource created successfully.');
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
