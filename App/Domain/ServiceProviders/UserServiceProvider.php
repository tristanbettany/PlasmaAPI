<?php

declare(strict_types=1);

namespace App\Domain\ServiceProviders;

use App\Domain\Gateways\UserGateway;
use App\Domain\Services\UserService;
use League\Container\ServiceProvider\AbstractServiceProvider;

final class UserServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        UserService::class,
    ];

    public function register()
    {
        $container = $this->getLeagueContainer();

        $container->add(UserGateway::class);

        $container->add(UserService::class)
            ->addArgument(UserGateway::class);
    }
}
