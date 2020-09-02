<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class PolicyMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:make:policy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin policies';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Policies';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/admin-policy.stub';
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
        $stub = str_replace('DummyPermissionNamespace', Str::lower(Str::plural($model)), $stub);

        return $stub;
    }
}
