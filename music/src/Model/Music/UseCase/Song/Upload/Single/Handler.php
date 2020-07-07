<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\Single;

use App\Model\Flusher;
use App\Model\Music\Entity\Genre\Id as GenreId;
use App\Model\Music\Entity\Album\AlbumRepository;
use App\Model\Music\Entity\Artist\ArtistRepository;
use App\Model\Music\Entity\Artist\Login;
use App\Model\Music\Entity\Genre\GenreRepository;
use App\Model\Music\Entity\Song\CoverPhoto;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\File;
use App\Model\Music\Entity\Song\Id as SongId;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use App\Model\Music\Entity\Song\SongRepository;
use DateTimeImmutable;
use Exception;

class Handler
{
    private SongRepository $songs;
    private GenreRepository $genres;
    private AlbumRepository $albums;
    private ArtistRepository $artists;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param SongRepository $songs
     * @param GenreRepository $genres
     * @param AlbumRepository $albums
     * @param ArtistRepository $artists
     * @param Flusher $flusher
     */
    public function __construct(SongRepository $songs, GenreRepository $genres, AlbumRepository $albums, ArtistRepository $artists, Flusher $flusher)
    {
        $this->songs = $songs;
        $this->genres = $genres;
        $this->albums = $albums;
        $this->artists = $artists;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        $genre = $this->genres->get(new GenreId($command->genre));
        $artist = $this->artists->getByLogin(new Login($command->artistLogin));

        $song = Song::single(
            SongId::next(),
            $artist,
            $genre,
            new Date(new DateTimeImmutable, new DateTimeImmutable),
            new Name($command->name),
            new File($command->file->getPath() . '/' . $command->coverPhoto->getName(), $command->file->getFormat(), (string) $command->file->getSize()),
            $command->coverPhoto ?
                new CoverPhoto($command->coverPhoto->getPath() . '/' . $command->coverPhoto->getName()) : null,
        );

        $this->songs->add($song);

        $this->flusher->flush();
    }
}