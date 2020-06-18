<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use DomainException;

class Name
{
    private string $value;

    /**
     * Name constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Name $name): bool
    {
        return $this->value === $name->getValue();
    }
}