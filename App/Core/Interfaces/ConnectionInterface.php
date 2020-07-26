<?php

declare(strict_types=1);

namespace App\Core\Interfaces;

use PDO;

interface ConnectionInterface
{
    public static function getConnection() :PDO;
}