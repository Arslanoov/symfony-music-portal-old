<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Artist;

class Artist
{
    private Id $id;
    private Login $login;

    public function __construct(Id $id, Login $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }
}