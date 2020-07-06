<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\ForAlbum;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Artist\Artist;

class Command
{
    public string $artistLogin;
    public string $albumSlug;
    public ?File $file = null;
    public ?string $name = null;

    /**
     * Command constructor.
     * @param string $artistLogin
     * @param string $albumSlug
     */
    public function __construct(string $artistLogin, string $albumSlug)
    {
        $this->artistLogin = $artistLogin;
        $this->albumSlug = $albumSlug;
    }
}