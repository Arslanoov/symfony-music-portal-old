<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Artist;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Artist
 * @package App\Model\Music\Entity\Artist
 * @ORM\Entity()
 * @ORM\Table(name="music_artists", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"login"})
 * })
 *
 */
class Artist
{
    /**
     * @var Id
     * @ORM\Column(type="music_artist_id")
     * @ORM\Id()
     */
    private Id $id;
    /**
     * @var Login
     * @ORM\Column(type="music_artist_login")
     */
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