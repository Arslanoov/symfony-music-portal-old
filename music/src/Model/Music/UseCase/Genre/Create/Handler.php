<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Genre\Create;

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
        if ($this->genres->existsByName($name = new Name($command->name))) {
            throw new DomainException('Genre with that name already exists.');
        }

        $genre = new Genre(
            Id::next(),
            $name,
            Slug::generate($name->getValue()),
            0
        );

        $this->genres->add($genre);

        $this->flusher->flush();
    }
}