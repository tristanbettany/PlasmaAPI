<?php

declare(strict_types = 1);

namespace App\Domain\Entities\Collections;

use App\Core\Collection;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\SerializedName;

final class Users extends Collection
{
    /**
     * @Expose
     * @SerializedName("users")
     */
    protected array $storage;
}