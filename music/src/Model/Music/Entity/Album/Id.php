<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Exception;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Id
{
    private string $value;

    /**
     * Id constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);

        $this->value = $value;
    }

    /**
     * @throws Exception
     */
    public static function next(): self
    {
        return new self(Uuid::uuid1()->toString());
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Id $id): bool
    {
        return $this->value === $id->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}