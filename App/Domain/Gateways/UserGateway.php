<?php

declare(strict_types = 1);

namespace App\Domain\Gateways;

use App\Core\Database\Gateway;

final class UserGateway extends Gateway
{
    /** @var string */
    const TABLE_NAME = 'users';
    /** @var array */
    const COLS = [
        'id',
        'uuid',
        'email',
        'hash',
        'given_name',
        'family_name',
        'is_admin',
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

    public function getUserByEmail(
        string $email,
        bool   $isActive = true
    ) :array {
        $query = "
            SELECT 
                ". implode(',', self::COLS) ."
            FROM ". self::TABLE_NAME ."
            WHERE is_active = :is_active
            AND email = :email
        ";

        $result = $this->fetch(
            $query,
            [
                ':email'     => $email,
                ':is_active' => (int) $isActive,
            ]
        );

        if (empty($result) === true) {
            return [];
        }

        return $result;
    }

    public function createNewUser(
        string $uuid,
        string $email,
        string $hash,
        string $givenName,
        string $familyName,
        bool   $isAdmin
    ) {
        $query = "
            INSERT INTO ". self::TABLE_NAME ."
            (
                uuid,
                email,
                hash,
                given_name,
                family_name,
                is_admin,
                created_at,
                updated_at
            )
            VALUES
            (
                :uuid,
                :email,
                :hash,
                :given_name,
                :family_name,
                :is_admin,
                NOW(),
                NOW()
            )
        ";

        $this->execute(
            $query,
            [
                ':uuid'        => $uuid,
                ':email'       => $email,
                ':hash'        => $hash,
                ':given_name'  => $givenName,
                ':family_name' => $familyName,
                ':is_admin'    => (int) $isAdmin,
            ]
        );
    }
}