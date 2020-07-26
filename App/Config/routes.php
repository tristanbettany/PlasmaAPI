<?php

declare(strict_types=1);

use App\Actions\RootAction;
use App\Middleware\AuthMiddleware;

return [
    'root' => [
        'http_methods' => ['GET'],
        'uri_pattern'  => '/',
        'action'       => RootAction::class,
        'middleware'   => [AuthMiddleware::class],
    ],
];