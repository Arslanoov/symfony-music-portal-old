<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use App\Model\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class AlbumRepository
{
    private EntityManagerInterface $em;
    private ObjectRepository $repository;

    /**
     * AlbumRepository constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Album::class);
    }

    public function find(Id $id): ?Album
    {
        /** @var Album $album */
        $album = $this->repository->findOneBy([
            'id' => $id->getValue()
        ]);

        return $album;
    }

    public function get(Id $id): Album
    {
        if (!$album = $this->find($id)) {
            throw new EntityNotFoundException('Album is not found.');
        }

        return $album;
    }

    public function add(Album $album): void
    {
        $this->em->persist($album);
    }
}