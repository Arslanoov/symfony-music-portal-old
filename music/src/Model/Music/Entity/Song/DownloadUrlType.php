<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\TextType;

class DownloadUrlType extends TextType
{
    public const NAME = 'music_song_download_url';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof DownloadUrl ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new DownloadUrl($value) : null;
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