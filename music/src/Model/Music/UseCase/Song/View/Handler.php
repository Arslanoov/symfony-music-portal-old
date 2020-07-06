<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\View;

use App\Model\Flusher;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\SongRepository;

final class Handler
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
        $artist = $this->songs->get(new Id($command->id));

        $artist->view();

        $this->flusher->flush();
    }
}