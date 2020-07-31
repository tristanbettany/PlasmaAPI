<?php

declare(strict_types=1);

use App\Actions\RootAction;
use App\Actions\UsersAction;
use App\Middleware\FirewallMiddleware;

return [
    'root' => [
        'http_methods' => ['GET'],
        'uri_pattern'  => '/',
        'action'       => RootAction::class,
        'middleware'   => [],
    ],
    'users' => [
        'http_methods' => ['GET'],
        'uri_pattern'  => '/users',
        'action'       => UsersAction::class,
        'middleware'   => [FirewallMiddleware::class],
    ],
];