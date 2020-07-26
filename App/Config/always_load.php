<?php

declare(strict_types=1);

use App\Actions\UsersAction;
use App\Domain\Services\UserService;

return [
    UsersAction::class => [
        UserService::class,
    ]
];