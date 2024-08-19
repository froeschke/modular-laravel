<?php

namespace Froeschke\ModularLaravel;

use Illuminate\Support\ServiceProvider;
use Froeschke\ModularLaravel\Commands\CreateModuleCommand;
use Froeschke\ModularLaravel\Commands\FixModuleStructureCommand;
use Froeschke\ModularLaravel\Commands\InstallModulePackageCommand;

class ModularLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/modules.php' => config_path('modules.php'),
        ]);
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallModulePackageCommand::class,
                CreateModuleCommand::class,
                FixModuleStructureCommand::class,
            ]);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/modules.php', 'modules'
        );
    }
}