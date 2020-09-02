<?php

namespace Carburant\StarterPack\AdminContentGenerator;

use Illuminate\Support\ServiceProvider;

class AdminContentGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\ContentMakeCommand::class,

                Console\ControllerMakeCommand::class,
                Console\AjaxControllerMakeCommand::class,

                Console\ModelMakeCommand::class,
                Console\PolicyMakeCommand::class,
                Console\RequestMakeCommand::class,

                Console\ViewMakeCommand::class,
                Console\ComponentMakeCommand::class,
            ]);
        }
    }
}
