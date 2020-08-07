<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

interface GatewayInterface
{
    public function fetch(
        string $query,
        array  $bindings = []
    ) :?array;

    public function fetchAll(
        string $query,
        array  $bindings = []
    ) :array;

    public function execute(
        string $query,
        array  $bindings = []
    ) :void;
}