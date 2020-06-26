<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Album;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Album\CoverPhoto;
use App\Model\Music\Entity\Album\Description;
use App\Model\Music\Entity\Album\Id;
use App\Model\Music\Entity\Album\ReleaseYear;
use App\Model\Music\Entity\Album\Slug;
use App\Model\Music\Entity\Album\Title;
use App\Model\Music\Entity\Album\Type;
use App\Model\Music\Entity\Artist\Artist;
use App\Tests\Builder\Music\ArtistBuilder;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ReleaseYearTest extends TestCase
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

        $olderReleaseYear = new ReleaseYear(2025);
        $earlierReleaseYear = new ReleaseYear(2007);

        $this->assertTrue($album->getReleaseYear()->isEarlierThan($olderReleaseYear));
        $this->assertFalse($album->getReleaseYear()->isEarlierThan($earlierReleaseYear));

        $this->assertTrue($album->getReleaseYear()->isOlderThan($earlierReleaseYear));
        $this->assertFalse($album->getReleaseYear()->isOlderThan($olderReleaseYear));
    }

    private function createArtist(): Artist
    {
        return (new ArtistBuilder())
            ->build();
    }
}