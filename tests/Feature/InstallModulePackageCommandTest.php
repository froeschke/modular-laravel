<?php

use Illuminate\Support\Facades\File;

beforeEach(function () {
  File::copy(base_path('composer.json'), base_path('composer.json.backup'));
});

afterEach(function () {
  if (File::exists(base_path('composer.json.backup'))) {
    File::move(base_path('composer.json.backup'), base_path('composer.json'));
  }

  if (File::exists(base_path('modules'))) {
    File::deleteDirectory(base_path('modules'));
  }
});

it('installs module package', function () {
  $this->artisan('modules:install')
    ->expectsOutput('A modules/ folder has been created.')
    ->expectsOutput('The modules/ folder has been registered within composer.')
    ->assertExitCode(0);

  expect(base_path('modules'))->toBeDirectory();

  $composer = json_decode(File::get(base_path('composer.json')), true);
  expect($composer['autoload']['psr-4'])->toHaveKey('Modules\\');
  expect($composer['autoload']['psr-4']['Modules\\'])->toBe('modules/');
});

it('fails if modules directory already exists', function () {
  File::makeDirectory(base_path('modules'));

  $this->artisan('modules:install')
    ->expectsOutput('Directory modules/ already exists!')
    ->assertExitCode(0);
});
