<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Fill\Login;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public ?string $login = null;

    public static function byId(string $id): self
    {
        $command = new self();
        $command->id = $id;
        return $command;
    }
}