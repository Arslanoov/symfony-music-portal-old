<?php

declare(strict_types=1);

namespace App\Unit\Model\Music\Entity\Genre;

use App\Model\Music\Entity\Genre\Genre;
use App\Model\Music\Entity\Genre\Id;
use App\Model\Music\Entity\Genre\Name;
use App\Model\Music\Entity\Genre\Slug;
use PHPUnit\Framework\TestCase;

class PopularityTest extends TestCase
{
    public function testSuccess(): void
    {
        $genreMorePopular = new Genre(
            Id::next(),
            new Name('Name'),
            Slug::generate('Slug'),
            $songsCount1 = 56
        );

        $genreLessPopular = new Genre(
            Id::next(),
            new Name('Name1'),
            Slug::generate('Slug1'),
            $songsCount1 = 19
        );

        $this->assertTrue($genreMorePopular->isMorePopularThan($genreLessPopular));
        $this->assertFalse($genreLessPopular->isMorePopularThan($genreMorePopular));

        $this->assertTrue($genreLessPopular->isLessPopularThan($genreMorePopular));
        $this->assertFalse($genreMorePopular->isLessPopularThan($genreLessPopular));
    }
}