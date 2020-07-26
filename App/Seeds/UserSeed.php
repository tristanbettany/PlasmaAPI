<?php

declare(strict_types=1);

namespace App\Seeds;

use App\Core\Database\Seeder;
use App\Core\Interfaces\SeedInterface;
use App\Core\Interfaces\ServiceInterface;
use App\Domain\Services\UserService;
use Faker\Generator;

final class UserSeed extends Seeder implements SeedInterface
{
    protected ?string $service = UserService::class;
    protected int $quantity = 10;

    public function define(
        Generator        $faker,
        ServiceInterface $service
    ) :void {
        /** @var UserService $service */
    }
}