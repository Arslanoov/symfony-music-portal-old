<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Webmozart\Assert\Assert;

class ReleaseYear
{
    public int $value;

    /**
     * ReleaseYear constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::lessThan($value, 2100);
        Assert::greaterThan($value, 1500);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    public function isEarlierThan(ReleaseYear $year): bool
    {
        return $this->value < $year->getValue();
    }

    public function isOlderThan(ReleaseYear $year): bool
    {
        return $this->value > $year->getValue();
    }

    public function isEqual(ReleaseYear $year): bool
    {
        return $this->value === $year->getValue();
    }
}