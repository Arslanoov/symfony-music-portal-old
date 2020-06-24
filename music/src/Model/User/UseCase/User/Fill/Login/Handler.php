<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\Fill\Login;

use App\Model\Flusher;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\UserRepository;
use DomainException;

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
        if ($this->users->existsByLogin($login = new Login($command->login))) {
            throw new DomainException('User with this login already exists.');
        }

        $user = $this->users->get(new Id($command->id));

        $user->changeLogin($login);

        $this->flusher->flush();
    }
}