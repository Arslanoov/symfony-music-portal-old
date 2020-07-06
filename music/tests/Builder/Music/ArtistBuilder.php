<?php

declare(strict_types=1);

namespace App\Tests\Builder\Music;

use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Artist\Id;
use App\Model\Music\Entity\Artist\Login;

final class ArtistBuilder
{
    private Id $id;
    private Login $login;

    public function __construct()
    {
        $this->id = Id::next();
        $this->login = new Login('Artist login');
    }

    public function withId(Id $id): self
    {
        $builder = clone $this;
        $this->id = $id;
        return $builder;
    }

    public function withLogin(Login $login): self
    {
        $builder = clone $this;
        $this->login = $login;
        return $builder;
    }

    public function build(): Artist
    {
        return new Artist(
            $this->id,
            $this->login
        );
    }
}