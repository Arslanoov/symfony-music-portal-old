<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Genre;

use App\Model\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class GenreRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repository;

    /**
     * GenreRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Genre::class);
    }

    public function get(Id $id): Genre
    {
        if (!$genre = $this->find($id)) {
            throw new EntityNotFoundException('Genre is not found');
        }

        return $genre;
    }

    public function find(Id $id): ?Genre
    {
        /** @var Genre $genre */
        $genre = $this->repository->findOneBy([
            'id' => $id->getValue()
        ]);

        return $genre;
    }

    public function findByName(Name $name): ?Genre
    {
        /** @var Genre $genre */
        $genre = $this->repository->findOneBy([
            'name' => $name->getValue()
        ]);

        return $genre;
    }

    public function existsByName(Name $name): bool
    {
        return (bool) $this->findByName($name);
    }

    public function add(Genre $genre): void
    {
        $this->em->persist($genre);
    }

    public function remove(Genre $genre): void
    {
        $this->em->remove($genre);
    }
}