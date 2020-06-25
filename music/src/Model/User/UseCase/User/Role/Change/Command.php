<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Role\Change;

class Command
{
    public string $id;
    public string $role;

    /**
     * Command constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}