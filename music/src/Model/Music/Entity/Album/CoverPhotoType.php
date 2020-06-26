<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class CoverPhotoType extends StringType
{
    public const NAME = 'music_album_cover_photo';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof CoverPhoto ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new CoverPhoto($value) : null;
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