<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
  Config::set('modules.paths', [
    'Application',
    'Domain',
    'Infrastructure',
    'Providers',
    'Routes',
  ]);
  Config::set('modules.provider_path', 'Providers');
  Config::set('modules.routes_file_location', 'Routes/web.php');

  if (!File::exists(base_path('modules'))) {
    File::makeDirectory(base_path('modules'));
  }
});

afterEach(function () {
  if (File::exists(base_path('modules'))) {
    File::deleteDirectory(base_path('modules'));
  }
});

it('creates a new module', function () {
  $this->artisan('modules:create', ['name' => 'TestModule'])
    ->expectsOutput('Module created. To activate the module, register its service provider in your config.')
    ->assertExitCode(0);

  $modulePath = base_path('modules/TestModule');

  expect($modulePath)->toBeDirectory();
  expect($modulePath . '/Application')->toBeDirectory();
  expect($modulePath . '/Domain')->toBeDirectory();
  expect($modulePath . '/Infrastructure')->toBeDirectory();

  expect($modulePath . '/Providers/TestModuleServiceProvider.php')->toBeFile();
  expect($modulePath . '/Providers/RouteServiceProvider.php')->toBeFile();
  expect($modulePath . '/Routes/web.php')->toBeFile();
});

it('fails if modules directory does not exist', function () {
  File::deleteDirectory(base_path('modules'));

  $this->artisan('modules:create', ['name' => 'TestModule'])
    ->expectsOutput('Please run php artisan module:install first!')
    ->assertExitCode(1);
});
