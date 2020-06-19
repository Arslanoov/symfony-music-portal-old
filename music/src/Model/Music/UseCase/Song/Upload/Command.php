<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload;

use App\Model\Music\Entity\Artist\Artist;

class Command
{
    public Artist $artist;
    public ?File $file = null;
    public ?string $name = null;

    /**
     * Command constructor.
     * @param Artist $artist
     */
    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }
}