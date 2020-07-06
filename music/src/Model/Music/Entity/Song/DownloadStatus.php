<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use Webmozart\Assert\Assert;

final class DownloadStatus
{
    private const STATUS_PUBLIC = 'Public';
    private const STATUS_DRAFT = 'Draft';

    private string $value;

    /**
     * DownloadStatus constructor.
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

    public static function public(): self
    {
        return new self(self::STATUS_PUBLIC);
    }

    public static function draft(): self
    {
        return new self(self::STATUS_DRAFT);
    }

    public function isPublic(): bool
    {
        return $this->value === self::STATUS_PUBLIC;
    }

    public function isDraft(): bool
    {
        return $this->value === self::STATUS_DRAFT;
    }

    public function isEqual(DownloadStatus $status): bool
    {
        return $this->value === $status->getValue();
    }
}