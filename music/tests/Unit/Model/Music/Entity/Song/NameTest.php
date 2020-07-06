<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Song;

use App\Tests\Builder\Music\SongBuilder;
use App\Model\Music\Entity\Song\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testChange(): void
    {
        $song = (new SongBuilder())
            ->withName($name = new Name('Song name'))
            ->single();

        $this->assertEquals($song->getName(), $name);

        $song->changeName($newName = new Name('New song name'));

        $this->assertNotEquals($song->getName(), $name);
        $this->assertEquals($song->getName(), $newName);
    }

    public function testSame(): void
    {
        $song = (new SongBuilder())
            ->withName($name = new Name('Song name'))
            ->single();

        $this->assertEquals($song->getName(), $name);

        $this->expectExceptionMessage('Name is already same.');
        $song->changeName($newName = new Name('Song name'));
    }
}