<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use PHPUnit\Framework\Assert;

class Description
{
    public string $value;

    /**
     * Description constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::assertNotEmpty($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Description $description): bool
    {
        return $this->value === $description->getValue();
    }
}