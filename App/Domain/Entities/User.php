<?php

declare(strict_types = 1);

namespace App\Domain\Entities;

use App\Core\Entity;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;

/** @AccessType("public_method") */
final class User extends Entity
{
    /** @Expose */
    private ?int $id;
    /** @Expose */
    private string $uuid;
    /** @Expose */
    private string $sub;
    /** @Expose */
    private string $email;
    /** @Expose */
    private string $givenName;
    /** @Expose */
    private string $familyName;
    /** @Expose */
    private bool $isAdmin;
    /** @Expose */
    private bool $isActive;

    public function __construct(
        string $uuid,
        string $sub,
        string $email,
        string $givenName,
        string $familyName,
        bool $isAdmin = false,
        bool $isActive = true,
        int $id = null
    ) {
        parent::__construct();

        $this->uuid = $uuid;
        $this->sub = $sub;
        $this->email = $email;
        $this->givenName = $givenName;
        $this->familyName = $familyName;
        $this->isAdmin = $isAdmin;
        $this->isActive = $isActive;
        $this->id = $id;
    }

    public static function forge(
        string $sub,
        string $email,
        string $givenName,
        string $familyName,
        bool $isAdmin = false,
        bool $isActive = true
    ) :User {
        /**
         * Used to create a brand new user in memory
         * Generating an ID for uuid
         */
        return new self(
            uniqid(),
            $sub,
            $email,
            $givenName,
            $familyName,
            $isAdmin,
            $isActive
        );
    }

    public static function fromArray(array $userData) :User
    {
        /**
         * Used to create a User from a row in the database
         */
        return new self(
            $userData['uuid'],
            $userData['sub'],
            $userData['email'],
            $userData['given_name'],
            $userData['family_name'],
            (bool) $userData['is_admin'],
            (bool) $userData['is_active'],
            $userData['id']
        );
    }

    public function getId() :?int
    {
        return $this->id;
    }

    public function setId(?int $id) :User
    {
        $this->id = $id;

        return $this;
    }

    public function getUuid() :string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid) :User
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getSub() :string
    {
        return $this->sub;
    }

    public function setSub(string $sub) :User
    {
        $this->sub = $sub;

        return $this;
    }

    public function getEmail() :string
    {
        return $this->email;
    }

    public function setEmail(string $email) :User
    {
        $this->email = $email;

        return $this;
    }

    public function getGivenName() :string
    {
        return $this->givenName;
    }

    public function setGivenName(string $givenName) :User
    {
        $this->givenName = $givenName;

        return $this;
    }

    public function getFamilyName() :string
    {
        return $this->familyName;
    }

    public function setFamilyName(string $familyName) :User
    {
        $this->familyName = $familyName;

        return $this;
    }

    public function getIsAdmin() :bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin) :User
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getIsActive() :bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive) :User
    {
        $this->isActive = $isActive;

        return $this;
    }
}