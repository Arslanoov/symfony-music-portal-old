<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\User\SignUp\ByEmail\Request;

use App\Model\Flusher;
use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\Info;
use App\Model\User\Entity\User\Login;
use App\Model\User\Entity\User\Password;
use App\Model\User\Entity\User\User;
use App\Model\User\Entity\User\UserRepository;
use App\Model\User\Service\HasherInterface;
use App\Model\User\Service\TokenGenerator;
use App\Model\User\Service\TokenSender;
use DomainException;
use Exception;

class Handler
{
    private TokenGenerator $tokenGenerator;
    private TokenSender $tokenSender;
    private HasherInterface $hasher;
    private UserRepository $users;
    private Flusher $flusher;

    /**
     * Handler constructor.
     * @param TokenGenerator $tokenGenerator
     * @param TokenSender $tokenSender
     * @param HasherInterface $hasher
     * @param UserRepository $users
     * @param Flusher $flusher
     */
    public function __construct(TokenGenerator $tokenGenerator, TokenSender $tokenSender, HasherInterface $hasher, UserRepository $users, Flusher $flusher)
    {
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenSender = $tokenSender;
        $this->hasher = $hasher;
        $this->users = $users;
        $this->flusher = $flusher;
    }

    /**
     * @param Command $command
     * @throws Exception
     */
    public function handle(Command $command): void
    {
        if ($this->users->existsByLogin($login = new Login($command->login))) {
            throw new DomainException('User with this login already exists.');
        }
        if ($this->users->existsByEmail($email = new Email($command->email))) {
            throw new DomainException('User with this email already exists.');
        }

        $user = User::signUpByEmail(
            Id::next(),
            $login,
            $email,
            new Password($this->hasher->hash($command->password)),
            new Info($command->age),
            $token = $this->tokenGenerator->generate()
        );

        $this->tokenSender->send($login, $email, $token);

        $this->users->add($user);

        $this->flusher->flush();
    }
}