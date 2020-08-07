<?php

declare(strict_types=1);

namespace App\Core;

use JMS\Serializer\Annotation\AccessType;
use App\Core\Interfaces\EntityInterface;

/** @AccessType("public_method") */
class Entity extends Serializable implements EntityInterface
{
    public function __construct()
    {
        $callstack = debug_backtrace();
        if (empty($callstack[2]['function']) === false) {
            if ($callstack[2]['function'] !== 'fromArray'
                && $callstack[2]['function'] !== 'forge') {
                throw new \LogicException('To create an Entity call ::forge or ::fromArray');
            }
        }
    }
}