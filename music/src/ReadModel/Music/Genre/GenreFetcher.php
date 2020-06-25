<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Genre;

use App\Model\Music\Entity\Genre\Genre;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

class GenreFetcher
{
    private Connection $connection;
    private ObjectRepository $repository;

    /**
     * GenreFetcher constructor.
     * @param Connection $connection
     * @param EntityManagerInterface $em
     */
    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Genre::class);
    }

    public function all(): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'name',
                'slug',
                'songs_count'
            )
            ->from('music_genres')
            ->orderBy('songs_count', 'DESC')
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}