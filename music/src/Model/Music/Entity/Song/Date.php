<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use DateTimeImmutable;

class Date
{
    private DateTimeImmutable $uploadDate;
    private DateTimeImmutable $updateDate;

    public function __construct(DateTimeImmutable $uploadDate, DateTimeImmutable $updateDate)
    {
        $this->uploadDate = $uploadDate;
        $this->updateDate = $updateDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUploadDate(): DateTimeImmutable
    {
        return $this->uploadDate;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdateDate(): DateTimeImmutable
    {
        return $this->updateDate;
    }

    public function isEqual(Date $date): bool
    {
        return
            $this->updateDate === $date->getUpdateDate() and
            $this->uploadDate === $date->getUploadDate();
    }
}