<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

class Status
{
    public const STATUS_MODERATED = 'Moderated';
    public const STATUS_PUBLIC = 'Public';
    public const STATUS_ARCHIVED = 'Archived';

    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function moderated(): self
    {
        return new self(self::STATUS_MODERATED);
    }

    public static function public(): self
    {
        return new self(self::STATUS_PUBLIC);
    }

    public static function archived(): self
    {
        return new self(self::STATUS_ARCHIVED);
    }

    public function isModerate(): bool
    {
        return $this->value === self::STATUS_MODERATED;
    }

    public function isPublic(): bool
    {
        return $this->value === self::STATUS_PUBLIC;
    }

    public function isArchived(): bool
    {
        return $this->value === self::STATUS_ARCHIVED;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(Status $status): bool
    {
        return $this->getValue() === $status->getValue();
    }
}