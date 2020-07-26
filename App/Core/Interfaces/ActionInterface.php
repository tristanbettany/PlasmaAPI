<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ActionInterface
{
    public function get(ServerRequestInterface $request) :ResponseInterface;
    public function post(ServerRequestInterface $request) :ResponseInterface;
    public function put(ServerRequestInterface $request) :ResponseInterface;
    public function delete(ServerRequestInterface $request) :ResponseInterface;
}