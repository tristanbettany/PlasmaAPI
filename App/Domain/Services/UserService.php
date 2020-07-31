<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Core\Interfaces\ServiceInterface;
use App\Domain\Gateways\UserGateway;

final class UserService implements ServiceInterface
{
    private UserGateway $userGateway;

    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function createNewUser(
        string $uuid,
        string $sub,
        string $email,
        string $givenName,
        string $familyName,
        bool   $isAdmin
    ) {
        $this->userGateway->createNewUser(
            $uuid,
            $sub,
            $email,
            $givenName,
            $familyName,
            $isAdmin
        );
    }

    public function getAllUsers() :array
    {
        return $this->userGateway->getAllUsers();
    }
}