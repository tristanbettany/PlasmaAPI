<?php

declare(strict_types=1);

namespace App\Actions;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class RootAction
{
    public function __invoke(ServerRequestInterface $request) :ResponseInterface
    {
        return new JsonResponse(['Root Action']);
    }
}