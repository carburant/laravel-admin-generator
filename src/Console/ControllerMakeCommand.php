<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class ControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:make:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Admin';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/admin-controller.stub';
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }

        $name = class_basename($this->getNameInput());
        $pluralName = Str::lower(Str::plural($name));

        $this->info("Add in router/admin.php: Route::resource('{$pluralName}', '{$name}Controller');");
    }

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string|string[]
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = str_replace($this->type, null, class_basename($name));

        $stub = str_replace('DummyModelName', $model, $stub);
        $stub = str_replace('DummyModelVarName', Str::lower($model), $stub);
        $stub = str_replace('DummyRequestName', $model, $stub);
        $stub = str_replace('DummyViewName', Str::lower(Str::plural($model)), $stub);
        $stub = str_replace('DummyRouteName', Str::lower(Str::plural($model)), $stub);

        return $stub;
    }
}
