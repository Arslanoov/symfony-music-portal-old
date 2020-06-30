<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\SignUp\ByEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    public ?string $id = null;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="4", max="32")
     */
    public ?string $login = null;
    /**
     * @var string|null
     * @Assert\Email()
     * @Assert\Length(min="4", max="64")
     */
    public ?string $email = null;
    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min="5", max="32")
     */
    public ?string $password = null;
    /**
     * @var int|null
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(7)
     * @Assert\LessThan(99)
     */
    public ?int $age = null;

    public static function byId(string $id): self
    {
        $command = new self();
        $command->id = $id;
        return $command;
    }
}