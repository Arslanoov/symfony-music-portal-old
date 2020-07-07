<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Song\Upload\Single;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $artistLogin;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="32")
     */
    public ?string $name = null;
    /**
     * @var string|null
     * Assert\NotBlank()
     * @Assert\Length(min="32", max="64")
     */
    public ?string $genre = null;
    /**
     * @var Photo|null
     * @Assert\File(maxSize="4096k", mimeTypes={"image/jpeg", "image/png"}, mimeTypesMessage="Please upload a valid image file.")
     */
    public $coverPhoto = null;
    /**
     * @var File|null
     * @Assert\NotBlank()
     * @Assert\File(maxSize="20480k", mimeTypes={"audio/x-wav", "audio/mpeg"}, mimeTypesMessage="Please upload a valid song file.")
     */
    public $file = null;

    public static function byArtist(string $artistLogin): self
    {
        $command = new self();
        $command->artistLogin = $artistLogin;
        return $command;
    }
}