<?php

declare(strict_types=1);

namespace App\Tests\Builder\Music;

use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\File;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use DateTimeImmutable;

class SongBuilder
{
    private Id $id;
    private Artist $artist;
    private Date $date;
    private Name $name;
    private File $file;

    public function __construct()
    {
        $this->id = Id::next();
        $this->artist = (new ArtistBuilder())->build();
        $this->date = new Date(new DateTimeImmutable, new DateTimeImmutable);
        $this->name = new Name('Song name');
        $this->file = new File('/path', 'mp3', '6m');
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

    public function build(): Song
    {
        return new Song(
            $this->id,
            $this->artist,
            $this->date,
            $this->name,
            $this->file
        );
    }
}