<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Artist\Create;

use App\Model\Flusher;
use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\Entity\Artist\Id;
use App\Model\Music\Entity\Artist\Login;

class Handler
{
    private ArtistRepository $artists;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param ArtistRepository $artists
     * @param Flusher $flusher
     */
    public function __construct(ArtistRepository $artists, Flusher $flusher)
    {
        $this->artists = $artists;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $artist = new Artist(
            new Id($command->id),
            new Login($command->login)
        );

        $this->artists->add($artist);

        $this->flusher->flush();
    }
}