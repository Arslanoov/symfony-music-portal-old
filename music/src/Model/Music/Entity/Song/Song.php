<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Song;

use App\Model\Music\Entity\Artist\Artist;
use DomainException;

class Song
{
    private Id $id;
    private Artist $artist;
    private Date $date;
    private Name $name;
    private File $file;
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