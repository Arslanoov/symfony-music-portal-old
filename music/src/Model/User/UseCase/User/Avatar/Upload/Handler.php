<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Avatar\Upload;

use App\Model\Flusher;
use App\Model\User\Entity\User\Avatar;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\UserRepository;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->get(new Id($command->id));

        $user->uploadAvatar(
            new Avatar(
                $command->file->getPath() . '/' .
                $command->file->getName()
            )
        );

        $this->flusher->flush();
    }
}