<?php

declare(strict_types=1);

namespace App\Model\Music\UseCase\Genre\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min="2", max="32")
     */
    public string $name;
}