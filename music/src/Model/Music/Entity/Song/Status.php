<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

class Status
{
    public const STATUS_MODERATED = 'Moderated';
    public const STATUS_PUBLIC = 'Public';
    public const STATUS_ARCHIVED = 'Archived';

    private function __construct(string $status)
    {
    }

    public static function public(): self
    {
        return new self(self::STATUS_PUBLIC);
    }
}