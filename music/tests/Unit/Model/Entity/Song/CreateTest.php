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
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $artist = $this->createArtist();

        $song = new Song(
            $id = Id::next(),
            $artist,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name(),
            $status = Status::public()
        );

        $this->assertEquals($song->getId()->getValue(), $song->getId()->getValue());
        $this->assertTrue($song->getDateInfo()->isEqual($date));
        $this->assertEquals($song->getName(), $name);
        $this->assertTrue($song->getStatus()->isEqual($status));
    }

    private function createArtist(): Artist
    {
        return new Artist(
            $id = ArtistId::next(),
            $login = new ArtistLogin('artist login')
        );
    }
}