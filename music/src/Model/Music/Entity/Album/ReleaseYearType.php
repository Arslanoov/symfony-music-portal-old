<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;

class ReleaseYearType extends IntegerType
{
    public const NAME = 'music_album_release_year';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof ReleaseYear ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new ReleaseYear($value) : null;
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