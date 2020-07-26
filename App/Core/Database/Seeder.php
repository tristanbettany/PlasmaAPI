<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Interfaces\SeederInterface;
use App\Core\Kernel;
use Faker\Factory;

class Seeder implements SeederInterface
{
    protected ?string $service = null;
    protected int $quantity = 0;

    public function __construct()
    {
        $faker = Factory::create();
        for ($i = 0; $i < $this->quantity; $i++) {
            $service = Kernel::getContainer()->get($this->service);
            $this->define($faker, $service);
        }
    }

    public static function seed() :Seeder
    {
        return new static();
    }
}