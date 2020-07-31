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
        'sub',
        'email',
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

    public function persistNewUser(User $user)
    {
        $query = "
            INSERT INTO ". self::TABLE_NAME ."
            (
                uuid,
                sub,
                email,
                given_name,
                family_name,
                is_admin,
                created_at,
                updated_at
            )
            VALUES
            (
                :uuid,
                :sub,
                :email,
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
                ':uuid'        => $user->getUuid(),
                ':sub'         => $user->getSub(),
                ':email'       => $user->getEmail(),
                ':given_name'  => $user->getGivenName(),
                ':family_name' => $user->getFamilyName(),
                ':is_admin'    => (int) $user->getIsAdmin(),
            ]
        );
    }
}