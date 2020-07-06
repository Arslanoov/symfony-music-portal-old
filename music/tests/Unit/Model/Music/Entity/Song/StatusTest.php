<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Song\Song;
use App\Tests\Builder\Music\SongBuilder;
use App\Model\Music\Entity\Song\Name;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    public function testChange(): void
    {
        $song = $this->createSong();

        $this->assertTrue($song->getStatus()->isModerate());

        $song->makePublic();

        $this->assertTrue($song->getStatus()->isPublic());

        $song->archive();

        $this->assertTrue($song->getStatus()->isArchived());
    }

    public function testSamePublic(): void
    {
        $song = $this->createSong();

        $this->assertTrue($song->getStatus()->isModerate());

        $song->makePublic();

        $this->assertTrue($song->getStatus()->isPublic());

        $this->expectExceptionMessage('Status is already same.');
        $song->makePublic();
    }

    public function testSameArchived(): void
    {
        $song = $this->createSong();

        $this->assertTrue($song->getStatus()->isModerate());

        $song->archive();

        $this->assertTrue($song->getStatus()->isArchived());

        $this->expectExceptionMessage('Status is already same.');

        $song->archive();
    }

    private function createSong(): Song
    {
        return (new SongBuilder())
            ->single();
    }
}