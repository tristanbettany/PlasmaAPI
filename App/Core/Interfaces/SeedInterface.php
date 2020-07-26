<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

use Faker\Generator;

interface SeedInterface
{
    public function define(
        Generator        $faker,
        ServiceInterface $service
    ) :void;
}