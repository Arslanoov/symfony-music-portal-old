<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Genre;

use DomainException;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Genre
 * @package App\Model\Music\Entity\Genre
 * @ORM\Entity()
 * @ORM\Table(name="music_genres", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"name", "slug"})
 * })
 */
class Genre
{
    /**
     * @var Id
     * @ORM\Id()
     * @ORM\Column(type="music_genre_id")
     */
    private Id $id;
    /**
     * @var Name
     * @ORM\Column(type="music_genre_name", length=255)
     */
    private Name $name;
    /**
     * @var Slug
     * @ORM\Column(type="music_genre_slug", length=255)
     */
    private Slug $slug;
    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $songsCount;

    /**
     * Genre constructor.
     * @param Id $id
     * @param Name $name
     * @param Slug $slug
     * @param int $songsCount
     */
    public function __construct(Id $id, Name $name, Slug $slug, int $songsCount)
    {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
        $this->songsCount = $songsCount;
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Slug
     */
    public function getSlug(): Slug
    {
        return $this->slug;
    }

    public function edit(Name $name): void
    {
        $this->name = $name;
        $this->slug = Slug::generate($name->getValue());
    }

    /**
     * @return int
     */
    public function getSongsCount(): int
    {
        return $this->songsCount;
    }

    public function increaseSongCount(): void
    {
        $this->songsCount += 1;
    }

    public function reduceSongCount(): void
    {
        if ($this->songsCount <= 0) {
            throw new DomainException('Unknown error.');
        }
        $this->songsCount -= 1;
    }

    public function isMorePopularThan(Genre $genre): bool
    {
        return $this->songsCount > $genre->getSongsCount();
    }

    public function isLessPopularThan(Genre $genre): bool
    {
        return $this->songsCount < $genre->getSongsCount();
    }
}