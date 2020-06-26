<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use App\Model\Music\Entity\Artist\Artist;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Album
 * @package App\Model\Music\Entity\Album
 * @ORM\Entity()
 * @ORM\Table(name="music_albums", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"title", "slug"})
 * })
 */
class Album
{
    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="music_album_id")
     */
    private Id $id;
    /**
     * @var Artist
     * @ORM\ManyToOne(targetEntity="App\Model\Music\Entity\Artist\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id", nullable=false)
     */
    private Artist $artist;
    /**
     * @var Title
     * @ORM\Column(type="music_album_title", length=255)
     */
    private Title $title;
    /**
     * @var Slug
     * @ORM\Column(type="music_album_slug", length=255)
     */
    private Slug $slug;
    /**
     * @var DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private DateTimeImmutable $createdDate;
    /**
     * @var ReleaseYear
     * @ORM\Column(type="music_album_release_year")
     */
    private ReleaseYear $releaseYear;
    /**
     * @var CoverPhoto
     * @ORM\Column(type="music_album_cover_photo", length=255, nullable=true)
     */
    private ?CoverPhoto $coverPhoto = null;
    /**
     * @var Description
     * @ORM\Column(type="music_album_description", length=512)
     */
    private Description $description;
    /**
     * @var Status
     * @ORM\Column(type="music_album_status", length=64)
     */
    private Status $status;
    /**
     * @var Type
     * @ORM\Column(type="music_album_type", length=64)
     */
    private Type $type;

    ### create

    public function __construct(
        Id $id, Artist $artist, Title $title,
        Slug $slug, DateTimeImmutable $createdDate, ReleaseYear $releaseYear,
        ?CoverPhoto $coverPhoto, Description $description, Status $status, Type $type
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
        DateTimeImmutable $createdDate, ReleaseYear $releaseYear,
        CoverPhoto $coverPhoto, Description $description, Type $type
    ): self
    {
        return new self(
            $id, $artist, $title,
            Slug::generate($title->getValue()), $createdDate, $releaseYear, $coverPhoto,
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