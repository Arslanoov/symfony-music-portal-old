<?php

declare(strict_types=1);

namespace App\ReadModel\Music\Album;

use App\Model\Exception\EntityNotFoundException;
use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Album\Status;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\ResultStatement;
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
            ->setMaxResults($limit)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function findMostPopularArtistAlbums(string $artistId, int $limit, bool $canEdit = false): array
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
                'songs_count',
                'download_statistics_all',
                'listen_statistics_all'
            )
            ->from('music_albums')
            ->where('artist_id = :artistId')
            ->setParameter(':artistId', $artistId)
        ;

        if (!$canEdit) {
            $stmt = $stmt
                ->setParameter(':status', Status::STATUS_PUBLIC)
                ->where('status = :status')
            ;
        }

        $stmt = $stmt
            ->orderBy('listen_statistics_all', 'DESC')
            ->setMaxResults($limit)
            ->execute()
        ;

        /** @var ResultStatement $stmt */

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function findRecentArtistAlbums(string $artistId, int $limit, $canEdit = false): array
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
                'songs_count',
                'download_statistics_all',
                'listen_statistics_all'
            )
            ->from('music_albums')
            ->where('artist_id = :artistId')
            ->setParameter(':artistId', $artistId)
        ;

        if (!$canEdit) {
            $stmt = $stmt
                ->setParameter(':status', Status::STATUS_PUBLIC)
                ->where('status = :status')
            ;
        }

        $stmt = $stmt
            ->orderBy('created_date', 'DESC')
            ->setMaxResults($limit)
            ->execute()
        ;

        /** @var ResultStatement $stmt */

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function findShortByTitle(string $title): ?ShortView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'id',
                'title',
                'slug',
                'release_year'
            )
            ->from('music_albums')
            ->where('title = :title')
            ->setParameter(':title', $title)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, ShortView::class);
        $result = $stmt->fetch();

        return $result ?: null;
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
            ->orderBy('release_year', 'DESC')
            ->setMaxResults(20)
            ->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    public function findDetailBySlug(string $slug): DetailView
    {
        $stmt = $this->connection->createQueryBuilder()
            ->select(
                'a.id',
                'a.title',
                'a.slug',
                'a.created_date',
                'a.release_year',
                'a.cover_photo',
                'a.description',
                'a.listen_statistics_all',
                'a.listen_statistics_today',
                'a.listen_statistics_week',
                'a.listen_statistics_month',
                'a.download_statistics_all',
                'a.download_statistics_today',
                'a.download_statistics_week',
                'a.download_statistics_month',
                'a.status',
                'a.type',
                'a.songs_count',
                'u.login'
            )
            ->from('music_albums', 'a')
            ->innerJoin('a', 'user_users', 'u', 'a.artist_id = u.id')
            ->where('slug = :slug')
            ->setParameter(':slug', $slug)
            ->execute();

        $stmt->setFetchMode(FetchMode::CUSTOM_OBJECT, DetailView::class);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function getDetailBySlug(string $slug): DetailView
    {
        if (!$album = $this->findDetailBySlug($slug)) {
            throw new EntityNotFoundException('Album not found.');
        }

        return $album;
    }

    public function getShortBySlug(string $slug): ShortView
    {
        if (!$album = $this->findShortByTitle($slug)) {
            throw new EntityNotFoundException('Album not found.');
        }

        return $album;
    }
}