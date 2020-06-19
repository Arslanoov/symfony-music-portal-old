<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Artist\Create;

class Command
{
    public string $id;
    public string $login;

    /**
     * Command constructor.
     * @param string $id
     * @param string $login
     */
    public function __construct(string $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }
}