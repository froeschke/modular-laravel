<?php

namespace Froeschke\ModularLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixModuleStructureCommand extends Command
{
    protected $signature = 'modules:fix';

    protected $description = 'Ensures every module has the correct structure.';

    public function handle(): int
    {
        try {
            $modules = File::directories(base_path('modules'));

            foreach ($modules as $module) {
                $this->fixModuleStructure($module);
            }
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return Command::FAILURE;
        }

        $this->info('All modules have been fixed.');

        return Command::SUCCESS;
    }

    private function fixModuleStructure(string $module): void
    {
        $module = basename($module);

        $folders = config('modules.paths');

        foreach ($folders as $folder) {
            $path = base_path("modules/$module/$folder");
            if (! File::exists($path)) {
                File::makeDirectory($path);
                $this->info('Created ' . $path);
            }
        }
    }
}