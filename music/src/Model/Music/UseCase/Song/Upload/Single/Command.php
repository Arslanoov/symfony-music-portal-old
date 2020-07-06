<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\Single;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Artist\Artist;

class Command
{
    public string $artistLogin;
    public ?File $file = null;
    public ?string $name = null;

    /**
     * Command constructor.
     * @param string $artistLogin
     */
    public function __construct(string $artistLogin)
    {
        $this->artistLogin = $artistLogin;
    }
}