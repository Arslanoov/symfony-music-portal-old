<?php

declare(strict_types=1);

namespace App\Unit\Model\Entity\Artist;

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

        $this->assertEquals($artist->getId()->getValue(), $id->getValue());
        $this->assertTrue($artist->getId()->isEqual($id));
        $this->assertEquals($artist->getLogin()->getValue(), $login->getValue());
        $this->assertTrue($artist->getLogin()->isEqual($login));
    }
}