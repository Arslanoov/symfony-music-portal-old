<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use InvalidArgumentException;
use Webmozart\Assert\Assert;

class Email
{
    public string $value;

    /**
     * Email constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Incorrect Email.');
        }

        $this->value = mb_strtolower($value);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Email $email): bool
    {
        return $this->value === $email->getValue();
    }
}