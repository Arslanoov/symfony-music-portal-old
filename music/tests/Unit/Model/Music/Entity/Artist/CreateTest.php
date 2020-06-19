<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Artist;

use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Artist\Id;
use App\Model\Music\Entity\Artist\Login;
use PHPUnit\Framework\TestCase;

class CreateTest extends TestCase
{
    public function testSuccess(): void
    {
        $artist = new Artist(
            $id = Id::next(),
            $login = new Login('artist login')
        );

        $this->assertEquals($artist->getId(), $id);
        $this->assertEquals($artist->getLogin(), $login);
        $this->assertTrue($artist->getLogin()->isEqual($login));
    }
}