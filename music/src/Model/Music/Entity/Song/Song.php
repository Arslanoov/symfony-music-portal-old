<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use App\Model\Music\Entity\Album\Album;
use App\Model\Music\Entity\Artist\Artist;
use App\Model\Music\Entity\Genre\Genre;
use DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Song
 * @package App\Model\Music\Entity\Song
 * @ORM\Entity()
 * @ORM\Table(name="music_songs", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"name"})
 * })
 */
class Song
{
    /**
     * @var Id
     * @ORM\Column(type="music_song_id")
     * @ORM\Id()
     */
    private Id $id;
    /**
     * @var Artist
     * @ORM\ManyToOne(targetEntity="\App\Model\Music\Entity\Artist\Artist", inversedBy="songs")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private Artist $artist;
    /**
     * @var Album
     * @ORM\ManyToOne(targetEntity="\App\Model\Music\Entity\Album\Album", inversedBy="songs")
     * @ORM\JoinColumn(name="album_id", referencedColumnName="id", nullable=true, onDelete="CASCADE")
     */
    private ?Album $album = null;
    /**
     * @var Genre
     * @ORM\ManyToOne(targetEntity="\App\Model\Music\Entity\Genre\Genre", inversedBy="songs")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id", nullable=false, onDelete="SET NULL")
     */
    private Genre $genre;
    /**
     * @var DownloadUrl|null
     * @ORM\Column(type="music_song_download_url", nullable=false)
     */
    private ?DownloadUrl $downloadUrl = null;
    /**
     * @var DownloadStatus
     * @ORM\Column(type="music_song_download_status")
     */
    private DownloadStatus $downloadStatus;
    /**
     * @var Date
     * @ORM\Embedded(class="Date", columnPrefix="date_")
     */
    private Date $date;
    /**
     * @var Name
     * @ORM\Column(type="music_song_name")
     */
    private Name $name;
    /**
     * @var File
     * @ORM\Embedded(class="File", columnPrefix="file_")
     */
    private File $file;
    /**
     * @var Status
     * @ORM\Column(type="music_song_status")
     */
    private Status $status;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $viewsCount = 0;

    public function __construct(
        Id $id, Artist $artist, Genre $genre, Date $date,
        Name $name, File $file, Status $status,
        DownloadStatus $downloadStatus,
        ?Album $album = null,
        ?DownloadUrl $downloadUrl = null,
        int $viewsCount = 0
    )
    {
        $this->id = $id;
        $this->artist = $artist;
        $this->genre = $genre;
        $this->date = $date;
        $this->name = $name;
        $this->file = $file;
        $this->status = $status;
        $this->album = $album;
        $this->downloadStatus = $downloadStatus;
        $this->downloadUrl = $downloadUrl;
        $this->viewsCount = $viewsCount;
    }

    public static function forAlbum(
        Id $id, Artist $artist, Genre $genre, Date $date,
        Name $name, File $file, Album $album
    ): self
    {
        return new self(
            $id, $artist, $genre, $date, $name, $file,
            Status::moderated(),
            DownloadStatus::draft(), $album
        );
    }

    public static function single(
        Id $id, Artist $artist, Date $date,
        Name $name, File $file
    ): self
    {
        return new self(
            $id, $artist, $date,
            $name, $file, Status::moderated(),
            DownloadStatus::draft()
        );
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Artist
     */
    public function getArtist(): Artist
    {
        return $this->artist;
    }

    /**
     * @return Date
     */
    public function getDateInfo(): Date
    {
        return $this->date;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Album
     */
    public function getAlbum(): Album
    {
        return $this->album;
    }

    /**
     * @return Genre
     */
    public function getGenre(): Genre
    {
        return $this->genre;
    }

    /**
     * @return DownloadUrl|null
     */
    public function getDownloadUrl(): ?DownloadUrl
    {
        return $this->downloadUrl;
    }

    /**
     * @return DownloadStatus
     */
    public function getDownloadStatus(): DownloadStatus
    {
        return $this->downloadStatus;
    }

    /**
     * @return Date
     */
    public function getDate(): Date
    {
        return $this->date;
    }

    /**
     * @return int
     */
    public function getViewsCount(): int
    {
        return $this->viewsCount;
    }

    ### actions

    public function changeDownloadUrl(DownloadUrl $downloadUrl): void
    {
        $this->downloadUrl = $downloadUrl;
    }

    public function openPublicDownload(): void
    {
        $this->downloadStatus = DownloadStatus::public();
    }

    public function closePublicDownload(): void
    {
        $this->downloadStatus = DownloadStatus::draft();
    }

    public function view(): void
    {
        $this->viewsCount += 1;
    }

    public function changeName(Name $name): void
    {
        if ($this->name->isEqual($name)) {
            throw new DomainException('Name is already same.');
        }

        $this->name = $name;
    }

    public function makePublic(): void
    {
        if ($this->status->isPublic()) {
            throw new DomainException('Status is already same.');
        }

        $this->status = Status::public();
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new DomainException('Status is already same.');
        }

        $this->status = Status::archived();
    }
}