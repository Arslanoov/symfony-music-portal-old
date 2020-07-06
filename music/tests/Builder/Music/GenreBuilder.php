<?php

declare(strict_types=1);

namespace App\Tests\Builder\Music;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;

final class GenreBuilder
{
    private Id $id;
    private Name $name;
    private Slug $slug;
    private int $songsCount;

    public function __construct()
    {
        $this->id = Id::next();
        $this->name = new Name('Genre name');
        $this->slug = Slug::generate('Genre name');
        $this->songsCount = 0;
    }

    public function withId(Id $id): self
    {
        $builder = clone $this;
        $builder->id = $id;
        return $builder;
    }

    public function withName(Name $name): self
    {
        $builder = clone $this;
        $builder->name = $name;
        return $builder;
    }

    public function withSlug(Slug $slug): self
    {
        $builder = clone $this;
        $builder->slug = $slug;
        return $builder;
    }

    public function withSongsCount(int $songsCount): self
    {
        $builder = clone $this;
        $builder->songsCount = $songsCount;
        return $builder;
    }

    public function build(): Genre
    {
        return new Genre(
            $this->id,
            $this->name,
            $this->slug,
            $this->songsCount
        );
    }
}