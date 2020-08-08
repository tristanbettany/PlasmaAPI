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
        string $email,
        string $givenName,
        string $familyName,
        bool $isActive = true
    ) :User {
        return User::forge(
            $email,
            $givenName,
            $familyName,
            $isActive
        );
    }

    public function persistUser(User &$user) :void
    {
        if ($user->getId() === null) {
            $this->userGateway->persistNewUser($user);
        } else {
            $this->userGateway->persistExistingUser($user);
        }
    }

    public function getUsersBy(array $params) :Users
    {
        $usersData = $this->userGateway->getUsersBy($params);

        return $this->buildUsersCollection($usersData);
    }

    public function getAllUsers() :Users
    {
        $usersData = $this->userGateway->getAllUsers();

        return $this->buildUsersCollection($usersData);
    }

    private function buildUsersCollection(array $usersData) :Users
    {
        $users = new Users();
        foreach($usersData as $userData) {
            $user = User::fromArray($userData);
            $users->append($user);
        }

        return $users;
    }
}