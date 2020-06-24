<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Avatar\Remove;

class Command
{
    public string $id;

    /**
     * Command constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }
}