<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Artist;

use App\Model\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class ArtistRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repository;

    /**
     * SongRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Artist::class);
    }

    public function add(Artist $song): void
    {
        $this->em->persist($song);
    }

    public function find(Id $id): ?Artist
    {
        /** @var Artist $artist */
        $artist = $this->repository->find($id->getValue());

        return $artist;
    }

    public function get(Id $id): Artist
    {
        if (!$artist = $this->find($id)) {
            throw new EntityNotFoundException('Artist is not found.');
        }

        return $artist;
    }

    public function hasByLogin(string $login): ?Artist
    {
        /**
         * @var Artist|null $artist
         */
        $artist =  $this->repository->findOneBy([
            'login' => $login
        ]);

        return $artist;
    }

    public function getByLogin(string $login): Artist
    {
        /**
         * @var Artist|null $artist
         */
        $artist =  $this->repository->findOneBy([
            'login' => $login
        ]);

        if (!$artist) {
            throw new EntityNotFoundException('Artist is not found.');
        }

        return $artist;
    }
}