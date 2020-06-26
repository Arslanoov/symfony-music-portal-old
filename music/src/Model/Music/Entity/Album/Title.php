<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Webmozart\Assert\Assert;

class Title
{
    private string $value;

    /**
     * Title constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Title $title): bool
    {
        return $this->value === $title->getValue();
    }
}