<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

final class DownloadStatusType extends TextType
{
    public const NAME = 'music_song_download_status';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DownloadStatus ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new DownloadStatus($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) : bool
    {
        return true;
    }
}