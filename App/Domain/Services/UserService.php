<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Core\Interfaces\ServiceInterface;
use App\Domain\Entities\Collections\Users;
use App\Domain\Entities\User;
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
    ) :User {
        return new User(
            $uuid,
            $sub,
            $email,
            $givenName,
            $familyName,
            $isAdmin
        );
    }

    public function persistNewUser(User $user) :void
    {
        $this->userGateway->persistNewUser($user);
    }

    public function getUserBy(array $params) :?User
    {
        $userData = $this->userGateway->getUserBy($params);

        if (empty($userData) === true) {
            return null;
        }

        return User::forge($userData);
    }

    public function getAllUsers() :Users
    {
        $usersData = $this->userGateway->getAllUsers();

        $users = new Users();
        foreach($usersData as $userData) {
            $user = User::forge($userData);
            $users->append($user);
        }

        return $users;
    }
}