<?php

namespace Froeschke\ModularLaravel\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class CreateModuleCommand extends Command
{
    private string $moduleName;
    private string $modulePath;

    protected $signature = 'modules:create {name}';

    protected $description = 'Create a new module';

    public function handle(): int
    {
        if (! File::exists(base_path('/modules'))) {
            $this->error('Please run php artisan module:install first!');

            return Command::FAILURE;
        }

        $this->moduleName =  $this->argument('name');
        $this->modulePath = base_path('/modules/' . ucfirst($this->moduleName));

        $this->createPaths();
        $this->publishStubs();

        $this->info('Module created. To activate the module, register its service provider in your config.');

        return Command::SUCCESS;
    }

    private function createPaths(): void
    {
        try {
            File::makeDirectory($this->modulePath);
        } catch (Exception $exception) {
            $this->error("Error creating module directory: {$exception->getMessage()}");
        }

        try {
            foreach (Config::get('modules.paths') as $path) {
                File::makeDirectory($this->modulePath . '/' . $path);
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function publishStubs(): void
    {
        /* Module Service Provider */
        $serviceProviderPath = Config::get('modules.provider_path');
        $moduleName = strtolower($this->moduleName);

        $providerNamespace = "Modules\\{$this->moduleName}\\{$serviceProviderPath}";

        $serviceProviderStub = File::get(__DIR__ . '/../../stubs/service_provider.stub');
        $serviceProviderStub = str_replace('{{namespace}}', $providerNamespace, $serviceProviderStub);
        $serviceProviderStub = str_replace('{{className}}', "{$this->moduleName}ServiceProvider", $serviceProviderStub);
        $serviceProviderStub = str_replace('{{moduleName}}', "{$moduleName}", $serviceProviderStub);

        File::put($this->modulePath . "/" . $serviceProviderPath . "/{$this->moduleName}ServiceProvider.php", $serviceProviderStub);

        /* Route service provider */
        $routeServiceProviderStub = File::get(__DIR__ . '/../../stubs/route_service_provider.stub');
        $routeServiceProviderStub = str_replace('{{namespace}}', $providerNamespace, $routeServiceProviderStub);

        File::put($this->modulePath . '/' . $serviceProviderPath . '/RouteServiceProvider.php', $routeServiceProviderStub);

        /* Default routes file */
        $routesPath = $serviceProviderPath = Config::get('modules.routes_file_location');
        $routesStub = File::get(__DIR__ . '/../../stubs/routes.stub');
        $routesStub = str_replace('{{moduleName}}', strtolower($this->moduleName), $routesStub);

        File::put($this->modulePath . '/' . $routesPath, $routesStub);
    }
}