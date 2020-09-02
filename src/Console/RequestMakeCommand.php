<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class RequestMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:make:request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin request';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Request';

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Requests\Admin';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/admin-request.stub';
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

        return $stub;
    }
}
