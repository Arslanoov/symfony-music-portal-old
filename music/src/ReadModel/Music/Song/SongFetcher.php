<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Song;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use App\Model\Music\Entity\Song\Song;

final class SongFetcher
{
    private Connection $connection;
    private ObjectRepository $repository;

    /**
     * SongFetcher constructor.
     * @param Connection $connection
     * @param EntityManagerInterface $em
     */
    public function __construct(Connection $connection, EntityManagerInterface $em)
    {
        $this->connection = $connection;
        $this->repository = $em->getRepository(Song::class);
    }

    public function findByArtist(string $artistId, int $limit): array
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.date_upload',
                's.date_update',
                's.name',
                's.file_path',
                's.status',
                's.download_status',
                's.download_url',
                'a.title',
                'a.slug'
            )
            ->from('music_songs', 's')
            ->innerJoin('s', 'music_albums', 'a', 's.album_id = a.id')
            ->where('s.artist_id = :artistId')
            ->setParameter(':artistId', $artistId)
            ->setMaxResults($limit)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}