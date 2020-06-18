<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use DateTimeImmutable;

class Date
{
    public function __construct(DateTimeImmutable $uploadDate, DateTimeImmutable $updateTime)
    {
    }
}