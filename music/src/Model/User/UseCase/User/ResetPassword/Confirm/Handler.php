<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\ResetPassword\Confirm;

use App\Model\Flusher;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\HasherInterface;
use App\Model\User\Service\TokenGenerator;
use App\Model\User\Service\TokenSender;

class Handler
{
    private HasherInterface $hasher;
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param HasherInterface $hasher
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(HasherInterface $hasher, UserRepository $users, Flusher $flusher)
    {
        $this->hasher = $hasher;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getByPasswordToken($command->token);

        $user->changePassword(
            new Password($this->hasher->hash($command->newPassword))
        );

        $this->flusher->flush();
    }
}