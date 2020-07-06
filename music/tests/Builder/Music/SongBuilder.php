<?php

declare(strict_types=1);

namespace App\Tests\Builder\Music;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\DownloadStatus;
use App\Model\Music\Entity\Song\DownloadUrl;
use App\Model\Music\Entity\Song\File;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use App\Model\Music\Entity\Song\Status;
use DateTimeImmutable;

final class SongBuilder
{
    private Id $id;
    private Artist $artist;
    private ?Album $album;
    private Genre $genre;
    private Date $date;
    private Name $name;
    private File $file;
    private Status $status;
    private DownloadStatus $downloadStatus;
    private ?DownloadUrl $downloadUrl;
    private int $viewsCount;

    public function __construct()
    {
        $this->id = Id::next();
        $this->artist = (new ArtistBuilder())->build();
        $this->album = null;
        $this->genre = (new GenreBuilder())->build();
        $this->date = new Date(new DateTimeImmutable, new DateTimeImmutable);
        $this->name = new Name('Song name');
        $this->file = new File('/path', 'mp3', '6m');
        $this->status = Status::moderated();
        $this->downloadStatus = DownloadStatus::draft();
        $this->downloadUrl = null;
        $this->viewsCount = 0;
    }

    public function withId(Id $id): self
    {
        $builder = clone $this;
        $builder->id = $id;
        return $builder;
    }

    public function withArtist(Artist $artist): self
    {
        $builder = clone $this;
        $builder->artist = $artist;
        return $builder;
    }

    public function withGenre(Genre $genre): self
    {
        $builder = clone $this;
        $builder->genre = $genre;
        return $builder;
    }

    public function withDate(Date $date): self
    {
        $builder = clone $this;
        $builder->date = $date;
        return $builder;
    }

    public function withName(Name $name): self
    {
        $builder = clone $this;
        $builder->name = $name;
        return $builder;
    }

    public function withFile(File $file): self
    {
        $builder = clone $this;
        $builder->file = $file;
        return $builder;
    }

    public function withStatus(Status $status): self
    {
        $builder = clone $this;
        $builder->status = $status;
        return $builder;
    }

    public function withDownloadStatus(DownloadStatus $downloadStatus): self
    {
        $builder = clone $this;
        $builder->downloadStatus = $downloadStatus;
        return $builder;
    }


    public function withDownloadUrl(DownloadUrl $downloadUrl): self
    {
        $builder = clone $this;
        $builder->downloadUrl = $downloadUrl;
        return $builder;
    }

    public function withViewsCount(int $viewsCount): self
    {
        $builder = clone $this;
        $builder->viewsCount = $viewsCount;
        return $builder;
    }

    public function single(): Song
    {
        return new Song(
            $this->id,
            $this->artist,
            $this->genre,
            $this->date,
            $this->name,
            $this->file,
            $this->status,
            $this->downloadStatus,
            null,
            $this->downloadUrl,
            $this->viewsCount
        );
    }

    public function forAlbum(Album $album): Song
    {
        return new Song(
            $this->id,
            $this->artist,
            $this->genre,
            $this->date,
            $this->name,
            $this->file,
            $this->status,
            $this->downloadStatus,
            $album,
            $this->downloadUrl,
            $this->viewsCount
        );
    }
}