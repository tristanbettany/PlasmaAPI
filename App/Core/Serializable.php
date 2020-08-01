<?php

declare(strict_types=1);

namespace App\Core;

use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerBuilder;

/** @AccessType("public_method") */
class Serializable
{
    public function serialize() :object
    {
        $serializer = SerializerBuilder::create()
            ->setPropertyNamingStrategy(
                new SerializedNameAnnotationStrategy(
                    new IdenticalPropertyNamingStrategy()
                )
            )
            ->build();

        $json = $serializer->serialize($this, 'json');

        return json_decode($json);
    }
}