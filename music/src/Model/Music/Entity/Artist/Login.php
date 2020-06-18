<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Artist;

use Webmozart\Assert\Assert;

class Login
{
    private string $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        Assert::string($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Login $login): bool
    {
        return $this->getValue() === $login->getValue();
    }
}