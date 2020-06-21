<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $identity): void
    {
        if (!$identity instanceof UserIdentity) {
            return;
        }

        if ($identity->isWait()) {
            $exception = new DisabledException('User account is not activated.');
            $exception->setUser($identity);
            throw $exception;
        }

        if ($identity->isBanned()) {
            $exception = new DisabledException('User account is banned.');
            $exception->setUser($identity);
            throw $exception;
        }
    }

    public function checkPostAuth(UserInterface $identity): void
    {
        if (!$identity instanceof UserIdentity) {
            return;
        }
    }
}
