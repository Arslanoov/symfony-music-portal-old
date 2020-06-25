<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Genre\Edit;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="32")
     */
    public ?string $name = null;

    public static function byId(string $id): self
    {
        $command = new self();
        $command->id = $id;
        return $command;
    }
}