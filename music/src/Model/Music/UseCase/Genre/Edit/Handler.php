<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Genre\Edit;

use App\Model\Flusher;
use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\GenreRepository;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;
use DomainException;

class Handler
{
    private GenreRepository $genres;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param GenreRepository $genres
     * @param Flusher $flusher
     */
    public function __construct(GenreRepository $genres, Flusher $flusher)
    {
        $this->genres = $genres;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $genre = $this->genres->get(new Id($command->id));

        $genre->edit(
            new Name($command->name)
        );

        $this->flusher->flush();
    }
}