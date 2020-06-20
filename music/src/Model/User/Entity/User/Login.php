<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use DomainException;

class Login
{
    public string $value;

    /**
     * Login constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (empty($value)){
            throw new DomainException('Empty Login.');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Login $login): bool
    {
        return $this->value === $login->getValue();
    }
}