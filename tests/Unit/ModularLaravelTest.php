<?php

use Froeschke\ModularLaravel\ModularLaravel;

it('returns default paths', function () {
  $paths = ModularLaravel::defaultPaths();

  expect($paths)->toBeArray()
    ->toContain('Application')
    ->toContain('Domain')
    ->toContain('Infrastructure')
    ->toContain('Tests');
});

it('excludes specified paths', function () {
  $paths = ModularLaravel::defaultPaths(['Tests']);

  expect($paths)->toBeArray()
    ->toContain('Application')
    ->not->toContain('Tests');
});
