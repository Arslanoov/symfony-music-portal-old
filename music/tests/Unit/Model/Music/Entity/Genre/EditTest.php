<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Genre;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;
use PHPUnit\Framework\TestCase;

class EditTest extends TestCase
{
    public function testSuccess(): void
    {
        $genre = new Genre(
            $id = Id::next(),
            $name = new Name('Pop'),
            Slug::generate('Pop'),
            $songsCount = 0
        );

        $this->assertEquals($genre->getId(), $id);
        $this->assertEquals($genre->getName(), $name);
        $this->assertEquals($genre->getSlug()->getValue(), 'pop');
        $this->assertEquals($genre->getSongsCount(), 0);

        $genre->edit($newName = new Name('Hip-Hop'));

        $this->assertEquals($genre->getName(), $newName);
        $this->assertEquals($genre->getSlug()->getValue(), 'hip-hop');
    }
}