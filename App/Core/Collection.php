<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Interfaces\EntityInterface;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\AccessType;

/** @AccessType("public_method") */
class Collection extends Serializable implements EntityInterface
{
    /** @Expose */
    protected array $storage;

    public function __construct(array $storage = [])
    {
        $this->storage = $storage;
    }

    public function getStorage() :array
    {
        return $this->storage;
    }

    public function setStorage(array $storage) :self
    {
        $this->storage = $storage;

        return $this;
    }

    public function append($item)
    {
        $this->storage[] = $item;
    }
}