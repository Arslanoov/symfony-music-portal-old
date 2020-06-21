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
    public ?string $login = null;
    /**
     * @var string|null
     * @Assert\Email()
     */
    public ?string $email = null;
    /**
     * @var string|null
     * @Assert\NotBlank()
     */
    public ?string $password = null;
    /**
     * @var int|null
     * @Assert\NotBlank()
     */
    public ?int $age = null;
}