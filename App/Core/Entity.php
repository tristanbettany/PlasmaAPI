<?php

declare(strict_types=1);

namespace App\Core;

use JMS\Serializer\Annotation\AccessType;
use App\Core\Interfaces\EntityInterface;

/** @AccessType("public_method") */
class Entity extends Serializable implements EntityInterface
{
}