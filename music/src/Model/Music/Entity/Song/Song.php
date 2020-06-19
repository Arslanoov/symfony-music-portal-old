<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

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

    public function __construct(Id $id, Artist $artist, Date $date, Name $name, File $file)
    {
        $this->id = $id;
        $this->artist = $artist;
        $this->date = $date;
        $this->name = $name;
        $this->file = $file;
        $this->status = Status::moderated();
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