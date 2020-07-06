<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Song\DownloadStatus;
use App\Model\Music\Entity\Song\DownloadUrl;
use App\Model\Music\Entity\Song\Song;
use App\Tests\Builder\Music\SongBuilder;
use PHPUnit\Framework\TestCase;

class DownloadStatusTest extends TestCase
{
    public function testSuccess(): void
    {
        $song = $this->createSong();

        $this->assertTrue($song->getDownloadStatus()->isDraft());
        $this->assertNull($song->getDownloadUrl());

        $song->openPublicDownload($url = new DownloadUrl('url'));

        $this->assertTrue($song->getDownloadStatus()->isPublic());
        $this->assertEquals($song->getDownloadUrl(), $url);

        $song->closePublicDownload();

        $this->assertTrue($song->getDownloadStatus()->isDraft());
        $this->assertNull($song->getDownloadUrl());
    }

    public function testAlreadyPublic(): void
    {
        $song = $this->createPublicSong();

        $this->expectExceptionMessage('Song download is already public.');

        $song->openPublicDownload(new DownloadUrl('url'));
    }

    public function testAlreadyClosed(): void
    {
        $song = $this->createSong();

        $this->expectExceptionMessage('Song download is already closed.');

        $song->closePublicDownload();
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