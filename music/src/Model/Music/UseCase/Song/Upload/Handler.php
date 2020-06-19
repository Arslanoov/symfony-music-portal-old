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
use DateTimeImmutable;

class Handler
{
    private SongRepository $songs;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param SongRepository $songs
     * @param Flusher $flusher
     */
    public function __construct(SongRepository $songs, Flusher $flusher)
    {
        $this->songs = $songs;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $song = new Song(
            Id::next(),
            $command->artist,
            new Date(new DateTimeImmutable, new DateTimeImmutable),
            new Name($command->name),
            new File($command->file->getPath(), $command->file->getFormat(), (string) $command->file->getSize())
        );

        $this->songs->add($song);

        $this->flusher->flush();
    }
}