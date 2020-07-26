<?php

declare(strict_types=1);

return [
    'routes' => require_once __DIR__ . '/routes.php',
    'always_load' => require_once __DIR__ . '/always_load.php',
    'service_providers' => require_once __DIR__ . '/service_providers.php',
    'commands' => require_once __DIR__ . '/commands.php',
    'seeds' => require_once __DIR__ . '/seeds.php',
];