<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

use App\Core\Database\Seeder;

interface SeederInterface
{
    public static function seed() :Seeder;
}