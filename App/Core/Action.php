<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Interfaces\ActionInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Action implements ActionInterface
{
    public function __invoke(ServerRequestInterface $request) :ResponseInterface
    {
        switch ($request->getMethod()) {
            case 'POST':
                return $this->post($request);
                break;
            case 'PUT':
                return $this->put($request);
                break;
            case 'DELETE':
                return $this->delete($request);
                break;
            case 'GET':
            default:
                return $this->get($request);
                break;
        }
    }

    public function get(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['GET']);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['POST']);
    }

    public function put(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['PUT']);
    }

    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(['DELETE']);
    }
}