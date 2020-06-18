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
use App\Model\Music\Entity\Song\Status;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
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

        $this->assertTrue($song->getStatus()->isModerate());

        $song->makePublic();

        $this->assertTrue($song->getStatus()->isPublic());

        $song->archive();

        $this->assertTrue($song->getStatus()->isArchived());
    }

    public function testSamePublic(): void
    {
        $artist = $this->createArtist();

        $song = new Song(
            $id = Id::next(),
            $artist,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name('Song name')
        );

        $this->assertTrue($song->getStatus()->isModerate());

        $song->makePublic();

        $this->assertTrue($song->getStatus()->isPublic());

        $this->expectExceptionMessage('Status is already same.');
        $song->makePublic();
    }

    public function testSameArchived(): void
    {
        $artist = $this->createArtist();

        $song = new Song(
            $id = Id::next(),
            $artist,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name('Song name')
        );

        $this->assertTrue($song->getStatus()->isModerate());

        $song->makePublic();

        $this->assertTrue($song->getStatus()->isPublic());

        $song->archive();

        $this->assertTrue($song->getStatus()->isArchived());

        $this->expectExceptionMessage('Status is already same.');
        $song->archive();
    }

    private function createArtist(): Artist
    {
        return new Artist(
            $id = ArtistId::next(),
            $login = new ArtistLogin('artist login')
        );
    }
}