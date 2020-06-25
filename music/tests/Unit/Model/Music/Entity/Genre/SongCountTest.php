<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Genre;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;
use PHPUnit\Framework\TestCase;

class SongCountTest extends TestCase
{
    public function testSuccess(): void
    {
        $genre = new Genre(
            $id = Id::next(),
            $name = new Name('Pop'),
            $slug = Slug::generate('Slug Test'),
            $songsCount = 5
        );

        $this->assertEquals($genre->getSongsCount(), $songsCount);

        $genre->reduceSongCount();

        $this->assertEquals($genre->getSongsCount(), $songsCount - 1);

        $genre->increaseSongCount();

        $this->assertEquals($genre->getSongsCount(), $songsCount);
    }

    public function testLessThanZero(): void
    {
        $genre = new Genre(
            $id = Id::next(),
            $name = new Name('Pop'),
            $slug = Slug::generate('Slug Test'),
            $songsCount = 0
        );

        $this->assertEquals($genre->getSongsCount(), $songsCount);

        $this->expectExceptionMessage('Unknown error.');

        $genre->reduceSongCount();
    }
}