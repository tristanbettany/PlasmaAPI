<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Interfaces\ConnectionInterface;
use PDO;

final class Connection implements ConnectionInterface
{
    private static PDO $connection;

    public function __construct()
    {
        $host         = $_ENV['MYSQL_HOST'];
        $port         = $_ENV['MYSQL_PORT'];
        $dbName       = $_ENV['MYSQL_DATABASE'];
        $userName     = $_ENV['MYSQL_USER'];
        $password     = $_ENV['MYSQL_PASSWORD'];

        $characterSet = empty($_ENV['MYSQL_CHARSET']) === false ? $_ENV['MYSQL_CHARSET'] : 'utf8';

        static::$connection = new PDO(
            'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbName . ';charset=' . $characterSet,
            $userName,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    }

    public static function getConnection() :PDO
    {
        return static::$connection;
    }
}