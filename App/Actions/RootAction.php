<?php

declare(strict_types=1);

namespace App\Actions;

use App\Core\Action;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RootAction extends Action
{
    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['PlasmaAPI']);
    }
}