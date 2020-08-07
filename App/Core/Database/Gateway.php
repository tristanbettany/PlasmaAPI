<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Interfaces\GatewayInterface;
use PDO;
use PDOStatement;

class Gateway implements GatewayInterface
{
    protected PDO $connection;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
    }

    public function fetch(
        string $query,
        array  $bindings = []
    ) :?array {
        $preparedQuery = $this->prepareQuery(
            $query,
            $bindings
        );

        $result = $preparedQuery->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            return null;
        }

        return $result;
    }

    public function fetchAll(
        string $query,
        array  $bindings = []
    ) :array {
        $preparedQuery = $this->prepareQuery(
            $query,
            $bindings
        );

        return $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute(
        string $query,
        array  $bindings = []
    ) :void {
        $this->prepareQuery(
            $query,
            $bindings
        );
    }

    private function prepareQuery(
        string $query,
        array  $bindings = []
    ) :PDOStatement {
        $preparedQuery = $this->connection->prepare($query);
        $preparedQuery->execute($bindings);

        return $preparedQuery;
    }
}