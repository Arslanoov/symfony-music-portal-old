<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Song\DownloadStatus;
use App\Tests\Builder\Music\ArtistBuilder;
use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Song\Date;
use App\Model\Music\Entity\Song\File;
use App\Model\Music\Entity\Song\Id;
use App\Model\Music\Entity\Song\Name;
use App\Model\Music\Entity\Song\Song;
use App\Model\Music\Entity\Song\Status;
use App\Tests\Builder\Music\GenreBuilder;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CreateTest extends TestCase
{
    public function testSingle(): void
    {
        $artist = $this->createArtist();
        $genre = $this->createGenre();

        $song = Song::single(
            $id = Id::next(),
            $artist,
            $genre,
            $date = new Date(new DateTimeImmutable, new DateTimeImmutable),
            $name = new Name('Song name'),
            $file = new File('/path', 'mp3', '6m')
        );

        $this->assertEquals($song->getId(), $id);
        $this->assertEquals($song->getArtist(), $artist);
        $this->assertEquals($song->getGenre(), $genre);
        $this->assertEquals($song->getDateInfo(), $date);
        $this->assertTrue($song->getDateInfo()->isEqual($date));
        $this->assertEquals($song->getName(), $name);
        $this->assertTrue($song->getStatus()->isEqual(Status::moderated()));
        $this->assertTrue($song->getDownloadStatus()->isDraft());
        $this->assertFalse($song->getDownloadStatus()->isPublic());
        $this->assertTrue($song->getDownloadStatus()->isEqual(DownloadStatus::draft()));
        $this->assertFalse($song->getDownloadStatus()->isEqual(DownloadStatus::public()));
        $this->assertEquals($song->getDownloadStatus(), DownloadStatus::draft());
        $this->assertNull($song->getDownloadUrl());
    }

    private function createArtist(): Artist
    {
        return (new ArtistBuilder())
            ->build();
    }

    private function createGenre(): Genre
    {
        return (new GenreBuilder())
            ->build();
    }
}