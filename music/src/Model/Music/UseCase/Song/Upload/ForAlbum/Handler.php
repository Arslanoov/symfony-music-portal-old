<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\ForAlbum;

use App\Model\Flusher;
use App\Model\Music\Entity\Album\AlbumRepository;
use App\Model\Music\Entity\Album\Slug;
use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\Entity\Artist\Login;
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
    private AlbumRepository $albums;
    private ArtistRepository $artists;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param SongRepository $songs
     * @param AlbumRepository $albums
     * @param ArtistRepository $artists
     * @param Flusher $flusher
     */
    public function __construct(SongRepository $songs, AlbumRepository $albums, ArtistRepository $artists, Flusher $flusher)
    {
        $this->songs = $songs;
        $this->albums = $albums;
        $this->artists = $artists;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $artist = $this->artists->getByLogin(new Login($command->artistLogin));
        $album = $this->albums->getBySlug(new Slug($command->albumSlug));
        
        $song = Song::forAlbum(
            Id::next(),
            $artist,
            new Date(new DateTimeImmutable, new DateTimeImmutable),
            new Name($command->name),
            new File($command->file->getPath(), $command->file->getFormat(), (string) $command->file->getSize()),
            $album
        );

        $this->songs->add($song);

        $this->flusher->flush();
    }
}