<?php

declare(strict_types=1);

namespace App\Actions;

use App\Core\Action;
use App\Domain\Services\UserService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class UsersAction extends Action
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        $users = $this->userService->getAllUsers();

        return new JsonResponse($users->serialize()->users);
    }
}