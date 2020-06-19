<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Song;

use App\Tests\Builder\Music\ArtistBuilder;
use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\File;
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
            $name = new Name('Song name'),
            $file = new File('/path', 'mp3', '6m')
        );

        $this->assertEquals($song->getId(), $id);
        $this->assertEquals($song->getArtist(), $artist);
        $this->assertEquals($song->getDateInfo(), $date);
        $this->assertTrue($song->getDateInfo()->isEqual($date));
        $this->assertEquals($song->getName(), $name);
        $this->assertTrue($song->getStatus()->isEqual(Status::moderated()));
    }

    private function createArtist(): Artist
    {
        return (new ArtistBuilder())
            ->build();
    }
}