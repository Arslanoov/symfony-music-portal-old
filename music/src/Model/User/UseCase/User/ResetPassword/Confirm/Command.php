<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\ResetPassword\Confirm;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public string $token;
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="32")
     */
    public ?string $newPassword = null;

    public static function byToken(string $token): self
    {
        $command = new self();
        $command->token = $token;
        return $command;
    }
}