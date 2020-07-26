<?php

declare(strict_types = 1);

namespace App\Core\Helpers;

final class Auth
{
    public static function hashPassword(string $password) :string
    {
        return password_hash($password, PASSWORD_BCRYPT) ;
    }
}