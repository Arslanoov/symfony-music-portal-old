<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\SignUp\ByEmail\Confirm\ByToken;

class Command
{
    public string $token;

    /**
     * Command constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }
}