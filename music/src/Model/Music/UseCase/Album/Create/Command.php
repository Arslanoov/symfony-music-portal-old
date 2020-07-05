<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Album\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $artistId;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=255)
     */
    public ?string $title = null;
    /**
     * @var int|null
     * @Assert\NotBlank()
     * @Assert\GreaterThan(1500)
     * @Assert\LessThan(2100)
     */
    public ?int $releaseYear = null;
    /**
     * @var File|null
     * @Assert\Valid()
     */
    public ?File $coverPhoto = null;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=1, max=512)
     */
    public ?string $description = null;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=64)
     */
    public ?string $type = null;

    public static function byArtistId(string $artistId): self
    {
        $command = new self();
        $command->artistId = $artistId;
        return $command;
    }
}