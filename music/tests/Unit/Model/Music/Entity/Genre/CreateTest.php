<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Genre;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $genre = new Genre(
            $id = Id::next(),
            $name = new Name('Pop'),
            $slug = Slug::generate('Slug Test'),
            $songsCount = 0
        );

        $this->assertEquals($genre->getId(), $id);
        $this->assertEquals($genre->getName(), $name);
        $this->assertEquals($genre->getSlug()->getValue(), 'slug-test');
        $this->assertEquals($genre->getSongsCount(), 0);
    }

    public function testEmptyName(): void
    {
        $this->expectExceptionMessage('Expected a non-empty value. Got: ""');

        $genre = new Genre(
            $id = Id::next(),
            $name = new Name(''),
            Slug::generate('Slug Test'),
            $songsCount = 0
        );
    }
}