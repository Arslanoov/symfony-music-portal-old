<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use PHPUnit\Framework\Assert;

class ReleaseYear
{
    public int $value;

    /**
     * ReleaseYear constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        Assert::assertLessThan(2100, $value);
        Assert::assertGreaterThan(1500, $value);
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
        return $this->value < $year;
    }

    public function isOlderThan(ReleaseYear $year): bool
    {
        return $this->value > $year;
    }

    public function isEqual(ReleaseYear $year): bool
    {
        return $this->value === $year->getValue();
    }
}