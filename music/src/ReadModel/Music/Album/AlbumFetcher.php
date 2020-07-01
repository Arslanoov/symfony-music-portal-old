<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Album;

use App\Model\Music\Entity\Album\Album;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class AlbumFetcher
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
        $this->repository = $em->getRepository(Album::class);
    }

    public function findByArtistLimit(string $artistId, int $limit = 3): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'created_date',
                'release_year',
                'cover_photo',
                'status',
                'type',
                'songs_count'
            )
            ->from('music_albums')
            ->where('artist_id = :artistId')
            ->setParameter(':artistId', $artistId)
            ->orderBy('created_date', 'DESC')
            ->setMaxResults(5)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function findByArtist(string $artistId): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'created_date',
                'release_year',
                'cover_photo',
                'description',
                'listen_statistics_all',
                'download_statistics_all',
                'status',
                'type',
                'songs_count'
            )
            ->from('music_albums')
            ->where('artist_id = :artistId')
            ->setParameter(':artistId', $artistId)
            ->orderBy('created_date', 'DESC')
            ->setMaxResults(20)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}