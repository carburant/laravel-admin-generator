<?php

namespace Carburant\StarterPack\AdminContentGenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class AjaxControllerMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'admin:make:ajax-controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin ajax controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

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

        $name = str_replace($this->type, '', class_basename($this->getNameInput()));
        $pluralName = Str::lower(Str::plural($name));

        $this->info("Add in router/admin.php ajax: Route::get('{$pluralName}/datatable', '{$name}Controller@datatable')->name('{$pluralName}.datatable');");
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers\Admin\Ajax';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/admin-ajax-controller.stub';
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
        $stub = str_replace('DummyViewName', Str::lower(Str::plural($model)), $stub);
        $stub = str_replace('DummyTableName', Str::lower(Str::plural($model)), $stub);

        return $stub;
    }
}
