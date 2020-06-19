<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Artist;

use App\Model\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ArtistRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repo;

    /**
     * SongRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $em->getRepository(Artist::class);
    }

    public function add(Artist $song): void
    {
        $this->em->persist($song);
    }

    public function hasByLogin(string $login): ?Artist
    {
        /**
         * @var Artist|null $artist
         */
        $artist =  $this->repo->findOneBy([
            'login' => $login
        ]);

        return $artist;
    }

    public function getByLogin(string $login): Artist
    {
        /**
         * @var Artist|null $artist
         */
        $artist =  $this->repo->findOneBy([
            'login' => $login
        ]);

        if (!$artist) {
            throw new EntityNotFoundException('Artist is not found.');
        }

        return $artist;
    }
}