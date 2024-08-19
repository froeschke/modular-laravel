<?php

namespace Froeschke\ModularLaravel\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallModulePackageCommand extends Command
{
    protected $signature = 'modules:install';

    protected $description = 'Make your application ready for Modular Laravel';

    public function handle(): int
    {
        try {
            $path = base_path('/composer.json');
            $composer = json_decode(file_get_contents($path), true);

            $composer['autoload']['psr-4']['Modules\\'] = 'modules/';

            try {
                File::makeDirectory(base_path('modules'));

                $this->info('A modules/ folder has been created.');
            } catch (Exception $exception) {
                $this->error('Directory modules/ already exists!');
            }

            file_put_contents($path, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }

        $this->info('The modules/ folder has been registered within composer.');

        return Command::SUCCESS;
    }
}