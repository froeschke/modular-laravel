<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
  Config::set('modules.paths', [
    'Application',
    'Domain',
    'Infrastructure',
  ]);

  if (!File::exists(base_path('modules'))) {
    File::makeDirectory(base_path('modules'));
  }
});

afterEach(function () {
  if (File::exists(base_path('modules'))) {
    File::deleteDirectory(base_path('modules'));
  }
});

it('fixes module structure', function () {
  $modulePath = base_path('modules/TestModule');
  File::makeDirectory($modulePath);
  File::makeDirectory($modulePath . '/Application');

  $this->artisan('modules:fix')
    ->expectsOutput('Created ' . $modulePath . '/Domain')
    ->expectsOutput('Created ' . $modulePath . '/Infrastructure')
    ->expectsOutput('All modules have been fixed.')
    ->assertExitCode(0);

  expect($modulePath . '/Domain')->toBeDirectory();
  expect($modulePath . '/Infrastructure')->toBeDirectory();
});
