<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Album\Create;

use App\Model\Flusher;
use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Album\AlbumRepository;
use App\Model\Music\Entity\Album\CoverPhoto;
use App\Model\Music\Entity\Album\Description;
use App\Model\Music\Entity\Album\Id as AlbumId;
use App\Model\Music\Entity\Album\ReleaseYear;
use App\Model\Music\Entity\Album\Title;
use App\Model\Music\Entity\Album\Type;
use App\Model\Music\Entity\Artist\Id as ArtistId;
use App\Model\Music\Entity\Artist\ArtistRepository;
use DateTimeImmutable;

class Handler
{
    private AlbumRepository $albums;
    private ArtistRepository $artists;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param AlbumRepository $albums
     * @param ArtistRepository $artists
     * @param Flusher $flusher
     */
    public function __construct(AlbumRepository $albums, ArtistRepository $artists, Flusher $flusher)
    {
        $this->albums = $albums;
        $this->artists = $artists;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $artist = $this->artists->get(new ArtistId($command->artistId));

        $album = Album::new(
            AlbumId::next(),
            $artist,
            new Title($command->title),
            new DateTimeImmutable(),
            new ReleaseYear($command->releaseYear),
            $command->coverPhoto ?
                new CoverPhoto($command->coverPhoto->getPath() . '/' . $command->coverPhoto->getName()) : null,
            new Description($command->description),
            new Type($command->type)
        );

        $this->albums->add($album);

        $this->flusher->flush();
    }
}