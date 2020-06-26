<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Album;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Album\CoverPhoto;
use App\Model\Music\Entity\Album\Description;
use App\Model\Music\Entity\Album\Id;
use App\Model\Music\Entity\Album\ReleaseYear;
use App\Model\Music\Entity\Album\Status;
use App\Model\Music\Entity\Album\Title;
use App\Model\Music\Entity\Album\Type;
use App\Model\Music\Entity\Artist\Artist;
use App\Tests\Builder\Music\ArtistBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $artist = $this->createArtist();

        $album = Album::new(
            $id = Id::next(),
            $artist,
            $title = new Title('Album title'),
            $createdDate = new DateTimeImmutable(),
            $year = new ReleaseYear(2020),
            $coverPhoto = new CoverPhoto('path'),
            $description = new Description('desc'),
            $type = Type::forAll()
        );

        $this->assertEquals($album->getStatus(), Status::moderated());
        $this->assertTrue($album->getStatus()->isEqual(Status::moderated()));
        $this->assertTrue($album->getStatus()->isModerate());

        $this->assertNotEquals($album->getStatus(), Status::public());
        $this->assertFalse($album->getStatus()->isEqual(Status::public()));
        $this->assertFalse($album->getStatus()->isPublic());

        $this->assertNotEquals($album->getStatus(), Status::archived());
        $this->assertFalse($album->getStatus()->isEqual(Status::archived()));
        $this->assertFalse($album->getStatus()->isArchived());

        $album->makePublic();

        $this->assertEquals($album->getStatus(), Status::public());
        $this->assertTrue($album->getStatus()->isEqual(Status::public()));
        $this->assertTrue($album->getStatus()->isPublic());

        $this->assertNotEquals($album->getStatus(), Status::moderated());
        $this->assertFalse($album->getStatus()->isEqual(Status::moderated()));
        $this->assertFalse($album->getStatus()->isModerate());

        $this->assertNotEquals($album->getStatus(), Status::archived());
        $this->assertFalse($album->getStatus()->isEqual(Status::archived()));
        $this->assertFalse($album->getStatus()->isArchived());

        $album->archive();

        $this->assertEquals($album->getStatus(), Status::archived());
        $this->assertTrue($album->getStatus()->isEqual(Status::archived()));
        $this->assertTrue($album->getStatus()->isArchived());

        $this->assertNotEquals($album->getStatus(), Status::moderated());
        $this->assertFalse($album->getStatus()->isEqual(Status::moderated()));
        $this->assertFalse($album->getStatus()->isModerate());

        $this->assertNotEquals($album->getStatus(), Status::public());
        $this->assertFalse($album->getStatus()->isEqual(Status::public()));
        $this->assertFalse($album->getStatus()->isPublic());
    }

    private function createArtist(): Artist
    {
        return (new ArtistBuilder())
            ->build();
    }
}