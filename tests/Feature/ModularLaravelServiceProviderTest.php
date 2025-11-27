<?php

it('publishes config file', function () {
  $this->artisan('vendor:publish', [
    '--provider' => 'Froeschke\ModularLaravel\ModularLaravelServiceProvider',
  ])->assertExitCode(0);

  expect(config_path('modules.php'))->toBeFile();
});

it('merges config', function () {
  expect(config('modules'))->not->toBeNull();
});
