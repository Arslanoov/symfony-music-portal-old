<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Fill\AboutMe;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     */
    public string $id;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(max="500")
     */
    public ?string $aboutMe = null;

    public static function fromId(string $id): self
    {
        $command = new self();
        $command->id = $id;
        return $command;
    }
}