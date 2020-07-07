<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Song;

use App\Model\Music\Entity\Song\Status;
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

    public function findByArtist(string $artistId, bool $canEdit, int $limit): array
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
                's.cover_photo',
                's.views_count',
                'a.title AS album_title',
                'a.slug AS album_slug',
                'a.cover_photo AS album_cover_photo'
            )
            ->from('music_songs', 's')
            ->leftJoin('s', 'music_albums', 'a', 's.album_id = a.id')
            ->where('s.artist_id = :artistId')
            ->setParameter(':artistId', $artistId);

        if (!$canEdit) {
            $stmt = $stmt
                ->where('status', ':status')
                ->setParameter(':status', Status::STATUS_PUBLIC);
        }

        $stmt = $stmt
            ->setMaxResults($limit)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }
}