<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use App\Model\Music\Entity\Artist\Artist;
use DateTimeImmutable;

class Album
{
    private Id $id;
    private Artist $artist;
    private Title $title;
    private Slug $slug;
    private DateTimeImmutable $createdDate;
    private ReleaseYear $releaseYear;
    private CoverPhoto $coverPhoto;
    private Description $description;
    private Status $status;
    private Type $type;

    ### create

    public function __construct(
        Id $id, Artist $artist, Title $title,
        Slug $slug, DateTimeImmutable $createdDate, ReleaseYear $releaseYear,
        CoverPhoto $coverPhoto, Description $description, Status $status, Type $type
    )
    {
        $this->id = $id;
        $this->artist = $artist;
        $this->title = $title;
        $this->slug = $slug;
        $this->createdDate = $createdDate;
        $this->releaseYear = $releaseYear;
        $this->coverPhoto = $coverPhoto;
        $this->description = $description;
        $this->status = $status;
        $this->type = $type;
    }

    public static function new(
        Id $id, Artist $artist, Title $title,
        Slug $slug, DateTimeImmutable $createdDate, ReleaseYear $releaseYear,
        CoverPhoto $coverPhoto, Description $description, Type $type
    ): self
    {
        return new self(
            $id, $artist, $title,
            $slug, $createdDate, $releaseYear, $coverPhoto,
            $description, Status::moderated(), $type
        );
    }

    ### getters

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
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Slug
     */
    public function getSlug(): Slug
    {
        return $this->slug;
    }

    /**
     * @return ReleaseYear
     */
    public function getReleaseYear(): ReleaseYear
    {
        return $this->releaseYear;
    }

    /**
     * @return Description
     */
    public function getDescription(): Description
    {
        return $this->description;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreatedDate(): DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     * @return CoverPhoto
     */
    public function getCoverPhoto(): CoverPhoto
    {
        return $this->coverPhoto;
    }

    ### actions

    public function makePublic(): void
    {
        $this->status = Status::public();
    }

    public function archive(): void
    {
        $this->status = Status::archived();
    }
}