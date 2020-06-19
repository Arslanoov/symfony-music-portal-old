<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

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

    public function add(Song $song): void
    {
        $this->em->persist($song);
    }
}