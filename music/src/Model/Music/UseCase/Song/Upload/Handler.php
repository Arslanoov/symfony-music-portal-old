<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload;

use App\Model\Flusher;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\File;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use App\Model\Music\Entity\Song\SongRepository;
use App\Model\Music\Service\Uploader;
use DateTimeImmutable;

class Handler
{
    private Uploader $uploader;
    private SongRepository $songs;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param Uploader $uploader
     * @param SongRepository $songs
     * @param Flusher $flusher
     */
    public function __construct(Uploader $uploader, SongRepository $songs, Flusher $flusher)
    {
        $this->uploader = $uploader;
        $this->songs = $songs;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $fileInfo = $this->uploader->upload($command->file);

        $song = new Song(
            Id::next(),
            $command->artist,
            new Date(new DateTimeImmutable, new DateTimeImmutable),
            new Name($command->name),
            new File($fileInfo->path, $fileInfo->format, $fileInfo->size)
        );

        $this->songs->add($song);

        $this->flusher->flush();
    }
}