<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Album;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Album\CoverPhoto;
use App\Model\Music\Entity\Album\Description;
use App\Model\Music\Entity\Album\Id;
use App\Model\Music\Entity\Album\ReleaseYear;
use App\Model\Music\Entity\Album\Slug;
use App\Model\Music\Entity\Album\Status;
use App\Model\Music\Entity\Album\Title;
use App\Model\Music\Entity\Album\Type;
use App\Model\Music\Entity\Artist\Artist;
use App\Tests\Builder\Music\ArtistBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $artist = $this->createArtist();

        $album = Album::new(
            $id = Id::next(),
            $artist,
            $title = new Title('Album title'),
            $slug = Slug::generate('Slug'),
            $createdDate = new DateTimeImmutable(),
            $year = new ReleaseYear(2020),
            $coverPhoto = new CoverPhoto('path'),
            $description = new Description('desc'),
            $type = Type::forAll()
        );

        $this->assertEquals($album->getId()->getValue(), $id->getValue());
        $this->assertEquals($album->getArtist(), $artist);

        $this->assertEquals($album->getSlug(), $slug);
        $this->assertEquals($album->getCreatedDate(), $createdDate);
        $this->assertTrue($album->getReleaseYear()->isEqual($year));
        $this->assertEquals($album->getDescription()->getValue(), $description->getValue());
        $this->assertEquals($album->getCoverPhoto()->getValue(), $coverPhoto->getValue());
        $this->assertTrue($album->getStatus()->isEqual(Status::moderated()));
        $this->assertTrue($album->getType()->isEqual(Type::forAll()));
    }

    private function createArtist(): Artist
    {
        return (new ArtistBuilder())
            ->build();
    }
}