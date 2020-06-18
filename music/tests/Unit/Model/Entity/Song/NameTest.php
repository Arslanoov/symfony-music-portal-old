<?php

declare(strict_types=1);

namespace App\Unit\Model\Entity\Song;

use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Artist\Id as ArtistId;
use App\Model\Music\Entity\Artist\Login as ArtistLogin;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class NameTest extends TestCase
{
    public function testChange(): void
    {
        $artist = $this->createArtist();

        $song = new Song(
            $id = Id::next(),
            $artist,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name('Song name')
        );

        $this->assertEquals($song->getName(), $name);

        $song->changeName($newName = new Name('New song name'));

        $this->assertNotEquals($song->getName(), $name);
        $this->assertEquals($song->getName(), $newName);
    }

    public function testSame(): void
    {
        $artist = $this->createArtist();

        $song = new Song(
            $id = Id::next(),
            $artist,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name('Song name')
        );

        $this->assertEquals($song->getName(), $name);

        $this->expectExceptionMessage('Name is already same.');
        $song->changeName($newName = new Name('Song name'));
    }

    private function createArtist(): Artist
    {
        return new Artist(
            $id = ArtistId::next(),
            $login = new ArtistLogin('artist login')
        );
    }
}