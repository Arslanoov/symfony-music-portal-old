<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Webmozart\Assert\Assert;

class Type
{
    private const FOR_ALL = 'For all';
    private const ONLY_ADULT = 'Only adult';

    public const TYPES = [
        'For all' => self::FOR_ALL,
        'Only adult' => self::ONLY_ADULT
    ];

    private string $value;

    /**
     * Type constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        Assert::oneOf($value, [
            self::FOR_ALL,
            self::ONLY_ADULT
        ]);
        $this->value = $value;
    }

    public static function forAll(): self
    {
        return new self(self::FOR_ALL);
    }

    public static function onlyAdult(): self
    {
        return new self(self::ONLY_ADULT);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Type $type): bool
    {
        return $this->value === $type->getValue();
    }
}