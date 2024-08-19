<?php

use Froeschke\ModularLaravel\ModularLaravel;

return [
    'paths' => array_merge(ModularLaravel::defaultPaths() ,[]),

    'provider_path' => 'Providers',

    'service_provider_location' => 'Providers',

    'routes_file_location' => 'Routes/web.php',
];