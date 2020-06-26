<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class TitleType extends StringType
{
    public const NAME = 'music_album_title';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Title ? $value->getValue() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Title($value) : null;
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