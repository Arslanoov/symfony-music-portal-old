<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Song\DownloadStatus;
use App\Model\Music\Entity\Song\DownloadUrl;
use App\Model\Music\Entity\Song\Song;
use App\Tests\Builder\Music\SongBuilder;
use PHPUnit\Framework\TestCase;

class DownloadUrlTest extends TestCase
{
    public function testChangeSuccess(): void
    {
        $song = $this->createPublicSong();

        $song->changeDownloadUrl($url = new DownloadUrl('url'));

        $this->assertEquals($song->getDownloadUrl(), $url);
    }

    public function testChangeDraft(): void
    {
        $song = $this->createSong();

        $this->expectExceptionMessage('Song download forbidden.');

        $song->changeDownloadUrl(new DownloadUrl('url'));
    }

    private function createSong(): Song
    {
        return (new SongBuilder())
            ->single();
    }

    private function createPublicSong(): Song
    {
        return (new SongBuilder())
            ->withDownloadStatus(DownloadStatus::public())
            ->single();
    }
}