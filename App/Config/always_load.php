<?php

declare(strict_types=1);

use App\Actions\RootAction;
use App\Domain\Services\UserService;

return [
    RootAction::class => [
        UserService::class,
    ]
];