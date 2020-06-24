<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\ResetPassword\Request;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\TokenGenerator;
use App\Model\User\Service\TokenSender;
use DateTimeImmutable;

class Handler
{
    private TokenGenerator $tokenGenerator;
    private TokenSender $tokenSender;
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param TokenGenerator $tokenGenerator
     * @param TokenSender $tokenSender
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(TokenGenerator $tokenGenerator, TokenSender $tokenSender, UserRepository $users, Flusher $flusher)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenSender = $tokenSender;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->users->getByEmail(new Email($command->email));

        $user->requestPasswordReset(
            $this->tokenGenerator->generate(),
            new DateTimeImmutable()
        );

        $this->tokenSender->send($user->getLogin(), $user->getEmail(), $user->getResetPasswordToken());

        $this->flusher->flush();
    }
}