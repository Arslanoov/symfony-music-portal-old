<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Avatar\Upload;

class Command
{
    public string $id;
    public ?File $file = null;

    public static function byId(string $id): self
    {
        $command = new self();
        $command->id = $id;
        return $command;
    }
}