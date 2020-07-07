<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Song\CoverPhoto;
use App\Model\Music\Entity\Song\Song;
use App\Tests\Builder\Music\SongBuilder;
use PHPUnit\Framework\TestCase;

class CoverPhotoTest extends TestCase
{
    public function testSuccess(): void
    {
        $song = $this->createSong();

        $this->assertNull($song->getCoverPhoto());

        $song->changeCoverPhoto($coverPhoto = new CoverPhoto('link'));

        $this->assertEquals($song->getCoverPhoto(), $coverPhoto);

        $song->removeCoverPhoto();

        $this->assertNull($song->getCoverPhoto());
    }

    private function createSong(): Song
    {
        return (new SongBuilder())
            ->single();
    }
}