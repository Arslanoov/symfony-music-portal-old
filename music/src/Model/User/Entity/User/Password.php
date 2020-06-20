<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

class Password
{
    private string $value;

    /**
     * Password constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Password $password): bool
    {
        return $this->value === $password->getValue();
    }
}