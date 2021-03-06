<?php

declare(strict_types = 1);

namespace App\Domain\Gateways;

use App\Core\Database\Gateway;
use App\Domain\Entities\User;

final class UserGateway extends Gateway
{
    /** @var string */
    const TABLE_NAME = 'users';
    /** @var array */
    const COLS = [
        'id',
        'uuid',
        'email',
        'given_name',
        'family_name',
        'is_active',
        'created_at',
        'updated_at',
    ];

    public function getAllUsers() :array
    {
        $query = "
            SELECT 
                ". implode(',', self::COLS) ."
            FROM ". self::TABLE_NAME ."
        ";

        $result = $this->fetchAll(
            $query,
            []
        );

        if (empty($result) === true) {
            return [];
        }

        return $result;
    }

    public function getUsersBy(array $params) :array {
        $whereQuery = '';
        $i = 0;
        foreach ($params as $param => $value) {
            if ($i === 0) {
                $whereQuery .= ' WHERE ' . str_replace(':','', $param) . ' = ' . $param;
            } else {
                $whereQuery .= ' AND ' . str_replace(':','', $param) . ' = ' . $param;
            }

            $i++;
        }

        $query = "
            SELECT 
                ". implode(',', self::COLS) ."
            FROM ". self::TABLE_NAME ." ".
            $whereQuery
        ;

        $result = $this->fetchAll(
            $query,
            $params
        );

        if (empty($result) === true) {
            return [];
        }

        return $result;
    }

    public function persistNewUser(User &$user)
    {
        $query = "
            INSERT INTO ". self::TABLE_NAME ."
            (
                uuid,
                email,
                given_name,
                family_name,
                created_at,
                updated_at
            )
            VALUES
            (
                :uuid,
                :email,
                :given_name,
                :family_name,
                NOW(),
                NOW()
            )
        ";

        $statement = $this->execute(
            $query,
            [
                ':uuid'        => $user->getUuid(),
                ':email'       => $user->getEmail(),
                ':given_name'  => $user->getGivenName(),
                ':family_name' => $user->getFamilyName(),
            ]
        );

        $user->setId((int) $this->connection->lastInsertId());
    }

    public function persistExistingUser(User &$user)
    {
        $query = "
            UPDATE ". self::TABLE_NAME ."
            SET
                email = :email,
                given_name = :given_name,
                family_name = :family_name,
                is_active = :is_active,
                updated_at = NOW()
        ";

        $this->execute(
            $query,
            [
                ':email'       => $user->getEmail(),
                ':given_name'  => $user->getGivenName(),
                ':family_name' => $user->getFamilyName(),
                ':is_active'    => (int) $user->getIsActive(),
            ]
        );
    }
}