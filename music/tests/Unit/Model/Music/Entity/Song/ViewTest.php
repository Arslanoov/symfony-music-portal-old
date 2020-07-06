<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\Music\Entity\Song;

use App\Model\Music\Entity\Song\Song;
use App\Tests\Builder\Music\SongBuilder;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{
    public function testSuccess(): void
    {
        $song = $this->createSong();

        $this->assertEquals($song->getViewsCount(), 0);

        $song->view();

        $this->assertEquals($song->getViewsCount(), 1);
    }

    private function createSong(): Song
    {
        return (new SongBuilder())
            ->single();
    }
}