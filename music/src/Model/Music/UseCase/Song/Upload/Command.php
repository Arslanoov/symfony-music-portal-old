<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload;

use App\Model\Music\Entity\Artist\Artist;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Command
{
    public Artist $artist;
    public UploadedFile $file;
    public ?string $name = null;

    /**
     * Command constructor.
     * @param Artist $artist
     * @param UploadedFile $file
     */
    public function __construct(Artist $artist, UploadedFile $file)
    {
        $this->artist = $artist;
        $this->file = $file;
    }
}