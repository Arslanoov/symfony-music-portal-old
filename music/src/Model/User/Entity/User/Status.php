<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

class Status
{
    public const STATUS_WAIT = 'Wait';
    public const STATUS_ACTIVE = 'Active';
    public const STATUS_BANNED = 'Banned';

    private string $value;

    /**
     * Status constructor.
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

    public static function wait(): self
    {
        return new self(self::STATUS_WAIT);
    }

    public static function active(): self
    {
        return new self(self::STATUS_ACTIVE);
    }

    public static function banned(): self
    {
        return new self(self::STATUS_BANNED);
    }

    public function isWait(): bool
    {
        return $this->value === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
        return $this->value === self::STATUS_ACTIVE;
    }

    public function isBanned(): bool
    {
        return $this->value === self::STATUS_BANNED;
    }
}