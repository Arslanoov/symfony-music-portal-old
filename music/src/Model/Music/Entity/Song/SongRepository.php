<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use App\Model\Exception\EntityNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class SongRepository
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
        $this->repo = $em->getRepository(Song::class);
    }

    public function find(Id $id): ?Song
    {
        /** @var Song $song */
        $song = $this->repo->findOneBy([
            'id' => $id->getValue()
        ]);

        return $song;
    }

    public function get(Id $id): Song
    {
        if (!$song = $this->find($id)) {
            throw new EntityNotFoundException('Song is not found.');
        }

        return $song;
    }

    public function add(Song $song): void
    {
        $this->em->persist($song);
    }
}